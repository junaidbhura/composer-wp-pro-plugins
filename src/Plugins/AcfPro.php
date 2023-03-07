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
		return 'https://connect.advancedcustomfields.com/index.php?' . http_build_query( array(
			'p' => 'pro',
			'a' => 'download',
			'k' => getenv( 'ACF_PRO_KEY' ),
			't' => $this->version,
		), '', '&' );
	}

}
