<?php
/**
 * Polylang Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;
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
		$response = json_decode( $http->post( 'https://polylang.pro', array(
			'edd_action' => 'get_version',
			'license'    => getenv( 'POLYLANG_PRO_KEY' ),
			'item_name'  => 'Polylang Pro',
			'url'        => getenv( 'POLYLANG_PRO_URL' ),
			'version'    => $this->version,
		) ), true );

		if ( empty( $response['download_link'] ) ) {
			return '';
		}

		if ( empty( $response['new_version'] ) ) {
			return '';
		}

		if ( ! Semver::satisfies( $response['new_version'], $this->version ) ) {
			return '';
		}

		return $response['download_link'];
	}

}
