<?php
// Determine availability based on API key existence.
declare( strict_types=1 );

namespace SakuraAi\Connector\Provider;

use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;

class SakuraAiProviderAvailability implements ProviderAvailabilityInterface {

	/**
	 * Check whether the provider is configured.
	 *
	 * @return bool True if an API key is present.
	 */
	public function isConfigured(): bool {
		$api_key = get_option( 'connectors_ai_sakura_ai_api_key', '' );

		return is_string( $api_key ) && '' !== trim( $api_key );
	}
}
