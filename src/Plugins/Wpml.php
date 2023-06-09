<?php
/**
 * WPML Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

use InvalidArgumentException;

/**
 * Wpml class.
 */
class Wpml extends AbstractPlugin {

	/**
	 * Wpml constructor.
	 *
	 * @param string $version
	 * @param string $slug
	 */
	public function __construct( $version = '', $slug = 'wpml-sitepress-multilingual-cms' ) {
		parent::__construct( $version, $slug );
	}

	/**
	 * Get the download URL for this plugin.
	 *
	 * @throws InvalidArgumentException If the package is unsupported.
	 * @return string
	 */
	public function getDownloadUrl() {
		$packages = array(
			'wpml-acfml'                       => 1097589,
			'wpml-all-import'                  => 720221,
			'wpml-buddypress-multilingual'     => 2216259,
			'wpml-cms-nav'                     => 6096,
			'wpml-contact-form-7-multilingual' => 3156699,
			'wpml-gravityforms-multilingual'   => 8882,
			'wpml-mailchimp-for-wp'            => 1442229,
			'wpml-media-translation'           => 7474,
			'wpml-ninja-forms'                 => 5342487,
			'wpml-sitepress-multilingual-cms'  => 6088,
			'wpml-sticky-links'                => 6090,
			'wpml-string-translation'          => 6092,
			'wpml-translation-management'      => 6094,
			'wpml-types'                       => 1385906,
			'wpml-woocommerce-multilingual'    => 637370,
			'wpml-wp-seo-multilingual'         => 3566177,
			'wpml-wpforms'                     => 5368995,
		);

		if ( ! array_key_exists( $this->slug, $packages ) ) {
			throw new InvalidArgumentException( sprintf(
				'Could not find a matching package for %s. Check the package spelling and that the package is supported',
				$this->getPackageName()
			) );
		}

		$api_query = array(
			'download'         => $packages[ $this->slug ],
			'user_id'          => getenv( 'WPML_USER_ID' ),
			'subscription_key' => getenv( 'WPML_KEY' ),
		);

		// If no version is specified, we are fetching the latest version.
		if ( $this->version ) {
			$api_query['version'] = $this->version;
		}

		$api_url = 'https://wpml.org/';

		return $api_url . '?' . http_build_query( $api_query, '', '&' );
	}

}
