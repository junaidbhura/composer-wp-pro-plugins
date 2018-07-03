# Composer Installer for Pro WordPress Plugins.

Currently supports:

1. Advanced Custom Fields Pro
1. Polylang Pro

## Usage

Create a `.env` file in the root of your WordPress site, where the composer.json file lives, which has all the license keys and settings:

```
ACF_PRO_KEY="<acf_pro_license_key>"
POLYLANG_PRO_KEY="<polylang_pro_license_key>"
POLYLANG_PRO_URL="<registered_url_for_polylang_pro>"
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
  }
],
"require": {
  "junaidbhura/advanced-custom-fields-pro": "*",
  "junaidbhura/polylang-pro": "*"
},
```
