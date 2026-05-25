<?php

declare( strict_types=1 );

namespace SakuraAi\Connector\Models;

use SakuraAi\Connector\Provider\SakuraAiProvider;
use WordPress\AiClient\Providers\Http\DTO\Request;
use WordPress\AiClient\Providers\Http\Enums\HttpMethodEnum;
use WordPress\AiClient\Providers\OpenAiCompatibleImplementation\AbstractOpenAiCompatibleTextGenerationModel;

class SakuraAiTextGenerationModel extends AbstractOpenAiCompatibleTextGenerationModel {

	
	//OpenAI プロバイダーのパターンに準拠した
	//Request(method, uri, headers, data, options)
	//getRequestOptions() で追加設定のはず
	protected function createRequest(
		HttpMethodEnum $method,
		string $path,
		array $headers = array(),
		$data = null
	): Request {
		return new Request(
			$method,
			SakuraAiProvider::url( $path ),
			$headers,
			$data,
			$this->getRequestOptions()
		);
	}
}
