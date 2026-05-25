<?php
//APIキーの存在チェックのみで接続可否を判定
declare( strict_types=1 );

namespace SakuraAi\Connector\Provider;

use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;

class SakuraAiProviderAvailability implements ProviderAvailabilityInterface {

	
	public function isConfigured(): bool {
		$api_key = get_option( 'connectors_ai_sakura_ai_api_key', '' );

		return is_string( $api_key ) && '' !== trim( $api_key );
	}
}
