<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\FindMeetupByUuidInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class PickWinnerAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var FindMeetupByUuidInterface
     */
    private $findMeetupByUuid;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FindMeetupByUuidInterface $findMeetupByUuid
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->findMeetupByUuid = $findMeetupByUuid;
    }

    /**
     * {@inheritDoc}
     * @throws \App\Service\Meetup\Exception\MeetupNotFound
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $meetup = $this->findMeetupByUuid->__invoke(Uuid::fromString($request->getAttribute('meetup')));

        return new HtmlResponse($this->templateRenderer->render('account::meetup/pick-a-winner', [
            'meetup' => $meetup,
            'winner' => $meetup->pickPrizeDrawWinner(),
        ]));
    }
}
