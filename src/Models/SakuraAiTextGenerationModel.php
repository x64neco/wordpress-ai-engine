<?php

declare( strict_types=1 );

namespace SakuraAi\Connector\Models;

use SakuraAi\Connector\Provider\SakuraAiProvider;
use WordPress\AiClient\Providers\Http\DTO\Request;
use WordPress\AiClient\Providers\Http\Enums\HttpMethodEnum;
use WordPress\AiClient\Providers\OpenAiCompatibleImplementation\AbstractOpenAiCompatibleTextGenerationModel;

class SakuraAiTextGenerationModel extends AbstractOpenAiCompatibleTextGenerationModel {

	/**
	 * Build a Request following the OpenAI-compatible provider pattern.
	 *
	 * @param HttpMethodEnum $method  HTTP method.
	 * @param string         $path    API endpoint path.
	 * @param array          $headers Request headers.
	 * @param mixed          $data    Request body data.
	 * @return Request
	 */
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
