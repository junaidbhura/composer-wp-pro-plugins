<?php
/**
 * Polylang Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * PolylangPro class.
 */
class SearchWp extends Plugin implements PluginInterface {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The composer-wp-pro-plugins config array for the Composer instance.
	 *
	 * @var array Config array.
	 */
	protected $config = [];

	/**
	 * The slug of which plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * PolylangPro constructor.
	 *
	 * @param string $version
	 * @param array $config
	 */
	public function __construct( string $version, array $config ) {
		parent::__construct( $version, $config );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$http = new Http();

		// Get the config settings.
		$licenseKey = $this->getConfigValue( 'searchwp-key', 'SEARCHWP_KEY' );
		$siteUrl    = $this->getConfigValue( 'searchwp-url', 'SEARCHWP_URL' );

		return $http->getEddUrl( 'https://searchwp.com', 'SearchWP', $licenseKey, $this->version, $siteUrl );
	}

}
