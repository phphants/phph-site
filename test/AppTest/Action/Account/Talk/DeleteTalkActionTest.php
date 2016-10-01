<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Talk;

use App\Action\Account\Talk\DeleteTalkAction;
use App\Entity\Meetup;
use App\Entity\Talk;
use App\Service\Talk\FindTalkByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Action\Account\Talk\DeleteTalkAction
 */
final class DeleteTalkActionTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleteActionDeletesTalkAndRedirectsToMeetup()
    {
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());

        $talkToDelete = Talk::fromTitle($meetup, new \DateTimeImmutable(), 'The Talk Title');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $entityManager->expects(self::once())->method('remove')->with($talkToDelete);

        $findTalk = $this->createMock(FindTalkByUuidInterface::class);
        $findTalk->expects(self::once())->method('__invoke')->with($talkToDelete->getId())->willReturn($talkToDelete);

        $redirectUrl = uniqid('/account/meetup/view', true);
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-meetup-view')
            ->willReturn($redirectUrl);

        $response = (new DeleteTalkAction($entityManager, $findTalk, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('get')
                ->withAttribute('uuid', $talkToDelete->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($redirectUrl, $response->getHeaderLine('Location'));
    }
}
