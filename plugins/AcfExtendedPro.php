<?php
/**
 * ACF Extended Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * AcfExtendedPro class.
 */
class AcfExtendedPro {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * AcfExtendedPro constructor.
	 *
	 * @param string $version
	 */
	public function __construct( $version = '' ) {
		$this->version = $version;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$http     = new Http();
		$response = json_decode( $http->post( 'https://acf-extended.com', array(
			'edd_action' => 'get_version',
			'license'    => getenv( 'ACFE_PRO_KEY' ),
			'item_name'  => 'ACF Extended Pro',
			'url'        => getenv( 'ACFE_PRO_URL' ),
			'version'    => $this->version,
		) ), true );
		if ( ! empty( $response['download_link'] ) ) {
			return $response['download_link'];
		}
		return '';
	}

}
