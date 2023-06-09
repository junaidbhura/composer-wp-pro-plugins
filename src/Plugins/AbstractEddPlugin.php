<?php
/**
 * Abstract Easy Digital Downloads (EDD) Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;
use Exception;
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
			$response = $this->getDownloadUrlFromApi();
		} catch ( Exception $e ) {
			$details = [];

			$error = $e->getMessage();
			if ( $error ) {
				$details[] = 'HTTP Error: ' . $error;
			}

			$message = sprintf(
				'Could not query API for package %s. Please try again later.',
				$this->getPackageName()
			);

			if ( $details ) {
				$message .= PHP_EOL . PHP_EOL . implode( PHP_EOL . PHP_EOL, $details );
			}

			throw new UnexpectedValueException( $message );
		}

		try {
			/**
			 * @todo When the Composer plugin drops support for PHP 5,
			 *    use the `json_decode()` function's `JSON_THROW_ON_ERROR` flag,
			 *    introduced in PHP 7.3, to simplify error handling.
			 */
			$data = json_decode( $response, true );

			if ( json_last_error() !== JSON_ERROR_NONE ) {
				throw new Exception(
					json_last_error_msg(),
					json_last_error()
				);
			}

			if ( ! is_array( $data ) ) {
				throw new UnexpectedValueException(
					'Expected a data structure'
				);
			}
		} catch ( Exception $e ) {
			$details = [
				'json_decode(): ' . $e->getMessage(),
			];

			$response_length = mb_strlen( $response );
			if ( $response_length > 0 ) {
				$details[] = '    ' . mb_substr( $response, 0, 100 ) . ( $response_length > 100 ? '...' : '' );
			}

			$message = sprintf(
				'Expected a data structure from API for package %s. Please try again later.',
				$this->getPackageName()
			);

			if ( $details ) {
				$message .= PHP_EOL . PHP_EOL . implode( PHP_EOL . PHP_EOL, $details );
			}

			throw new UnexpectedValueException( $message );
		}

		if ( empty( $data['download_link'] ) || ! is_string( $data['download_link'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL from API for package %s',
				$this->getPackageName()
			) );
		}

		if ( empty( $data['new_version'] ) || ! is_scalar( $data['new_version'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download version number from API for package %s',
				$this->getPackageName()
			) );
		}

		// If no version is specified, we are fetching the latest version.
		if ( $this->version && ! Semver::satisfies( $data['new_version'], $this->version ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected download version from API (%s) to match installed version (%s) of package %s',
				$data['new_version'],
				$this->version,
				$this->getPackageName()
			) );
		}

		return $data['download_link'];
	}

}
