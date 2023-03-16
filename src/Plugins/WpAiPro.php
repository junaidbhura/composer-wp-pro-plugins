<?php
/**
 * WP All Import / Export Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;
use UnexpectedValueException;

/**
 * WpAiPro class.
 */
class WpAiPro extends AbstractEddPlugin {

	/**
	 * WpAiPro constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'wp-all-import-pro' ) {
		parent::__construct( $version, $slug );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @throws UnexpectedValueException If the response is invalid.
	 * @return string
	 */
	public function getDownloadUrl() {
		$url     = '';
		$name    = '';
		$license = '';

		if ( 'wp-all-import-pro' === $this->slug || 0 === strpos( $this->slug, 'wpai-' ) ) {
			// WP All Import Pro.
			$url = getenv( 'WP_ALL_IMPORT_PRO_URL' );

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
					$name    = 'WP All Import';
					$license = getenv( 'WP_ALL_IMPORT_PRO_KEY' );
			}
		} elseif ( 'wp-all-export-pro' === $this->slug || 0 === strpos( $this->slug, 'wpae-' ) ) {
			// WP All Export Pro.
			$url = getenv( 'WP_ALL_EXPORT_PRO_URL' );

			switch ( $this->slug ) {
				case 'wpae-acf-add-on':
					$name = 'ACF Export Add-On Pro';
					break;
				case 'wpae-woocommerce-add-on':
					$name = 'WooCommerce Export Add-On Pro';
					break;
				case 'wpae-user-add-on-pro':
					$name = 'User Export Add-On Pro';
					break;
				default:
					$name    = 'WP All Export';
					$license = getenv( 'WP_ALL_EXPORT_PRO_KEY' );
			}
		}

		$http     = new Http();
		$response = json_decode( $http->get( 'https://www.wpallimport.com', array(
			'edd_action' => 'get_version',
			'license'    => $license,
			'item_name'  => $name,
			'url'        => $url,
			'version'    => $this->version,
		) ), true );

		if ( ! is_array( $response ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a JSON object from API for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		return $this->extractDownloadUrl( $response );
	}

}
