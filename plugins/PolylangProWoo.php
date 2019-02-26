<?php
/**
 * Polylang Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * PolylangPro class.
 */
class PolylangProWoo {

    /**
     * The version number of the plugin to download.
     *
     * @var string Version number.
     */
    protected $version = '';

    /**
     * PolylangPro constructor.
     *
     * @param string $version
     */
    public function __construct( $version = '' ) {
        $this->version = $version;
    }

    /**
     * Get the download URL for this plugin.
     *
     * @return string
     */
    public function getDownloadUrl() {
        $http     = new Http();
        $response = json_decode( $http->post( 'https://polylang.pro', array(
            'edd_action' => 'get_version',
            'license'    => getenv( 'POLYLANG_PRO_WOO_KEY' ),
            'item_name'  => 'Polylang for WooCommerce',
            'url'        => getenv( 'POLYLANG_PRO_WOO_URL' ),
            'version'    => $this->version,
        ) ), true );
        if ( ! empty( $response['download_link'] ) ) {
            return $response['download_link'];
        }
        return '';
    }

}
