<?php
/**
 * Composer Installer for Pro WordPress Plugins.
 *
 * @package Junaidbhura\Composer\WPProPlugins
 */

namespace Junaidbhura\Composer\WPProPlugins;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Package\PackageInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PreFileDownloadEvent;
use Composer\Plugin\PrePoolCreateEvent;
use Dotenv\Dotenv;

/**
 * Custom Installer Class.
 */
class Installer implements PluginInterface, EventSubscriberInterface {

	/**
	 * @var Composer
	 */
	protected $composer;

	/**
	 * @var IOInterface
	 */
	protected $io;

	/**
	 * @var string|null
	 */
	protected $downloadUrl;

	/**
	 * Activate plugin.
	 *
	 * @param Composer    $composer
	 * @param IOInterface $io
	 * @return void
	 */
	public function activate( Composer $composer, IOInterface $io ) {
		$this->composer = $composer;
		$this->io       = $io;

		$path = getcwd();
		if ( is_string( $path ) && file_exists( $path . DIRECTORY_SEPARATOR . '.env' ) ) {
			$this->loadDotenv( $path );
		}
	}

	/**
	 * Deactivate plugin.
	 *
	 * @param Composer    $composer
	 * @param IOInterface $io
	 * @return void
	 */
	public function deactivate( Composer $composer, IOInterface $io ) {
		// no need to deactivate anything
	}

	/**
	 * Uninstall plugin.
	 *
	 * @param Composer    $composer
	 * @param IOInterface $io
	 * @return void
	 */
	public function uninstall( Composer $composer, IOInterface $io ) {
		// no need to uninstall anything
	}

	/**
	 * Activate vlucas/phpdotenv, if available.
	 *
	 * @param string $path
	 * @return void
	 */
	protected function loadDotenv( $path ) {
		// Dotenv V5
		if ( method_exists( 'Dotenv\\Dotenv', 'createUnsafeImmutable' ) ) {
			$dotenv = Dotenv::createUnsafeImmutable( $path );
			$dotenv->safeLoad();
			return;
		}

		// Dotenv V4
		if ( method_exists( 'Dotenv\\Dotenv', 'createImmutable' ) ) {
			$dotenv = Dotenv::createImmutable( $path );
			$dotenv->safeLoad();
			return;
		}

		// Dotenv V3
		if ( method_exists( 'Dotenv\\Dotenv', 'create' ) ) {
			$dotenv = Dotenv::create( $path );
			$dotenv->safeLoad();
			return;
		}
	}

	/**
	 * Set subscribed events.
	 *
	 * @return array<string, (string|array{string, int})>
	 */
	public static function getSubscribedEvents() {
		if ( version_compare( PluginInterface::PLUGIN_API_VERSION, '2.0.0', '<' ) ) {
			return array(
				PackageEvents::PRE_PACKAGE_INSTALL => 'onPrePackageInstallOrUpdateInComposer1',
				PackageEvents::PRE_PACKAGE_UPDATE  => 'onPrePackageInstallOrUpdateInComposer1',
				PluginEvents::PRE_FILE_DOWNLOAD    => array( 'onPreFileDownloadInComposer1', -1 ),
			);
		}

		return array(
			PluginEvents::PRE_FILE_DOWNLOAD => array( 'onPreFileDownloadInComposer2', -1 ),
		);
	}

	/**
	 * Prepare the dist URL of supported packages in Composer v1.
	 *
	 * In Composer v1, the {@see self::$downloadUrl} is used to track the
	 * processed URL during the iteration of each install/update of a package.
	 * This is necessary because the `PRE_FILE_DOWNLOAD` event does not receive
	 * the package as a context.
	 *
	 * @param PackageEvent $event
	 * @return void
	 */
	public function onPrePackageInstallOrUpdateInComposer1( PackageEvent $event ) {
		$this->downloadUrl = null;

		$operation = $event->getOperation();
		if ( 'update' === $operation->getJobType() ) {
			$package = $operation->getTargetPackage();
		} else {
			$package = $operation->getPackage();
		}

		$download_url = $this->getDownloadUrl( $package );
		if ( ! empty( $download_url ) ) {
			$this->downloadUrl = $download_url;

			$dist_url = $package->getDistUrl();
			if ( is_string( $dist_url ) ) {
				$filtered_url = $this->filterDistUrl( $dist_url, $package );
				$package->setDistUrl( $filtered_url );
			}
		}
	}

	/**
	 * Prepare the download URL in Composer v1.
	 *
	 * In Composer v1, packages are downloaded, installed/updated, sequentially.
	 *
	 * @param PreFileDownloadEvent $event
	 * @return void
	 */
	public function onPreFileDownloadInComposer1( PreFileDownloadEvent $event ) {
		if ( empty( $this->downloadUrl ) ) {
			return;
		}

		$_remote_filesystem = $event->getRemoteFilesystem();
		$remote_filesystem  = new RemoteFilesystem(
			$this->downloadUrl,
			$this->io,
			$this->composer->getConfig(),
			$_remote_filesystem->getOptions(),
			$_remote_filesystem->isTlsDisabled()
		);
		$event->setRemoteFilesystem( $remote_filesystem );
	}

	/**
	 * Prepare the download URL in Composer v2.
	 *
	 * In Composer v2, all packages get downloaded first,
	 * then prepared, then installed/updated.
	 *
	 * @param PreFileDownloadEvent $event
	 * @return void
	 */
	public function onPreFileDownloadInComposer2( PreFileDownloadEvent $event ) {
		/**
		 * Bail early if this event is not for a package.
		 *
		 * @see https://github.com/composer/composer/pull/8975
		 */
		if ( $event->getType() !== 'package' ) {
			return;
		}

		$package = $event->getContext();
		if ( ! $package instanceof PackageInterface ) {
			return;
		}

		$processed_url = $event->getProcessedUrl();
		$download_url  = $this->getDownloadUrl( $package );

		if ( $download_url ) {
			$filtered_url = $this->filterDistUrl( $processed_url, $package );

			$event->setProcessedUrl( $download_url );
			$event->setCustomCacheKey( $filtered_url );
			$package->setDistUrl( $filtered_url );
		}
	}

	/**
	 * Filter the dist URL for a given package.
	 *
	 * The filtered dist URL is stored inside `composer.lock` and is used
	 * to generate the cache key for the requested package version.
	 *
	 * @param string           $url
	 * @param PackageInterface $package
	 *
	 * @return string The filtered dist URL.
	 */
	protected function filterDistUrl( $url, PackageInterface $package ) {
		$package_key = sha1( $package->getUniqueName() );
		if ( false === strpos( $url, $package_key ) ) {
			$url .= '#' . $package_key;
		}

		return $url;
	}

	/**
	 * Get download URL for our plugins.
	 *
	 * @param PackageInterface $package
	 *
	 * @return ?string The plugin download URL.
	 */
	protected function getDownloadUrl( PackageInterface $package ) {
		$plugin       = null;
		$package_name = $package->getName();
		$plugin_name  = str_replace( 'junaidbhura/', '', $package_name );

		switch ( $package_name ) {
			case 'junaidbhura/acf-extended-pro':
				$plugin = new Plugins\AcfExtendedPro( $package->getPrettyVersion(), $plugin_name );
				break;

			case 'junaidbhura/advanced-custom-fields-pro':
				$plugin = new Plugins\AcfPro( $package->getPrettyVersion(), $plugin_name );
				break;

			case 'junaidbhura/polylang-pro':
				$plugin = new Plugins\PolylangPro( $package->getPrettyVersion(), $plugin_name );
				break;

			case 'junaidbhura/wp-all-import-pro':
			case 'junaidbhura/wp-all-export-pro':
				$plugin = new Plugins\WpAiPro( $package->getPrettyVersion(), $plugin_name );
				break;

			default:
				if ( 0 === strpos( $package_name, 'junaidbhura/gravityforms' ) ) {
					$plugin = new Plugins\GravityForms( $package->getPrettyVersion(), $plugin_name );
				} elseif ( 0 === strpos( $package_name, 'junaidbhura/ninja-forms-' ) ) {
					$plugin = new Plugins\NinjaForms( $package->getPrettyVersion(), $plugin_name );
				} elseif ( 0 === strpos( $package_name, 'junaidbhura/publishpress-' ) ) {
					$plugin = new Plugins\PublishPressPro( $package->getPrettyVersion(), $plugin_name );
				} elseif ( 0 === strpos( $package_name, 'junaidbhura/wpai-' ) || 0 === strpos( $package_name, 'junaidbhura/wpae-' ) ) {
					$plugin = new Plugins\WpAiPro( $package->getPrettyVersion(), $plugin_name );
				} elseif ( 0 === strpos( $package_name, 'junaidbhura/wpml-' ) ) {
					$plugin = new Plugins\Wpml( $package->getPrettyVersion(), $plugin_name );
				}
		}

		if ( ! empty( $plugin ) ) {
			return $plugin->getDownloadUrl();
		}

		return null;
	}

}
