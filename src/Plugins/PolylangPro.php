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
class PolylangPro extends AbstractEddPlugin {

	/**
	 * Get the download URL for this plugin from its API.
	 *
	 * @return string
	 */
	protected function getDownloadUrlFromApi() {
		$http = new Http();

		return $http->get( 'https://polylang.pro', array(
			'edd_action' => 'get_version',
			'license'    => getenv( 'POLYLANG_PRO_KEY' ),
			'item_name'  => 'Polylang Pro',
			'url'        => getenv( 'POLYLANG_PRO_URL' ),
			'version'    => $this->version,
		) );
	}

}
