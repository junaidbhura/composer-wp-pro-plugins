<?php
/**
 * Http Wrapper.
 *
 * @package Junaidbhura\Composer\WPProPlugins
 */

namespace Junaidbhura\Composer\WPProPlugins;

use UnexpectedValueException;

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
	public function post( $url = '', array $args = array() ) {
		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYHOST, 0 );
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
	public function get( $url = '', array $args = array() ) {
		$query_string = '';

		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
		if ( ! empty( $args ) ) {
			$query_string = http_build_query( $args, '', '&' );
		}
		curl_setopt( $curl_handle, CURLOPT_URL, $url . '?' . $query_string );

		return $this->request( $curl_handle );
	}

	/**
	 * @param  \CurlHandle|resource $curl_handle The cURL handler.
	 * @throws UnexpectedValueException If the request failed or the response is invalid.
	 * @return string
	 */
	protected function request( $curl_handle ) {
		$response = curl_exec( $curl_handle );
		$curl_errno = curl_errno( $curl_handle );
		curl_close( $curl_handle );

		if ( false === $response ) {
			throw new UnexpectedValueException( sprintf(
				'cURL error (%d): %s',
				$curl_errno,
				curl_strerror( $curl_errno )
			) );
		}

		if ( ! is_string( $response ) || 0 === strlen( $response ) ) {
			throw new UnexpectedValueException(
				'cURL error: Empty response body'
			);
		}

		return $response;
	}

}
