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
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The slug of which plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * AbstractPlugin constructor.
	 *
	 * @param string $version
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

}
