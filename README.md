# Composer Installer for Pro WordPress Plugins.

**Important Note: Most EDD plugins, and Gravity Forms only allow getting the latest versions of their plugins, even if you specifically ask for a version.**

Currently supports:

1. Advanced Custom Fields Pro
1. Gravity Forms and Add-Ons
1. Polylang Pro
1. WP All Import / Export Pro

## Usage

Create a `.env` file in the root of your WordPress site, where the composer.json file lives, which has all the license keys and settings:

```
ACF_PRO_KEY="<acf_pro_license_key>"
GRAVITY_FORMS_KEY="<gravity_forms_license_key>"
POLYLANG_PRO_KEY="<polylang_pro_license_key>"
POLYLANG_PRO_URL="<registered_url_for_polylang_pro>"
WP_ALL_IMPORT_PRO_KEY="<wp_all_import_license_key>"
WP_ALL_IMPORT_PRO_URL="<registered_url_for_wpai_pro>"
WP_ALL_EXPORT_PRO_KEY="<wp_all_export_license_key>"
WP_ALL_EXPORT_PRO_URL="<registered_url_for_wpae_pro>"
```

Add the following to your composer.json file:

```json
"repositories":[
  {
    "type":"vcs",
    "url":"https://github.com/junaidbhura/composer-wp-pro-plugins"
  },
  {
    "type": "package",
    "package": {
      "name": "junaidbhura/advanced-custom-fields-pro",
      "version": "<version_number>",
      "type": "wordpress-plugin",
      "dist": {
        "type": "zip",
        "url": "https://www.advancedcustomfields.com"
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
        "url": "https://www.gravityforms.com"
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
        "url": "https://www.gravityforms.com"
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
        "url": "https://www.polylang.pro"
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
        "url": "https://www.wpallimport.com"
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
        "url": "https://www.wpallimport.com"
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
        "url": "https://www.wpallimport.com"
      },
      "require": {
        "junaidbhura/composer-wp-pro-plugins": "*"
      }
    }
  }
],
"require": {
  "junaidbhura/advanced-custom-fields-pro": "*",
  "junaidbhura/gravityforms": "*",
  "junaidbhura/gravityformspolls": "*",
  "junaidbhura/polylang-pro": "*",
  "junaidbhura/wp-all-import-pro": "*",
  "junaidbhura/wp-all-export-pro": "*",
  "junaidbhura/wpai-acf-add-on": "*"
},
```

## Gravity Forms Add-Ons

You can use any Gravity Forms add-on by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/gravityformspolls`

Here's a list of all Gravity Forms add-on slugs: [https://docs.gravityforms.com/gravity-forms-add-on-slugs/](https://docs.gravityforms.com/gravity-forms-add-on-slugs/)

## WP All Import Pro Add-Ons

You can use any WP All Import Pro add-on by simply adding it's slug like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/wpai-acf-add-on`
