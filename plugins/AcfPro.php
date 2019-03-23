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
class AcfPro extends Plugin implements PluginInterface {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The composer-wp-pro-plugins config array for the Composer instance.
	 *
	 * @var array Config array.
	 */
	protected $config = [];

	/**
	 * The slug of which plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * AcfPro constructor.
	 *
	 * @param string $version
	 */
	public function __construct( string $version, array $config ) {
		parent::__construct( $version, $config );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$licenseKey = $this->getConfigValue( 'acf-pro-key', 'ACF_PRO_KEY' );

		return 'https://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=' . $licenseKey . '&t=' . $this->version;
	}

}
