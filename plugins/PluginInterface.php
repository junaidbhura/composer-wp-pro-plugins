<?php
/**
 * Base Plugin class.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

interface PluginInterface {

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl();

}
