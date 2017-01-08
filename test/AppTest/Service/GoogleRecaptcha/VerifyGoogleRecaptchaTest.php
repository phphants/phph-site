<?php
declare(strict_types = 1);

namespace AppTest\Service\GoogleRecaptcha;

use App\Service\GoogleRecaptcha\VerifyGoogleRecaptcha;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

/**
 * @covers \App\Service\GoogleRecaptcha\VerifyGoogleRecaptcha
 */
class VerifyGoogleRecaptchaTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestIsSentAndResponseParsed()
    {
        $apiSecret = uniqid('apiSecret', true);
        $verification = uniqid('verification', true);

        $returnData = [
            'success' => true,
            'error-codes' => [],
        ];

        /** @var HttpClient|\PHPUnit_Framework_MockObject_MockObject $httpClient */
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function (RequestInterface $request) use ($apiSecret, $verification) {
                $request->getBody()->rewind();
                self::assertSame(
                    'secret=' . $apiSecret . '&response=' . $verification,
                    $request->getBody()->getContents()
                );
                return true;
            }))
            ->willReturn(new Response\JsonResponse($returnData, 200));

        $requestBlueprint = new Request();

        self::assertSame(
            $returnData,
            (new VerifyGoogleRecaptcha($httpClient, $requestBlueprint, $apiSecret))->__invoke($verification)
        );
    }
}
