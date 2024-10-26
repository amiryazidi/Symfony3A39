<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function fetchStudentsByName($name)
    {
        $em=$this->getEntityManager();
        $req=$em->createQuery('SELECT s FROM App\Entity\Student s WHERE s.name = :n');
        $req->setParameter('n',$name);
        $result=$req->getResult();
        return $result;

    }

    public function fetchStudentsAffected()
    {
        $em=$this->getEntityManager();
        $req=$em->createQuery("select s from App\Entity\Student s join s.classroom c where c.name='3A40' ");
        $result=$req->getResult();
        return $result;

    }

    public function listEtudniatQB(){
        $req=$this->createQueryBuilder('s')
            ->select('s.name','c.name as classroom')
            ->join("s.classroom","c")
            ->where("c.name='3A40'")
            ->orderBy("s.name","DESC");
        $preresult=$req->getQuery();
        $result=$preresult->getResult();
        return $result;
    }

}
