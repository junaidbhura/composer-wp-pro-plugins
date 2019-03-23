<?php
/**
 * Base Plugin class.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

class Plugin {

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
	 * Construct the plugin.
	 *
	 * @return void
	 */
	public function __construct( string $version, array $config, string $slug = '' ) {
		$this->version = $version;
		$this->config  = $config;
		$this->slug    = $slug;
	}

	/**
	 * Fetch a config value with a fallback to .env if necessary.
	 *
	 * @return string;
	 */
	public function getConfigValue( string $key, string $envKey ) {
		return $this->config[ $key ] ?? getenv( $envKey );
	}

}
