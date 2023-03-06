<?php
/**
 * Abstract Easy Digital Downloads (EDD) Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;
use UnexpectedValueException;

/**
 * AbstractEddPlugin class.
 */
abstract class AbstractEddPlugin extends AbstractPlugin {

	/**
	 * Get the download URL for this plugin.
	 *
	 * @param  array<string, mixed> $response The EDD API response.
	 * @return string
	 */
	protected function extractDownloadUrl( array $response ) {
		if ( empty( $response['download_link'] ) || ! is_string( $response['download_link'] ) ) {
			throw new UnexpectedValueException(sprintf(
				'Expected a valid download URL for package %s',
				'junaidbhura/' . $this->slug
			));
		}

		if ( empty( $response['new_version'] ) || ! is_scalar( $response['new_version'] ) ) {
			throw new UnexpectedValueException(sprintf(
				'Expected a valid download version number for package %s',
				'junaidbhura/' . $this->slug
			));
		}

		if ( ! Semver::satisfies( $response['new_version'], $this->version ) ) {
			throw new UnexpectedValueException(sprintf(
				'Expected download version (%s) to match installed version (%s) of package %s',
				$response['new_version'],
				$this->version,
				'junaidbhura/' . $this->slug
			));
		}

		return $response['download_link'];
	}

}
