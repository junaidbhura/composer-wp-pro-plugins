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
class AcfPro {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The slug of which ACF plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * AcfPro constructor.
	 *
	 * @param string $version
	 */
	public function __construct( $version = '', $slug = 'pro' ) {
		$this->version = $version;
		$this->slug    = $slug;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		return 'https://connect.advancedcustomfields.com/v2/plugins/download?p=' . $this->slug . '&k=' . getenv( 'ACF_PRO_KEY' ) . '&t=' . $this->version;
	}

}
