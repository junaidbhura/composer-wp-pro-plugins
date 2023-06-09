<?php
/**
 * Abstract Easy Digital Downloads (EDD) Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;
use RuntimeException;
use UnexpectedValueException;

/**
 * AbstractEddPlugin class.
 */
abstract class AbstractEddPlugin extends AbstractPlugin {

	/**
	 * Get the download URL for this plugin from its API.
	 *
	 * @return string
	 */
	abstract protected function getDownloadUrlFromApi();

	/**
	 * Get the download URL for this plugin.
	 *
	 * @throws UnexpectedValueException If the response is invalid.
	 * @return string
	 */
	public function getDownloadUrl() {
		try {
			$response = json_decode( $this->getDownloadUrlFromApi(), true );
		} catch ( RuntimeException $e ) {
			$details = $e->getMessage();
			if ( $details ) {
				$details = PHP_EOL . $details;
			}

			throw new UnexpectedValueException( sprintf(
				'Could not query API for package %s. Please try again later.' . $details,
				$this->getPackageName()
			) );
		}

		if ( ! is_array( $response ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a JSON object from API for package %s',
				$this->getPackageName()
			) );
		}

		if ( empty( $response['download_link'] ) || ! is_string( $response['download_link'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL from API for package %s',
				$this->getPackageName()
			) );
		}

		if ( empty( $response['new_version'] ) || ! is_scalar( $response['new_version'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download version number from API for package %s',
				$this->getPackageName()
			) );
		}

		// If no version is specified, we are fetching the latest version.
		if ( $this->version && ! Semver::satisfies( $response['new_version'], $this->version ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected download version from API (%s) to match installed version (%s) of package %s',
				$response['new_version'],
				$this->version,
				$this->getPackageName()
			) );
		}

		return $response['download_link'];
	}

}
