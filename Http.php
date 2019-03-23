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
		curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl_handle, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $curl_handle, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $curl_handle, CURLOPT_CUSTOMREQUEST, 'POST' );
		if ( ! empty( $args ) ) {
			curl_setopt( $curl_handle, CURLOPT_POSTFIELDS, http_build_query( $args ) );
		}
		$response = curl_exec( $curl_handle );
		curl_close( $curl_handle );

		return $response;
	}

	/**
	 * Get an EDD download URL.
	 *
	 * @param string $url        The URL of the plugin's EDD-powered website.
	 * @param string $itemName   The name of the plugin to be downloaded.
	 * @param string $licenseKey The valid license key.
	 * @param string $version    The version to request.
	 * @param string $siteUrl    The user's authorised website.
	 *
	 * @return string
	 */
	public function getEddUrl( string $url, string $itemName, string $licenseKey, string $version, string $siteUrl ) {
		$response = json_decode( $this->post( $url, array(
			'edd_action' => 'get_version',
			'item_name'  => $itemName,
			'license'    => $licenseKey,
			'version'    => $version,
			'url'        => $siteUrl,
		) ), true );

		return $response['download_link'] ?? '';
	}
}
