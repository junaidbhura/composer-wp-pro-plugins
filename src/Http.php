<?php
/**
 * Http Wrapper.
 *
 * @package Junaidbhura\Composer\WPProPlugins
 */

namespace Junaidbhura\Composer\WPProPlugins;

/**
 * Http class.
 */
class Http {

	/**
	 * POST request.
	 *
	 * @param string $url Url to POST.
	 * @param array  $args Arguments to POST.
	 * @return mixed
	 */
	public function post( $url = '', $args = array() ) {
		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $curl_handle, CURLOPT_CUSTOMREQUEST, 'POST' );
		if ( ! empty( $args ) ) {
			curl_setopt( $curl_handle, CURLOPT_POSTFIELDS, http_build_query( $args, '', '&' ) );
		}

		$response = curl_exec( $curl_handle );
		curl_close( $curl_handle );

		return $response;
	}

	/**
	 * GET request.
	 *
	 * @param string $url Base URL for requeset (without params)
	 * @param array  $args Arguments to add to request
	 * @return mixed
	 */
	public function get( $url = '', $args = array() ) {
		if ( ! empty( $args ) ) {
			$url .= '?' . http_build_query( $args, '', '&' );
		}

		$curl_handle = curl_init();
		curl_setopt( $curl_handle, CURLOPT_URL, $url );
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );

		$response = curl_exec( $curl_handle );
		curl_close( $curl_handle );

		return $response;
	}

}
