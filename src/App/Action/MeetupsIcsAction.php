<?php
declare(strict_types = 1);

namespace App\Action;

use App\Service\Meetup\MeetupsServiceInterface;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Sabre\VObject\Component\VCalendar;
use Zend\Diactoros\Response\TextResponse;
use Zend\Stratigility\MiddlewareInterface;

final class MeetupsIcsAction implements MiddlewareInterface
{
    /**
     * @var MeetupsServiceInterface
     */
    private $meetupsService;

    public function __construct(MeetupsServiceInterface $meetupsService)
    {
        $this->meetupsService = $meetupsService;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : TextResponse
    {
        $now = new DateTimeImmutable();
        $cal = new VCalendar();

        $meetups = $this->meetupsService->findMeetupsAfter($now);

        foreach ($meetups as $meetup) {
            $from = $meetup->getFromDate();
            $from->setTimezone(new \DateTimeZone('Europe/London'));

            $month = $from->format('F');
            $year = $from->format('Y');

            $cal->add('VEVENT', [
                'UID' => $from->format('YmdHis') . '@phphants.co.uk',
                'SUMMARY' => sprintf('PHP Hampshire %s %d Meetup', $month, $year),
                'DTSTAMP' => $from,
                'DTSTART' => $from,
                'DTEND' => $meetup->getToDate(),
            ]);
        }

        return (new TextResponse($cal->serialize()))
            ->withHeader('Content-type', 'text/calendar');
    }
}
