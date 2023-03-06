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
class GravityForms extends AbstractPlugin {

	/**
	 * GravityForms constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'gravityforms' ) {
		parent::__construct( $version, $slug );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$http     = new Http();
		$response = unserialize( $http->post( 'https://gravityapi.com/wp-content/plugins/gravitymanager/api.php?op=get_plugin&slug=' . $this->slug . '&key=' . getenv( 'GRAVITY_FORMS_KEY' ) ) );
		if ( ! empty( $response['download_url_latest'] ) ) {
			return str_replace( 'http://', 'https://', $response['download_url_latest'] );
		}
		return '';
	}

}
