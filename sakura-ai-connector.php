<?php
/**
 * Plugin Name:       Sakura AI Connector(Unofficial)
 * Plugin URI:        https://github.com/x64neco/wordpress-ai-engine
 * Description:       Unofficial: Connect WordPress to Sakura Internet AI Engine via the OpenAI-compatible API. Requires the Connectors API.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.0
 * Author:            x64neco
 * Author URI:        https://github.com/x64neco
 * Text Domain:       sakura-ai-connector
 * Domain Path:       /languages
 * License:           GPL-2.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

/**
 * Load plugin text domain for translations.
 */
add_action(
	'plugins_loaded',
	static function (): void {
		load_plugin_textdomain(
			'ai-engine-wordpress',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}
);

/**
 * Register the Sakura AI connector card via the Connectors API.
 */
add_action(
	'wp_connectors_init',
	static function ( $registry ): void {
		if ( ! is_object( $registry ) || ! method_exists( $registry, 'is_registered' ) ) {
			return;
		}

		// Unregister any auto-detected connector so we can re-register with plugin.file.
		if ( $registry->is_registered( 'sakura_ai' ) && method_exists( $registry, 'unregister' ) ) {
			$registry->unregister( 'sakura_ai' );
		}

		$registry->register(
			'sakura_ai',
			array(
				'name'           => __( 'Sakura AI Engine', 'ai-engine-wordpress' ),
				'description'    => __( 'AI Engine running on Sakura Internet domestic data centers. Use AI features quickly and securely via an OpenAI-compatible API.', 'ai-engine-wordpress' ),
				'type'           => 'ai_provider',
				'authentication' => array(
					'method'          => 'api_key',
					'credentials_url' => 'https://cloud.sakura.ad.jp/',
				),
				'plugin'         => array(
					'file' => plugin_basename( __FILE__ ),
				),
			)
		);
	},
	20
);

/**
 * Register the AI Client SDK provider.
 */
add_action(
	'init',
	static function (): void {
		if ( ! class_exists( '\\WordPress\\AiClient\\AiClient' ) ) {
			return;
		}

		$base_dir = __DIR__ . '/src/';
		$files    = array(
			$base_dir . 'Provider/SakuraAiProviderAvailability.php',
			$base_dir . 'Provider/SakuraAiModelMetadataDirectory.php',
			$base_dir . 'Provider/SakuraAiProvider.php',
			$base_dir . 'Models/SakuraAiTextGenerationModel.php',
		);

		foreach ( $files as $file ) {
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}

		if ( ! class_exists( '\\SakuraAi\\Connector\\Provider\\SakuraAiProvider' ) ) {
			return;
		}

		try {
			$registry = \WordPress\AiClient\AiClient::defaultRegistry();

			if ( $registry->hasProvider( 'sakura_ai' ) ) {
				return;
			}

			$registry->registerProvider( \SakuraAi\Connector\Provider\SakuraAiProvider::class );
		} catch ( \Throwable $e ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				error_log( '[Sakura AI Connector] Registration error: ' . $e->getMessage() );
			}
		}
	},
	5
);