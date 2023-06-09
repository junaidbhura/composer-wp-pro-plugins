<?php
/**
 * Http Wrapper.
 *
 * @package Junaidbhura\Composer\WPProPlugins
 */

namespace Junaidbhura\Composer\WPProPlugins;

use RuntimeException;

/**
 * Http class.
 */
class Http {

	/**
	 * POST request.
	 *
	 * @param  string                $url  URL to POST.
	 * @param  array<string, mixed>  $args Arguments to POST.
	 * @return string
	 */
	public function post( $url, $args = array() ) {
		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl_handle, CURLOPT_CUSTOMREQUEST, 'POST' );
		if ( ! empty( $args ) ) {
			curl_setopt( $curl_handle, CURLOPT_POSTFIELDS, http_build_query( $args, '', '&' ) );
		}

		return $this->request( $curl_handle );
	}

	/**
	 * GET request.
	 *
	 * @param  string                $url  URL to GET (without params).
	 * @param  array<string, mixed>  $args Arguments to add to request.
	 * @return string
	 */
	public function get( $url, $args = array() ) {
		if ( ! empty( $args ) ) {
			$url .= '?' . http_build_query( $args, '', '&' );
		}

		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, $url );

		return $this->request( $curl_handle );
	}

	/**
	 * @param  \CurlHandle|resource $curl_handle The cURL handler.
	 * @throws RuntimeException If the request failed or the response is invalid.
	 * @return string The response body.
	 */
	protected function request( $curl_handle ) {
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl_handle, CURLOPT_FAILONERROR, true );

		$response = curl_exec( $curl_handle );

		$curl_errno = curl_errno( $curl_handle );
		$curl_error = curl_error( $curl_handle );
		curl_close( $curl_handle );

		if ( false === $response ) {
			throw new RuntimeException( sprintf(
				'cURL error (%d): %s',
				$curl_errno,
				$curl_error
			), $curl_errno );
		}

		return $response;
	}

}
