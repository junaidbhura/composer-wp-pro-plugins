<?php
/**
 * PublishPress Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use Junaidbhura\Composer\WPProPlugins\Http;

/**
 * PublishPressPro class.
 */
class PublishPressPro {

	/**
	 * The version number of the plugin to download.
	 *
	 * @var string Version number.
	 */
	protected $version = '';

	/**
	 * The slug of which plugin to download.
	 *
	 * @var string Plugin slug.
	 */
	protected $slug = '';

	/**
	 * WpAiPro constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'publishpress-planner-pro' ) {
		$this->version = $version;
		$this->slug    = $slug;
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
		$packages = array(
			'publishpress-authors-pro'      => 7203,
			'publishpress-blocks-pro'       => 98972,
			'publishpress-capabilities-pro' => 44811,
			'publishpress-checklists-pro'   => 6465,
			'publishpress-permissions-pro'  => 34506,
			'publishpress-planner-pro'      => 49742,
			'publishpress-revisions-pro'    => 40280,
			'publishpress-series-pro'       => 110550,
		);

		if ( array_key_exists( $this->slug, $packages ) ) {
			$http     = new Http();
			$response = json_decode( $http->get( 'https://publishpress.com', array(
				'edd_action' => 'get_version',
				'license'    => getenv( 'PUBLISHPRESS_PRO_KEY' ),
				'item_id'    => $packages[ $this->slug ],
				'url'        => getenv( 'PUBLISHPRESS_PRO_URL' ),
				'version'    => $this->version,
			) ), true );

			if ( ! empty( $response['download_link'] ) ) {
				return $response['download_link'];
			}
		}

		return '';
	}

}
