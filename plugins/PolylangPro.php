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
class PolylangPro {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * PolylangPro constructor.
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
		$name = 'Polylang Pro';

		$response = json_decode( $http->get( 'https://polylang.pro', array(
			'edd_action' => 'get_version',
			'license'    => getenv( 'POLYLANG_PRO_KEY' ),
			'item_name'  => $name,
			'url'        => getenv( 'POLYLANG_PRO_URL' ),
			'version'    => $this->version,
		) ), true );
		if ( ! empty( $response['download_link'] ) ) {
			return $response['download_link'];
		} else {
			throw new Exception( 'Invalid download link for ' . $name );
		}
	}

}
