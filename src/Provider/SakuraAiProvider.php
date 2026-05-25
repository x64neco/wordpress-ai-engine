<?php

declare( strict_types=1 );

namespace SakuraAi\Connector\Provider;

use SakuraAi\Connector\Models\SakuraAiTextGenerationModel;
use WordPress\AiClient\Providers\ApiBasedImplementation\AbstractApiProvider;
use WordPress\AiClient\Providers\Contracts\ModelMetadataDirectoryInterface;
use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;
use WordPress\AiClient\Providers\DTO\ProviderMetadata;
use WordPress\AiClient\Providers\Enums\ProviderTypeEnum;
use WordPress\AiClient\Providers\Http\Enums\RequestAuthenticationMethod;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;

class SakuraAiProvider extends AbstractApiProvider {

	
	protected static function baseUrl(): string {
		return 'https://api.ai.sakura.ad.jp/v1';
	}

	
	protected static function createProviderMetadata(): ProviderMetadata {
		return new ProviderMetadata(
			'sakura_ai',
			'Sakura AI Engine',
			ProviderTypeEnum::from( 'cloud' ),
			'https://cloud.sakura.ad.jp/',
			RequestAuthenticationMethod::from( 'api_key' ),
			'AI Engine',
		);
	}

	
	protected static function createProviderAvailability(): ProviderAvailabilityInterface {
		return new SakuraAiProviderAvailability();
	}

	
	protected static function createModelMetadataDirectory(): ModelMetadataDirectoryInterface {
		return new SakuraAiModelMetadataDirectory();
	}

	protected static function createModel(
		ModelMetadata $modelMetadata,
		ProviderMetadata $providerMetadata
	): ModelInterface {
		return new SakuraAiTextGenerationModel( $modelMetadata, $providerMetadata );
	}
}
