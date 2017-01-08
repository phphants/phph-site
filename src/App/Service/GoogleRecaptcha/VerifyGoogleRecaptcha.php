<?php
declare(strict_types = 1);

namespace App\Service\GoogleRecaptcha;

use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

class VerifyGoogleRecaptcha implements VerifyGoogleRecaptchaInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestInterface
     */
    private $requestBlueprint;

    /**
     * @var string
     */
    private $apiSecret;

    public function __construct(HttpClient $httpClient, RequestInterface $requestBlueprint, string $apiSecret)
    {
        $this->httpClient = $httpClient;
        $this->requestBlueprint = $requestBlueprint;
        $this->apiSecret = $apiSecret;
    }

    public function __invoke(string $verificationString) : array
    {
        $request = clone $this->requestBlueprint;
        $request->getBody()->write(http_build_query([
            'secret' => $this->apiSecret,
            'response' => $verificationString,
        ]));

        $response = $this->httpClient->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }
}
