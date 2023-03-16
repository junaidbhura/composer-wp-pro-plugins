<?php
/**
 * Gravity Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;
use RuntimeException;
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
	 * @throws UnexpectedValueException If the response is invalid.
	 * @return string
	 */
	public function getDownloadUrl() {
		$http = new Http();

		try {
			$response = unserialize( $http->get( 'https://gravityapi.com/wp-content/plugins/gravitymanager/api.php', array(
				'op'   => 'get_plugin',
				'slug' => $this->slug,
				'key'  => getenv( 'GRAVITY_FORMS_KEY' ),
			) ) );
		} catch ( RuntimeException $e ) {
			$details = $e->getMessage();
			if ( $details ) {
				$details = PHP_EOL . $details;
			}

			throw new UnexpectedValueException( sprintf(
				'Could not query API for package %s. Please try again later.' . $details,
				'junaidbhura/' . $this->slug
			) );
		}

		if ( ! is_array( $response ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a serialized object from API for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( empty( $response['download_url_latest'] ) || ! is_string( $response['download_url_latest'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		return str_replace( 'http://', 'https://', $response['download_url_latest'] );
	}

}
