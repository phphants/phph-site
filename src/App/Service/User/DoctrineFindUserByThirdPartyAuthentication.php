<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class DoctrineFindUserByThirdPartyAuthentication implements FindUserByThirdPartyAuthenticationInterface
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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(ThirdPartyAuthenticationData $thirdPartyAuthentication): User
    {
        $dql = '
            SELECT u 
            FROM ' . User::class . ' u
                JOIN u.thirdPartyLogins tpl
            WHERE
                tpl INSTANCE OF :tpType
                AND tpl.uniqueId = :tpId
        ';

        $query = $this->entityManager->createQuery($dql);
//        $query->setMaxResults(1);
        $query->execute([
            'tpType' => $thirdPartyAuthentication->serviceClass(),
            'tpId' => $thirdPartyAuthentication->uniqueId(),
        ]);

        try {
            return $query->getSingleResult();
        } catch (NoResultException $noResultException) {
            throw Exception\UserNotFound::fromThirdPartyAuthentication($thirdPartyAuthentication);
        }
    }
}
