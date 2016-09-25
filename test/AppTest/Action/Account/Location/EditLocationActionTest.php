<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Location;

use App\Action\Account\Location\EditLocationAction;
use App\Entity\Location;
use App\Service\Location\FindLocationByUuid;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

/**
 * @covers \App\Action\Account\Location\EditLocationAction
 */
final class EditLocationActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $form;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var TemplateRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $urlHelper;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var FindLocationByUuid|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findLocation;

    /**
     * @var EditLocationAction
     */
    private $action;

    public function setUp()
    {
        $this->location = Location::fromNameAddressAndUrl(
            'Original name',
            'Original address',
            'https://test-uri.com/'
        );

        $this->form = $this->createMock(FormInterface::class);
        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->findLocation = $this->createMock(FindLocationByUuid::class);
        $this->findLocation->expects(self::once())
            ->method('__invoke')
            ->with($this->location->getId())
            ->willReturn($this->location);

        $this->action = new EditLocationAction(
            $this->renderer,
            $this->findLocation,
            $this->form,
            $this->entityManager,
            $this->urlHelper
        );
    }

    public function testGetRequestRendersTemplate()
    {
        $this->form->expects(self::once())->method('setData');
        $this->form->expects(self::never())->method('isValid');
        $this->form->expects(self::never())->method('getData');

        $this->renderer->expects(self::once())->method('render')->with('account::location/edit', [
            'title' => 'Edit location',
            'form' => $this->form,
        ])->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->entityManager->expects(self::never())->method('transactional');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('GET')
                ->withAttribute('uuid', $this->location->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $this->renderer->expects(self::once())
            ->method('render')
            ->with('account::location/edit')
            ->willReturn('content...');

        $this->urlHelper->expects(self::never())->method('generate');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(false);
        $this->form->expects(self::never())->method('getData');

        $this->entityManager->expects(self::never())->method('transactional');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->location->getId())
                ->withParsedBody([
                    'name' => '',
                    'address' => '',
                    'url' => '',
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestCreatesMeetupAndPersists()
    {
        $this->renderer->expects(self::never())->method('render');

        $this->urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-locations-list')
            ->willReturn('/account/locations');

        $this->form->expects(self::exactly(2))->method('setData');
        $this->form->expects(self::once())->method('isValid')->willReturn(true);
        $this->form->expects(self::once())->method('getData')->willReturn([
            'name' => 'Foo Bar',
            'address' => 'Foo Street',
            'url' => 'https://foo.com/',
        ]);

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        $response = $this->action->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withAttribute('uuid', $this->location->getId())
                ->withParsedBody([
                    'name' => 'Foo Bar',
                    'address' => 'Foo Street',
                    'url' => 'https://foo.com/',
                ]),
            new Response()
        );

        self::assertSame('Foo Bar', $this->location->getName());
        self::assertSame('Foo Street', $this->location->getAddress());
        self::assertSame('https://foo.com/', $this->location->getUrl());

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/locations', $response->getHeaderLine('Location'));
    }
}
