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
		return 'https://connect.advancedcustomfields.com/v2/plugins/download?p=pro&k=' . getenv( 'ACF_PRO_KEY' ) . '&t=' . $this->version;
	}

}
