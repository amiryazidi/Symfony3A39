<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fecth(StudentRepository $repo): Response
    {               //1ére etape : injecter StudentRepository
        $result = $repo->findAll(); // 2éme etape :recuperer la liste des students
        return $this->render('student/list.html.twig', [
            'students' => $result,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $mr , ClassroomRepository $repo, Request $req): Response
    {    //1 : injecter ManagerRegistry
        //2 : creer une instace de student
         $s = new Student();
        //3 : creation de formulaire , remplir l'instance 
        $form=$this->createForm(StudentType::class,$s);
         //4 : recuperer les données du formulaire
         $form->handleRequest($req);
             if ($form->isSubmitted()) 
             {
                $em=$mr->getManager();
                $em->persist($s);
                $em->flush();
             }
     
         return $this->render('student/add.html.twig', [
            'f' => $form,
        ]);

  
}
#[Route('/remove/{id}', name: 'remove')]
public function remove(ManagerRegistry $mr,$id, StudentRepository $repo): Response
{
    $student= $repo->find($id); 
    $em=$mr->getManager();
    $em->remove($student);
    $em->flush();
    return $this->redirectToRoute('fetch');

}

#[Route('/update/{id}', name: 'update')]
public function update(ManagerRegistry $mr,$id, StudentRepository $repo): Response
{
    $student= $repo->find($id); 
    $student->setName('update');
    $em=$mr->getManager();
    $em->persist($student);
    $em->flush();
    return $this->redirectToRoute('fetch');

}

#[Route('/dql', name: 'dql')]
    public function dqlStudents(EntityManagerInterface $em, Request $request,StudentRepository $repo): Response
    {

        $result = $repo->findAll();
         // verification de
        if($request ->isMethod('POST')) {
           $value = $request->request->get('recup');
              $result = $repo->fetchStudentsByName($value);
        }
        return $this->render('student/dql.html.twig', [
            'students' => $result,
        ]);
    }
     
    // dql -2 : calculer le nombres des etudiants
    #[Route('/dql2', name: 'dql2')]
    public function dql2(EntityManagerInterface $em)
    {
        $req = $em->createQuery('select count(s) from App\Entity\Student s');
        $result= $req->getResult();
        dd($result);
    }

     // dql -3 : Afficher les noms des étudiants ordonnées ascendent
     #[Route('/dql3', name: 'dql3')]
     public function dql3(EntityManagerInterface $em)
     {
         $req = $em->createQuery('select s from App\Entity\Student s order by s.name DESC');
         $result= $req->getResult();
         dd($result);
     }

        // dql -4 : 
        #[Route('/dqlJoin', name: 'dqlJoin')]
        public function dqlJoin(EntityManagerInterface $em, StudentRepository $repo)
        {
                $result = $repo->fetchStudentsAffected();
            dd($result);
          
        }

        //QB : 
        #[Route('/Qb', name: 'Qb')]
        public function Qb(StudentRepository $repo)
        {
                $result = $repo->listEtudniatQB();
            dd($result);
          
        }





}