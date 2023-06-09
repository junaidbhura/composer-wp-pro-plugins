<?php
/**
 * Gravity Forms Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Exception;
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
		$http = new Http();

		$api_query = array(
			'op'   => 'get_plugin',
			'slug' => $this->slug,
			'key'  => getenv( 'GRAVITY_FORMS_KEY' ),
		);

		$api_url = 'https://gravityapi.com/wp-content/plugins/gravitymanager/api.php';

		try {
			$response = $http->get( $api_url, $api_query );
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

		// Catch any throwables from objects in their unserialization handlers.
		// Composer itself handles converting PHP notices into exceptions.
		try {
			/**
			 * @todo When the Composer plugin drops support for PHP 5,
			 *    use the `unserialize()` function's `allowed_classes` option,
			 *    introduced in PHP 7, to disallow all classes.
			 */
			$data = unserialize( $response );

			if ( $data !== false && ! is_array( $data ) ) {
				throw new UnexpectedValueException(
					'unserialize(): Expected a data structure'
				);
			}
		} catch ( Exception $e ) {
			$details = [
				$e->getMessage(),
			];

			$response_length = mb_strlen( $response );
			if ( $response_length > 0 ) {
				$details[] = '    ' . mb_substr( $response, 0, 100 ) . ( $response_length > 100 ? '...' : '' );
			}

			$message = sprintf(
				'Expected a data structure from API for package %s.',
				$this->getPackageName()
			);

			if ( $details ) {
				$message .= PHP_EOL . PHP_EOL . implode( PHP_EOL . PHP_EOL, $details );
			}

			throw new UnexpectedValueException( $message );
		}

		if ( empty( $data['download_url_latest'] ) || ! is_string( $data['download_url_latest'] ) ) {
			throw new UnexpectedValueException( sprintf(
				'Expected a valid download URL for package %s',
				$this->getPackageName()
			) );
		}

		return str_replace( 'http://', 'https://', $data['download_url_latest'] );
	}

}
