<?php
declare(strict_types = 1);

namespace App\Service\Video;

use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineGetAllVideos implements GetAllVideosInterface
{
    /**
     * @var ObjectRepository
     */
    private $videos;

    public function __construct(ObjectRepository $videos)
    {
        $this->videos = $videos;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke() : array
    {
        return $this->videos->findAll();
    }
}
