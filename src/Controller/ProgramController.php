<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Category;
use App\Form\ProgramType;
use App\Form\TraineeToProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProgramController extends AbstractController
{
    // #[Route('/program', name: 'app_program')]
    // public function index(Program $program): Response
    // {
    //     return $this->render('program/index.html.twig', [
    //         'controller_name' => 'ProgramController',
    //         'programs' => $program
    //     ]);
    // }

    #[Route('/program', name: 'app_program')]
    public function index(ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $program,
        ]);
    }

    #[Route('/program/{id}', name: 'app_program_show')]
    public function show(Program $program,) : Response
    { 
        return $this->render('program/show.html.twig',[
            'program' => $program,
        ]);  
    }

    #[Route('/program/remove/{session}/{program}/', name: 'remove_program_from_session')]
    public function removeProgramFromSession(Program $program, Session $session, EntityManagerInterface $entityManager,Course $course): Response
    {
        $course = $program->getCourse();
        $course->removeProgram($program);
        $entityManager->persist($course);
        $entityManager->flush();

        $session->removeProgram($program);
        $entityManager->persist($session);
        $entityManager->flush();


        return $this->redirectToRoute('app_session_show',[
            'session' => $session->getId(),
            'program' => $program->getId(),
            'course' => $course->getId()
        ]);
    }

    #[Route('/program/new', name: 'new_program')]
    #[Route('/program/{program}/edit', name: 'edit_program')]
    public function new_program(Request $request,EntityManagerInterface $entityManager, Program $program = null)
    {
        // if (!$program) {
        //         $program = new Program();
        //     }
        
        // $form = $this->createForm(ProgramType::class, $program);

        // $form->handleRequest($request);//On prend en charge la requête demandée 

        // if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

        //     $program = $form->getData();//Recuperation des données du formulaire

        //     $entityManager->persist($program);//Similaire à pdo->prepare

        //     $entityManager->flush();//Similaire à pdo->execute

        //     return $this->redirectToRoute('show_program');//Redirection vers la liste des stagiaires
        // }
        
        return $this->render('program/new.html.twig', [
            // 'formAddProgram' => $form,
            // 'program'=>$program->getId()
        ]);
    }
}
