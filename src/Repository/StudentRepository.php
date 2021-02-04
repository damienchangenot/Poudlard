<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\StudentSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findStudent(StudentSearch $studentSearch)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        if($studentSearch->getName()){
            $queryBuilder->
                andWhere('s.name LIKE :name')
                    ->setParameter('name', '%'. $studentSearch->getName() .'%');
        }
        if ($studentSearch->getIsTeacher() == true){
            $queryBuilder->
                andWhere('s.IsTeacher = :IsTeacher')
                    ->setParameter('IsTeacher', $studentSearch->getIsTeacher());
        }
        if (!($studentSearch->getHouse()->isEmpty())){
            $queryBuilder->
                join('s.house', 'h')
                ->andWhere('h.id IN(:house)')
                    ->setParameter('house', $studentSearch->getHouse());
        }
        return $queryBuilder->getQuery()->getResult();
    }

}
