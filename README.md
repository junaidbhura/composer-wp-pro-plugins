# Composer Installer for Pro WordPress Plugins

Install premium/paid WordPress plugins through Composer, using your license keys.

## Supported Plugins

Currently supports:

1. Advanced Custom Fields Pro
1. Gravity Forms (and add-ons)
1. Polylang Pro
1. SearchWP
1. WP All Import / Export Pro (and add-ons)

## Usage

### Define Credentials

Create an `auth.json` file in your project's root (next to the `composer.json` file) or in your global `COMPOSER_HOME` directory (often `~/.composer`). (You may already have one from [configuring basic auth or GitHub credentials](https://getcomposer.org/doc/articles/http-basic-authentication.md).) For automated environments, you can also [pass the JSON into the `COMPOSER_AUTH` environment variable](https://getcomposer.org/doc/03-cli.md#composer-auth).

In the auth.json file, add the credentials you need within a `composer-wp-pro-plugins` object, making sure to format your JSON correctly to preserve credentials for other authentication methods.

```json
{
  "composer-wp-pro-plugins": {
    "acf-pro-key": "",
    "gravity-forms-key": "",
    "polylang-pro-key": "",
    "polylang-pro-url": "",
    "searchwp-key": "",
    "searchwp-url": "",
    "wp-all-import-pro-key": "",
    "wp-all-import-pro-url": "",
    "wp-all-export-pro-key": "",
    "wp-all-export-pro-url": "",
    ...
  },
  "additional-auth-methods": {
    ...
  }
}
```

This library previously recommended using a `.env` file to store credentials, and still supports this feature for backward compatibility. If you prefer this approach, create a `.env` file in the root of your WordPress site (adjacent to the `composer.json` file), with all the license keys and settings you need.

The keys are the same as in the `auth.json` file, however they are uppercased and use underscores instead of hyphens:

```
ACF_PRO_KEY=""
GRAVITY_FORMS_KEY=""
POLYLANG_PRO_KEY=""
...
```

### Define Repositories

Next, define the repositories you would like to install. You must add at least the VCS repository for this package, and then can choose which pro plugins you would like available.

Add the following to your composer.json file:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/junaidbhura/composer-wp-pro-plugins"
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
      "name": "junaidbhura/searchwp",
      "version": "<version_number>",
      "type": "wordpress-plugin",
      "dist": {
        "type": "zip",
        "url": "https://searchwp.com"
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
```

## Install Plugins

Finally, you can require the dependencies you need, either through the JSON example below, or by running `composer require junaidbhura/plugin-name` on your command line.

```json
"require": {
  "junaidbhura/advanced-custom-fields-pro": "*",
  "junaidbhura/gravityforms": "*",
  "junaidbhura/gravityformspolls": "*",
  "junaidbhura/polylang-pro": "*",
  "junaidbhura/searchwp": "*",
  "junaidbhura/wp-all-import-pro": "*",
  "junaidbhura/wp-all-export-pro": "*",
  "junaidbhura/wpai-acf-add-on": "*"
},
```

## Gravity Forms Add-Ons

You can use any Gravity Forms add-on by simply adding its slug, like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/gravityformspolls`

Here's a list of all Gravity Forms add-on slugs: [https://docs.gravityforms.com/gravity-forms-add-on-slugs/](https://docs.gravityforms.com/gravity-forms-add-on-slugs/)

## WP All Import Pro Add-Ons

You can use any WP All Import Pro add-on by simply adding its slug, like so:

`junaidbhura/<plugin-slug>`

For example:

`junaidbhura/wpai-acf-add-on`
