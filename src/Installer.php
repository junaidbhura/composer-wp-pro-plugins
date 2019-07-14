<?php
/**
 * Composer Installer for Pro WordPress Plugins.
 *
 * @package Junaidbhura\Composer\WPProPlugins
 */

namespace Junaidbhura\Composer\WPProPlugins;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;
use Dotenv\Dotenv;

/**
 * Custom Installer Class.
 */
class Installer implements PluginInterface, EventSubscriberInterface {

	protected $composer;
	protected $io;
	protected $downloadUrl;

	/**
	 * Activate plugin.
	 *
	 * @param Composer    $composer
	 * @param IOInterface $io
	 */
	public function activate( Composer $composer, IOInterface $io ) {
		$this->composer = $composer;
		$this->io       = $io;

		if ( file_exists( getcwd() . DIRECTORY_SEPARATOR . '.env' ) ) {
			$dotenv = Dotenv::create( getcwd() );
			$dotenv->load();
		}
	}

	/**
	 * Set subscribed events.
	 *
	 * @return array
	 */
	public static function getSubscribedEvents() {
		return array(
			PackageEvents::PRE_PACKAGE_INSTALL => 'getDownloadUrl',
			PackageEvents::PRE_PACKAGE_UPDATE => 'getDownloadUrl',
			PluginEvents::PRE_FILE_DOWNLOAD => 'onPreFileDownload',
		);
	}

	/**
	 * Get package from operation.
	 *
	 * @param OperationInterface $operation
	 * @return mixed
	 */
	protected function getPackageFromOperation( OperationInterface $operation ) {
		if ( $operation instanceof UpdateOperation ) {
			return $operation->getTargetPackage();
		}
		return $operation->getPackage();
	}

	/**
	 * Get download URL for our plugins.
	 *
	 * @param PackageEvent $event
	 */
	public function getDownloadUrl( PackageEvent $event ) {
		$this->downloadUrl = '';
		$package           = $this->getPackageFromOperation( $event->getOperation() );
		$plugin            = false;
		$package_name      = $package->getName();

		switch ( $package_name ) {

			case 'junaidbhura/advanced-custom-fields-pro':
				$plugin = new Plugins\AcfPro( $package->getPrettyVersion() );
				break;

			case 'junaidbhura/polylang-pro':
				$plugin = new Plugins\PolylangPro( $package->getPrettyVersion() );
				break;

			case 'junaidbhura/wp-all-import-pro':
			case 'junaidbhura/wp-all-export-pro':
				$plugin = new Plugins\WpAiPro( $package->getPrettyVersion(), str_replace( 'junaidbhura/', '', $package_name ) );
				break;

			default:
				if ( 0 === strpos( $package_name, 'junaidbhura/gravityforms' ) ) {
					$plugin = new Plugins\GravityForms( $package->getPrettyVersion(), str_replace( 'junaidbhura/', '', $package_name ) );
				} elseif ( 0 === strpos( $package_name, 'junaidbhura/wpai-' ) ) {
					$plugin = new Plugins\WpAiPro( $package->getPrettyVersion(), str_replace( 'junaidbhura/', '', $package_name ) );
				}

		}

		if ( ! empty( $plugin ) ) {
			$this->downloadUrl = $plugin->getDownloadUrl();
		}
	}

	/**
	 * Process our plugin downloads.
	 *
	 * @param PreFileDownloadEvent $event
	 */
	public function onPreFileDownload( PreFileDownloadEvent $event ) {
		if ( empty( $this->downloadUrl ) ) {
			return;
		}

		$rfs       = $event->getRemoteFilesystem();
		$customRfs = new RemoteFilesystem(
			$this->downloadUrl,
			$this->io,
			$this->composer->getConfig(),
			$rfs->getOptions(),
			$rfs->isTlsDisabled()
		);
		$event->setRemoteFilesystem( $customRfs );
	}

}
