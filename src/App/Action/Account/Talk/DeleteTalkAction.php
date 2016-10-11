<?php
declare(strict_types = 1);

namespace App\Action\Account\Talk;

use App\Service\Talk\FindTalkByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;

final class DeleteTalkAction implements MiddlewareInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FindTalkByUuidInterface
     */
    private $findTalkByUuid;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        FindTalkByUuidInterface $findTalkByUuid,
        UrlHelper $urlHelper
    ) {
        $this->entityManager = $entityManager;
        $this->findTalkByUuid = $findTalkByUuid;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $talk = $this->findTalkByUuid->__invoke(Uuid::fromString($request->getAttribute('uuid')));
        $meetup = $talk->getMeetup();

        $this->entityManager->transactional(function () use ($talk) {
            $this->entityManager->remove($talk);
        });

        return new RedirectResponse($this->urlHelper->generate('account-meetup-view', [
            'uuid' => $meetup->getId(),
        ]));
    }
}
