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
			$dotenv = new Dotenv( getcwd() );
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
		if ( 'update' === $operation->getJobType() ) {
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

		switch ( $package->getName() ) {
			case 'junaidbhura/advanced-custom-fields-pro':
				$acf = new Plugins\AcfPro( $package->getPrettyVersion() );
				$this->downloadUrl = $acf->getDownloadUrl();
				die($this->downloadUrl);
				break;
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
