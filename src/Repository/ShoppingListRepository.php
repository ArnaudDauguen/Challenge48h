<?php

namespace App\Repository;

use App\Entity\ShoppingList;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShoppingList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingList[]    findAll()
 * @method ShoppingList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingList::class);
    }
    
    public function findSuitableShoppingLists(User $user)
    {
        $qb = $this->createQueryBuilder('root');
        $qb
            ->andWhere($qb->expr()->neq('root.user', $user->getId()))
            ->andWhere('root.deliveredAt IS NULL')
            ->andWhere('root.expectedDeliveryEnd > CURRENT_TIMESTAMP()')
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }
}
