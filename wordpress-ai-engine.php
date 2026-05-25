<?php
/**
 * Plugin Name:       wordpress-ai-engine (unofficial)
 * Plugin URI:        https://github.com/x64neco/wordpress-ai-engine
 * Description:       注意:非公式です。ツールのコネクタの承認から承認して使えます。
 * @since 1.0.0
 * Author:            x64neco
 * License:           GPL-2.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;


//Connectors API カード登録
add_action(
	'wp_connectors_init',
	static function ( $registry ): void {
		if ( ! is_object( $registry ) || ! method_exists( $registry, 'is_registered' ) ) {
			return;
		}

		//plugin.file が必要なため自動検出されたコネクターを上書き
		if ( $registry->is_registered( 'sakura_ai' ) && method_exists( $registry, 'unregister' ) ) {
			$registry->unregister( 'sakura_ai' );
		}

		$registry->register(
			'sakura_ai',
			array(
				'name'           => __( 'Sakura AI Engine', 'sakura-ai-connector' ),
				'description'    => __( 'さくらインターネットの国内データセンターで稼働するAI Engine。OpenAI互換APIで高速・安全にAI機能を利用できます。', 'sakura-ai-connector' ),
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


//AI Client SDKを使ったプロバイダー登録関連
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
			// デバッグファイルにエラーを記録
			file_put_contents(
				__DIR__ . '/sakura-ai-register-error.txt',
				gmdate( 'Y-m-d H:i:s' ) . " Registration error:\n"
				. $e->getMessage() . "\n"
				. $e->getTraceAsString() . "\n"
			);
		}
	},
	5
);

//なんかうまく動かなかったからデバッグ追加。
add_action(
	'admin_init',
	static function (): void {
		$output = "=== debug sakura ===\n";

		if ( function_exists( 'wp_get_connector' ) ) {
			$output .= "connector: " . print_r( wp_get_connector( 'sakura_ai' ), true ) . "\n";
		}

		$output .= "key: " . print_r( get_option( 'connectors_ai_sakura_ai_api_key' ), true ) . "\n";

		if ( class_exists( '\\WordPress\\AiClient\\AiClient' ) ) {
			try {
				$r = \WordPress\AiClient\AiClient::defaultRegistry();
				$output .= "providers: " . print_r( $r->getRegisteredProviderIds(), true ) . "\n";
				$output .= "configured: " . print_r( $r->isProviderConfigured( 'sakura_ai' ), true ) . "\n";
			} catch ( \Throwable $e ) {
				$output .= "error1: " . $e->getMessage() . "\n";
			}
		}

		if ( function_exists( 'wp_ai_get_text' ) ) {
			try {
				$output .= "test: " . print_r( wp_ai_get_text( 'say hello' ), true ) . "\n";
			} catch ( \Throwable $e ) {
				$output .= "error2: " . $e->getMessage() . "\n";
				$output .= "trace: " . $e->getTraceAsString() . "\n";
			}
		}

		file_put_contents( __DIR__ . '/sakura-ai-debug.txt', $output );
	}
);