<?php
/**
 * Polylang Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;
use UnexpectedValueException;

/**
 * PolylangPro class.
 */
class PolylangPro extends AbstractEddPlugin {

	/**
	 * Get the download URL for this plugin.
	 *
	 * @throws UnexpectedValueException If the response is invalid.
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

		if ( ! is_array( $response ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a JSON object for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		return $this->extractDownloadUrl( $response );
	}

}
