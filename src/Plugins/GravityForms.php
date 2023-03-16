<?php
/**
 * Gravity Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;
use Junaidbhura\Composer\WPProPlugins\Http;
use UnexpectedValueException;

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

		if ( empty( $response['download_url_latest'] ) || ! is_string( $response['download_url_latest'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( empty( $response['version_latest'] ) || ! is_scalar( $response['version_latest'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download version number for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( ! Semver::satisfies( $response['version_latest'], $this->version ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected download version (%s) to match installed version (%s) of package %s',
				$response['version_latest'],
				$this->version,
				'junaidbhura/' . $this->slug
			) );
		}

		return str_replace( 'http://', 'https://', $response['download_url_latest'] );
	}

}
