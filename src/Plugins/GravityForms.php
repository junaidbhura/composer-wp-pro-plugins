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
	 * @throws UnexpectedValueException If the response is invalid.
	 * @return string
	 */
	public function getDownloadUrl() {
		$http     = new Http();
		$response = unserialize( $http->get( 'https://gravityapi.com/wp-content/plugins/gravitymanager/api.php', array(
			'op'   => 'get_plugin',
			'slug' => $this->slug,
			'key'  => getenv( 'GRAVITY_FORMS_KEY' ),
		) ) );

		if ( ! is_array( $response ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a serialized object from API for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		$candidates = array(
			array( 'version', 'download_url' ),
			array( 'version_latest', 'download_url_latest' ),
		);
		foreach ( $candidates as $candidate ) {
			list( $version_key, $download_key ) = $candidate;

			try {
				return $this->extractDownloadUrl( $response, $version_key, $download_key );
			} catch ( UnexpectedValueException $e ) {
				// throw the last exception after the loop
			}
		}

		throw $e;
	}

	/**
	 * @param  array<string, mixed> $response     The EDD API response.
	 * @param  string               $version_key  The API field key that holds the version.
	 * @param  string               $download_key The API field key that holds the download URL.
	 * @throws UnexpectedValueException If the response is not OK, invalid, or malformed.
	 * @return string
	 */
	protected function extractDownloadUrl( array $response, $version_key, $download_key ) {
		$version      = array_key_exists( $version_key, $response ) ? $response[ $version_key ] : null;
		$download_url = array_key_exists( $download_key, $response ) ? $response[ $download_key ] : null;

		if ( false === $version ) {
			// If FALSE, the package does not exist / is not available
			throw new UnexpectedValueException( sprintf(
				'Could not find a matching package for %s. Check the package spelling and that the package is supported',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( empty( $download_url ) || ! is_string( $download_url ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL from API for package %s',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( empty( $version ) || ! is_scalar( $version ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download version number from API for package %s.',
				'junaidbhura/' . $this->slug
			) );
		}

		if ( ! Semver::satisfies( $version, $this->version ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected download version from API (%s) to match installed version (%s) of package %s.',
				$version,
				$this->version,
				'junaidbhura/' . $this->slug
			) );
		}

		return str_replace( 'http://', 'https://', $download_url );
	}

}
