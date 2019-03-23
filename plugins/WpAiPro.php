<?php
/**
 * WP All Import / Export Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * WpAiPro class.
 */
class WpAiPro extends Plugin implements PluginInterface {

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
	 * WpAiPro constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( string $version, array $config, string $slug = 'wp-all-import-pro' ) {
		parent::__construct( $version, $config, $slug );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		if ( 'wp-all-export-pro' === $this->slug ) {
			$licenseKey = $this->getConfigValue( 'wp-all-export-pro-key', 'WP_ALL_EXPORT_PRO_KEY' );
			$siteUrl    = $this->getConfigValue( 'wp-all-export-pro-url', 'WP_ALL_EXPORT_PRO_URL' );
			$name       = 'WP All Export';
		} else {
			$licenseKey = $this->getConfigValue( 'wp-all-import-pro-key', 'WP_ALL_IMPORT_PRO_KEY' );
			$siteUrl    = $this->getConfigValue( 'wp-all-import-pro-url', 'WP_ALL_IMPORT_PRO_URL' );

			switch ( $this->slug ) {
				case 'wpai-acf-add-on':
					$name = 'ACF Add-On';
					break;
				case 'wpai-linkcloak-add-on':
					$name = 'Link Cloaking Add-On';
					break;
				case 'wpai-user-add-on':
					$name = 'User Import Add-On';
					break;
				case 'wpai-woocommerce-add-on':
					$name = 'WooCommerce Add-On';
					break;
				default:
					$name = 'WP All Import';
			}
		}

		return $http->getEddUrl( 'https://www.wpallimport.com', $name, $licenseKey, $this->version, $siteUrl );
	}

}
