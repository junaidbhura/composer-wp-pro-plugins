<?php

/**
 * Resolves additional baselines and configurations to apply to PHPStan's
 * analysis based on the version of PHP, Composer, and the project's packages.
 *
 * To resolve these conditional baselines, we have to replace the initial data
 * of {@see \Composer\InstalledVersions} which contains PHPStan's dependencies,
 * since the context is its PHAR.
 *
 * To accomplish this, we have to retrieve the contents of the project's
 * installed dependencies from either:
 *
 * 1. 'vendor/composer/installed.php' — Composer v2 PHP format.
 * 2. 'vendor/composer/installed.json' — Either Composer v2 or v1 JSON format.
 *
 * The JSON format is tricky because it changes drastically between Composer v1
 * and v2 and the v2 PHP format. Both JSON formats must be remapped to the PHP
 * format expected by `InstalledVersions`.
 *
 * If the project's installed dependencies cannot be loaded, this file returns
 * only the PHP baselines.
 *
 * If the project's installed dependencies can be loaded, the extra baselines
 * are resolved and the initial data of `InstalledVersions` is restored.
 */

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

$config = array();
$config['includes'] = array();
$config['parameters']['phpVersion'] = PHP_VERSION_ID;

if ( PHP_VERSION_ID >= 80000 ) {
	$config['includes'][] = __DIR__ . '/baseline-php-8.neon';
} else {
	$config['includes'][] = __DIR__ . '/baseline-php-7.neon';
}

$cwd = getcwd();
if ( ! is_string( $cwd ) ) {
	return $config;
}

if ( file_exists( $cwd . '/vendor/composer/installed.php' ) ) {
	$projectInstalled = require $cwd . '/vendor/composer/installed.php';
} elseif ( file_exists( $cwd . '/vendor/composer/installed.json' ) ) {
	$json = file_get_contents( $cwd . '/vendor/composer/installed.json' );
	if ( ! is_string( $json ) ) {
		return $config;
	}

	$installed = json_decode( $json, true );
	if ( ! is_array( $installed ) ) {
		return $config;
	}

	$projectInstalled = array(
		'root'     => array(),
		'versions' => array(),
	);

	$packages = isset( $installed['packages'] ) ? $installed['packages'] : $installed;

	if ( is_array( $packages ) ) {
		foreach ( $packages as $package ) {
			$projectInstalled['versions'][ $package['name'] ] = array(
				'pretty_version'  => $package['version'],
				'version'         => $package['version_normalized'],
				'reference'       => (
					isset( $package['dist']['reference'] )
					? $package['dist']['reference']
					: (
						isset( $package['source']['reference'] )
						? $package['source']['reference']
						: null
					)
				),
				'type'            => $package['type'],
				'install_path'    => (
					isset( $package['install-path'] )
					? __DIR__ . '/' . $package['install-path']
					: null
				),
				'aliases'         => (
					isset( $package['extra']['branch-alias'] )
					? array_values( $package['extra']['branch-alias'] )
					: array()
				),
				'dev_requirement' => (
					isset( $installed['dev-package-names'] )
					? in_array( $package['name'], $installed['dev-package-names'], true )
					: false
				),
			);
		}
	}
}

if ( empty( $projectInstalled['versions'] ) ) {
	return $config;
}

$pharInstalled = InstalledVersions::getAllRawData();
InstalledVersions::reload( $projectInstalled );

$versionParser = new VersionParser();

if ( InstalledVersions::isInstalled( 'composer/composer' ) ) {
	if ( InstalledVersions::satisfies( $versionParser, 'composer/composer', '^1') ) {
		$config['includes'][] = __DIR__ . '/baseline-composer-1.neon';
	} else {
		$config['includes'][] = __DIR__ . '/baseline-composer-2.neon';
	}
}

if ( InstalledVersions::isInstalled( 'vlucas/phpdotenv' ) ) {
	if ( InstalledVersions::satisfies( $versionParser, 'vlucas/phpdotenv', '^3') ) {
		$config['includes'][] = __DIR__ . '/baseline-phpdotenv-3.neon';
	} elseif ( InstalledVersions::satisfies( $versionParser, 'vlucas/phpdotenv', '^4') ) {
		$config['includes'][] = __DIR__ . '/baseline-phpdotenv-4.neon';
	} else {
		$config['includes'][] = __DIR__ . '/baseline-phpdotenv-5.neon';
	}
}

InstalledVersions::reload( $pharInstalled ? end( $pharInstalled[0] ) : array() );

return $config;
