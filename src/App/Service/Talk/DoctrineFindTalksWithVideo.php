<?php
declare(strict_types = 1);

namespace App\Service\Talk;

use App\Entity\Talk;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFindTalksWithVideo implements FindTalksWithVideoInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke() : array
    {
        $query = $this->entityManager->createQuery('
            SELECT t
            FROM ' . Talk::class . ' t
            WHERE
                t.youtubeId IS NOT NULL
            ORDER BY t.time DESC
        ');

        return $query->execute();
    }
}
