<?php
declare(strict_types = 1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\User\FindUserByIdInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;

final class CancelCheckInAction implements MiddlewareInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FindMeetupByUuidInterface
     */
    private $findMeetupByUuid;

    /**
     * @var FindUserByIdInterface
     */
    private $findUserById;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        FindMeetupByUuidInterface $findMeetupByUuid,
        FindUserByIdInterface $findUserById,
        UrlHelper $urlHelper
    ) {
        $this->entityManager = $entityManager;
        $this->findMeetupByUuid = $findMeetupByUuid;
        $this->findUserById = $findUserById;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $meetup = $this->findMeetupByUuid->__invoke(Uuid::fromString($request->getAttribute('meetup')));
        $user = $this->findUserById->__invoke(Uuid::fromString($request->getAttribute('user')));

        $this->entityManager->transactional(function () use ($meetup, $user) {
            $meetup->cancelCheckIn($user);
        });

        return new RedirectResponse($this->urlHelper->generate('account-meetup-view', ['uuid' => $meetup->getId()]));
    }
}
