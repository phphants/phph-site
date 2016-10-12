<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineGetAllSpeakers implements GetAllSpeakersInterface
{
    /**
     * @var ObjectRepository
     */
    private $speakers;

    public function __construct(ObjectRepository $speakers)
    {
        $this->speakers = $speakers;
    }

    /**
     * {@inheritdoc}
     * @throws \UnexpectedValueException
     */
    public function __invoke() : array
    {
        return $this->speakers->findBy([], ['fullName' => 'ASC']);
    }
}
