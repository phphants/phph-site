<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineGetAllMeetups implements GetAllMeetupsInterface
{
    /**
     * @var ObjectRepository
     */
    private $meetups;

    public function __construct(ObjectRepository $meetups)
    {
        $this->meetups = $meetups;
    }

    /**
     * {@inheritdoc}
     * @throws \UnexpectedValueException
     */
    public function __invoke() : array
    {
        return $this->meetups->findBy([], ['fromDate' => 'DESC']);
    }
}
