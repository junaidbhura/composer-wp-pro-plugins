# Composer Installer for Pro WordPress Plugins.

A Composer plugin that makes it easy to install commercial WordPress plugins.

Sensitive credentials (license keys, tokens) are read from environment variables or a `.env` file.

## Supported Plugins

1. Advanced Custom Fields Pro
1. Ninja Forms Add-Ons
1. Gravity Forms / Add-Ons
1. Polylang Pro
1. PublishPress Pro
1. Advanced Custom Fields Extended Pro
1. WP All Import / Export Pro / Add-Ons
1. WPML

## Overview

> ⚠️ Note: Most EDD plugins, and Gravity Forms, only allow downloading the latest versions
> of their plugins, even if you request for a specific version.

* Packages must use the names defined below otherwise they are ignored by this plugin.
* When installing or updating a package, the package version is appended to the dist URL.
  This versioned dist URL is used as the cache key to store ZIP archives of the package.
  In Composer 1, the versioned dist URL is added to `composer.lock`.
* Before downloading the package, the package's real download URL is retrieved and formatted
  with their corresponding environment variables, as defined below.
  Environment variables will never be stored inside `composer.lock`.
* If an environment variable can't be resolved, the download will fail and Composer will abort.

## Usage

This Composer plugin requires [Composer](https://getcomposer.org/):

* 1.0.0 and newer, or
* 2.0.2 and newer
* 2.3+ IMPORTANT: Make sure to add trailing slashes to packages' `dist` URL as below.
  More info: https://github.com/junaidbhura/composer-wp-pro-plugins/issues/34

Create a `.env` file in the root of your WordPress site, where the `composer.json` file lives,
which has all the license keys and settings:

```shell
ACF_PRO_KEY="<acf_pro_license_key>"
ACFE_PRO_KEY="<acf_extended_pro_license_key>"
ACFE_PRO_URL="<registered_url_for_acf_extended_pro>"
GRAVITY_FORMS_KEY="<gravity_forms_license_key>"
NINJA_FORMS_KEY="<ninja_forms_membership_license_key>"
NINJA_FORMS_URL="<registered_url_for_ninja_forms_membership>"
NINJA_FORMS_<addon_slug>_KEY="<ninja_forms_addon_license_key>"
NINJA_FORMS_<addon_slug>_URL="<registered_url_for_ninja_forms_addon>"
POLYLANG_PRO_KEY="<polylang_pro_license_key>"
POLYLANG_PRO_URL="<registered_url_for_polylang_pro>"
PUBLISHPRESS_PRO_KEY="<publishpress_pro_membership_license_key>"
PUBLISHPRESS_PRO_URL="<registered_url_for_publishpress_pro_membership>"
PUBLISHPRESS_<plugin_slug>_PRO_KEY="<publishpress_pro_license_key>"
PUBLISHPRESS_<plugin_slug>_PRO_URL="<registered_url_for_publishpress_pro>"
WP_ALL_IMPORT_PRO_KEY="<wp_all_import_license_key>"
WP_ALL_IMPORT_PRO_URL="<registered_url_for_wpai_pro>"
WP_ALL_EXPORT_PRO_KEY="<wp_all_export_license_key>"
WP_ALL_EXPORT_PRO_URL="<registered_url_for_wpae_pro>"
WPML_USER_ID="<wpml_user_id>"
WPML_KEY="<wpml_key>"
```

Add the following to your composer.json file:

```json
"repositories": [
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/acf-extended-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.acf-extended.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/advanced-custom-fields-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.advancedcustomfields.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/gravityforms",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.gravityforms.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/gravityformspolls",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.gravityforms.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/ninja-forms-uploads",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://ninjaforms.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/polylang-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.polylang.pro/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/publishpress-planner-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://publishpress.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wp-all-import-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.wpallimport.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wp-all-export-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.wpallimport.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wpai-acf-add-on",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.wpallimport.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wpae-acf-add-on",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.wpallimport.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wpae-user-add-on-pro",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://www.wpallimport.com/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wpml-sitepress-multilingual-cms",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://wpml.org/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	},
	{
		"type": "package",
		"package": {
			"name": "junaidbhura/wpml-string-translation",
			"version": "<version_number>",
			"type": "wordpress-plugin",
			"dist": {
				"type": "zip",
				"url": "https://wpml.org/"
			},
			"require": {
				"junaidbhura/composer-wp-pro-plugins": "*"
			}
		}
	}
],
"require": {
	"junaidbhura/acf-extended-pro": "*",
	"junaidbhura/advanced-custom-fields-pro": "*",
	"junaidbhura/gravityforms": "*",
	"junaidbhura/gravityformspolls": "*",
	"junaidbhura/ninja-forms-uploads": "*",
	"junaidbhura/polylang-pro": "*",
	"junaidbhura/publishpress-planner-pro": "*",
	"junaidbhura/wp-all-import-pro": "*",
	"junaidbhura/wp-all-export-pro": "*",
	"junaidbhura/wpai-acf-add-on": "*",
	"junaidbhura/wpae-acf-add-on": "*",
	"junaidbhura/wpae-user-add-on-pro": "*",
	"junaidbhura/wpml-sitepress-multilingual-cms": "*",
	"junaidbhura/wpml-string-translation": "*"
}
```

### Gravity Forms Add-Ons

You can use any Gravity Forms add-on by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/gravityformspolls`

Consult the [list of all Gravity Forms add-on slugs](https://docs.gravityforms.com/gravity-forms-add-on-slugs/)

### Ninja Forms Add-Ons

You can use any Ninja Forms add-on by simply adding it's slug like so:

`junaidbhura/ninja-forms-<addon-slug>`

The following add-ons are supported:

| Package name                                  | Environment variables                          |
|:--------------------------------------------- |:---------------------------------------------- |
| `junaidbhura/ninja-forms-activecampaign`      | `NINJA_FORMS_ACTIVECAMPAIGN_<key_or_url>`      |
| `junaidbhura/ninja-forms-advanced-datepicker` | `NINJA_FORMS_ADVANCED_DATEPICKER_<key_or_url>` |
| `junaidbhura/ninja-forms-authorize-net`       | `NINJA_FORMS_AUTHORIZE_NET_<key_or_url>`       |
| `junaidbhura/ninja-forms-aweber`              | `NINJA_FORMS_AWEBER_<key_or_url>`              |
| `junaidbhura/ninja-forms-campaign-monitor`    | `NINJA_FORMS_CAMPAIGN_MONITOR_<key_or_url>`    |
| `junaidbhura/ninja-forms-capsule-crm`         | `NINJA_FORMS_CAPSULE_CRM_<key_or_url>`         |
| `junaidbhura/ninja-forms-civicrm`             | `NINJA_FORMS_CIVICRM_<key_or_url>`             |
| `junaidbhura/ninja-forms-cleverreach`         | `NINJA_FORMS_CLEVERREACH_<key_or_url>`         |
| `junaidbhura/ninja-forms-clicksend`           | `NINJA_FORMS_CLICKSEND_<key_or_url>`           |
| `junaidbhura/ninja-forms-conditional-logic`   | `NINJA_FORMS_CONDITIONAL_LOGIC_<key_or_url>`   |
| `junaidbhura/ninja-forms-constant-contact`    | `NINJA_FORMS_CONSTANT_CONTACT_<key_or_url>`    |
| `junaidbhura/ninja-forms-convertkit`          | `NINJA_FORMS_CONVERTKIT_<key_or_url>`          |
| `junaidbhura/ninja-forms-elavon`              | `NINJA_FORMS_ELAVON_<key_or_url>`              |
| `junaidbhura/ninja-forms-emailoctopus`        | `NINJA_FORMS_EMAILOCTOPUS_<key_or_url>`        |
| `junaidbhura/ninja-forms-emma`                | `NINJA_FORMS_EMMA_<key_or_url>`                |
| `junaidbhura/ninja-forms-excel-export`        | `NINJA_FORMS_EXCEL_EXPORT_<key_or_url>`        |
| `junaidbhura/ninja-forms-help-scout`          | `NINJA_FORMS_HELP_SCOUT_<key_or_url>`          |
| `junaidbhura/ninja-forms-hubspot`             | `NINJA_FORMS_HUBSPOT_<key_or_url>`             |
| `junaidbhura/ninja-forms-insightly`           | `NINJA_FORMS_INSIGHTLY_<key_or_url>`           |
| `junaidbhura/ninja-forms-layout-styles`       | `NINJA_FORMS_LAYOUT_STYLES_<key_or_url>`       |
| `junaidbhura/ninja-forms-mailchimp`           | `NINJA_FORMS_MAILCHIMP_<key_or_url>`           |
| `junaidbhura/ninja-forms-mailpoet`            | `NINJA_FORMS_MAILPOET_<key_or_url>`            |
| `junaidbhura/ninja-forms-multi-step`          | `NINJA_FORMS_MULTI_STEP_<key_or_url>`          |
| `junaidbhura/ninja-forms-onepagecrm`          | `NINJA_FORMS_ONEPAGECRM_<key_or_url>`          |
| `junaidbhura/ninja-forms-paypal-express`      | `NINJA_FORMS_PAYPAL_EXPRESS_<key_or_url>`      |
| `junaidbhura/ninja-forms-pdf-submissions`     | `NINJA_FORMS_PDF_SUBMISSIONS_<key_or_url>`     |
| `junaidbhura/ninja-forms-pipeline-crm`        | `NINJA_FORMS_PIPELINE_CRM_<key_or_url>`        |
| `junaidbhura/ninja-forms-post-creation`       | `NINJA_FORMS_POST_CREATION_<key_or_url>`       |
| `junaidbhura/ninja-forms-recurly`             | `NINJA_FORMS_RECURLY_<key_or_url>`             |
| `junaidbhura/ninja-forms-salesforce`          | `NINJA_FORMS_SALESFORCE_<key_or_url>`          |
| `junaidbhura/ninja-forms-save-progress`       | `NINJA_FORMS_SAVE_PROGRESS_<key_or_url>`       |
| `junaidbhura/ninja-forms-scheduled-exports`   | `NINJA_FORMS_SCHEDULED_EXPORTS_<key_or_url>`   |
| `junaidbhura/ninja-forms-slack`               | `NINJA_FORMS_SLACK_<key_or_url>`               |
| `junaidbhura/ninja-forms-stripe`              | `NINJA_FORMS_STRIPE_<key_or_url>`              |
| `junaidbhura/ninja-forms-trello`              | `NINJA_FORMS_TRELLO_<key_or_url>`              |
| `junaidbhura/ninja-forms-twilio`              | `NINJA_FORMS_TWILIO_<key_or_url>`              |
| `junaidbhura/ninja-forms-uploads`             | `NINJA_FORMS_UPLOADS_<key_or_url>`             |
| `junaidbhura/ninja-forms-user-analytics`      | `NINJA_FORMS_USER_ANALYTICS_<key_or_url>`      |
| `junaidbhura/ninja-forms-user-management`     | `NINJA_FORMS_USER_MANAGEMENT_<key_or_url>`     |
| `junaidbhura/ninja-forms-webhooks`            | `NINJA_FORMS_WEBHOOKS_<key_or_url>`            |
| `junaidbhura/ninja-forms-zapier`              | `NINJA_FORMS_ZAPIER_<key_or_url>`              |
| `junaidbhura/ninja-forms-zoho`                | `NINJA_FORMS_ZOHO_<key_or_url>`                |

### PublishPress Pro Plugins

You can use any PublishPress Pro plugins by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

The following plugins are supported:

| Package name                                | Environment variables                        |
|:------------------------------------------- |:-------------------------------------------- |
| `junaidbhura/publishpress-authors-pro`      | `PUBLISHPRESS_AUTHORS_PRO_<key_or_url>`      |
| `junaidbhura/publishpress-blocks-pro`       | `PUBLISHPRESS_BLOCKS_PRO_<key_or_url>`       |
| `junaidbhura/publishpress-capabilities-pro` | `PUBLISHPRESS_CAPABILITIES_PRO_<key_or_url>` |
| `junaidbhura/publishpress-checklists-pro`   | `PUBLISHPRESS_CHECKLISTS_PRO_<key_or_url>`   |
| `junaidbhura/publishpress-future-pro`       | `PUBLISHPRESS_FUTURE_PRO_<key_or_url>`       |
| `junaidbhura/publishpress-permissions-pro`  | `PUBLISHPRESS_PERMISSIONS_PRO_<key_or_url>`  |
| `junaidbhura/publishpress-planner-pro`      | `PUBLISHPRESS_PLANNER_PRO_<key_or_url>`      |
| `junaidbhura/publishpress-revisions-pro`    | `PUBLISHPRESS_REVISIONS_PRO_<key_or_url>`    |
| `junaidbhura/publishpress-series-pro`       | `PUBLISHPRESS_SERIES_PRO_<key_or_url>`       |

### WP All Import Pro Add-Ons

You can use any WP All Import Pro add-on by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/wpai-acf-add-on`

### WP All Export Pro Add-Ons

You can use any WP All Export Pro add-on by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/wpae-acf-add-on`

### WPML Add-Ons

You can use any WPML add-on by simply adding it's slug like so:

`junaidbhura/wpml-<addon-slug>`

The following add-ons are supported:

* `junaidbhura/wpml-acfml`
* `junaidbhura/wpml-all-import`
* `junaidbhura/wpml-buddypress-multilingual`
* `junaidbhura/wpml-cms-nav`
* `junaidbhura/wpml-contact-form-7-multilingual`
* `junaidbhura/wpml-gravityforms-multilingual`
* `junaidbhura/wpml-mailchimp-for-wp`
* `junaidbhura/wpml-media-translation`
* `junaidbhura/wpml-ninja-forms`
* `junaidbhura/wpml-sticky-links`
* `junaidbhura/wpml-string-translation`
* `junaidbhura/wpml-translation-management`
* `junaidbhura/wpml-types`
* `junaidbhura/wpml-woocommerce-multilingual`
* `junaidbhura/wpml-wp-seo-multilingual`
* `junaidbhura/wpml-wpforms`
