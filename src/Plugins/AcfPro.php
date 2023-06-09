<?php
/**
 * ACF Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

/**
 * AcfPro class.
 */
class AcfPro extends AbstractPlugin {

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$api_query = array(
			'p' => 'pro',
			'a' => 'download',
			'k' => getenv( 'ACF_PRO_KEY' ),
		);

		// If no version is specified, we are fetching the latest version.
		if ( $this->version ) {
			$api_query['t'] = $this->version;
		}

		$api_url = 'https://connect.advancedcustomfields.com/index.php';

		return $api_url . '?' . http_build_query( $api_query, '', '&' );
	}

}
