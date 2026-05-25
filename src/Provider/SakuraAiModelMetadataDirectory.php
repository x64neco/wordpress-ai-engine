<?php

declare( strict_types=1 );

namespace SakuraAi\Connector\Provider;

use WordPress\AiClient\Providers\Contracts\ModelMetadataDirectoryInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;
use WordPress\AiClient\Providers\Models\DTO\SupportedOption;
use WordPress\AiClient\Providers\Models\Enums\CapabilityEnum;
use WordPress\AiClient\Providers\Models\Enums\OptionEnum;
use WordPress\AiClient\Messages\Enums\ModalityEnum;

class SakuraAiModelMetadataDirectory implements ModelMetadataDirectoryInterface {

	
	public function listModelMetadata(): array {
		return array( $this->buildGptOss120bMetadata() );
	}

	public function hasModelMetadata( string $modelId ): bool {
		return $modelId === 'gpt-oss-120b';
	}

	
	//とりあえずgpt-oss-120bだけ
	public function getModelMetadata( string $modelId ): ModelMetadata {
		if ( 'gpt-oss-120b' === $modelId ) {
			return $this->buildGptOss120bMetadata();
		}
		return new ModelMetadata(
			$modelId,
			$modelId,
			array( CapabilityEnum::textGeneration() ),
			array()
		);
	}
	
	private function buildGptOss120bMetadata(): ModelMetadata {
		return new ModelMetadata(
			'gpt-oss-120b',
			'GPT OSS 120B',
			array(
				CapabilityEnum::textGeneration(),
				CapabilityEnum::chatHistory(),
			),
			array(
				new SupportedOption( OptionEnum::systemInstruction() ),
				new SupportedOption( OptionEnum::maxTokens() ),
				new SupportedOption( OptionEnum::temperature() ),
				new SupportedOption( OptionEnum::topP() ),
				new SupportedOption( OptionEnum::stopSequences() ),
				new SupportedOption( OptionEnum::presencePenalty() ),
				new SupportedOption( OptionEnum::frequencyPenalty() ),
				new SupportedOption(
					OptionEnum::inputModalities(),
					array( array( ModalityEnum::text() ) )
				),
				new SupportedOption(
					OptionEnum::outputModalities(),
					array( array( ModalityEnum::text() ) )
				),
				new SupportedOption(
					OptionEnum::outputMimeType(),
					array( 'text/plain', 'application/json' )
				),
				new SupportedOption( OptionEnum::customOptions() ),
			)
		);
	}
}
