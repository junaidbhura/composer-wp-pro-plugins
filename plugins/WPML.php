<?php
/**
 * ACF Pro Plugin.
 *
 * @package Junaidbhura\Composer\WPProPlugins\Plugins
 */

namespace Junaidbhura\Composer\WPProPlugins\Plugins;

/**
 * AcfPro class.
 */
class WPML {

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
    public function __construct( $version = '', $slug = 'sitepress-multilingual-cms' ) {
        $this->version = $version;
        $this->slug    = $slug;
    }

	/**
	 * Get the download URL for this plugin.
	 *
	 * @return string
	 */
	public function getDownloadUrl() {
        $packages = [
            'wpml-sitepress-multilingual-cms' => 6088,
            'wpml-string-translation' => 6092,
            'wpml-media-translation' => 7474,
            'wpml-woocommerce-multilingual' => 637370,
            'wpml-gravityforms-multilingual' => 8882,
            'wpml-contact-form-7-multilingual' => 3156699,
            'wpml-ninja-forms' => 5342487,
            'wpml-wpforms' => 5368995,
            'wpml-buddypress-multilingual' => 2216259,
            'wpml-acfml' => 1097589,
            'wpml-all-import' => 720221,
            'wpml-mailchimp-for-wp' => 1442229,
            'wpml-wp-seo-multilingual' => 3566177,
            'wpml-types' => 1385906,
            'wpml-sticky-links' => 6090,
            'wpml-cms-nav' => 6096,
            'wpml-translation-management' => 6094,
        ];

        if (array_key_exists($this->slug, $packages)) {
            return 'https://wpml.org/?download='. $packages[$this->slug] .'&user_id='. getenv( 'WPML_USER_ID' ) .'&subscription_key='. getenv( 'WPML_KEY' ) .'&version=' . $this->version;
        }
	}

}
