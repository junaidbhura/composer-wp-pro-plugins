<?php
/**
 * Gravity Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * GravityForms class.
 */
class GravityForms extends Plugin implements PluginInterface {

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
	 * The slug of which Gravity Forms plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * GravityForms constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( string $version, array $config, string $slug = 'gravityforms' ) {
		parent::__construct( $version, $config, $slug );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$key = $this->getConfigValue( 'gravity-forms-key', 'GRAVITY_FORMS_KEY' );

		$http     = new Http();
		$response = unserialize( $http->post( 'https://www.gravityhelp.com/wp-content/plugins/gravitymanager/api.php?op=get_plugin&slug=' . $this->slug . '&key=' . $key ) );

		if ( ! empty( $response['download_url_latest'] ) ) {
			return str_replace( 'http://', 'https://', $response['download_url_latest'] );
		}

		return '';
	}

}
