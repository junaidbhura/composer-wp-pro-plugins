<?php
/**
 * Abstract Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

/**
 * AbstractPlugin class.
 */
abstract class AbstractPlugin {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string
	 */
	protected $version = '';

	/**
	 * The name of the plugin to download.
	 *
	 * @var string
	 */
	protected $slug = '';

	/**
	 * AbstractPlugin constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = '' ) {
		$this->version = $version;
		$this->slug    = $slug;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	abstract public function getDownloadUrl();

	/**
	 * Get the plugin's Composer package name with vendor.
	 *
	 * @return string
	 */
	protected function getPackageName() {
		return 'junaidbhura/' . $this->slug;
	}

}
