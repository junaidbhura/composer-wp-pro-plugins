<?php
/**
 * Abstract Easy Digital Downloads (EDD) Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Composer\Semver\Semver;

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
		if ( empty( $response['download_link'] ) ) {
			return '';
		}

		if ( empty( $response['new_version'] ) ) {
			return '';
		}

		if ( ! Semver::satisfies( $response['new_version'], $this->version ) ) {
			return '';
		}

		return $response['download_link'];
	}

}
