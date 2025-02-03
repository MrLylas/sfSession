<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TraineeController extends AbstractController
{
    
    #[Route('/trainee', name: 'app_trainee')]
    public function index(TraineeRepository $traineeRepository): Response
    {
        // $trainees = $traineeRepository->findAll();
        $trainees = $traineeRepository->findBy([],["lastName"=>"ASC"]);
        return $this->render('trainee/index.html.twig', [
            'trainees' => $trainees
        ]);
    }

    #[Route('/trainee/{id}', name: 'app_trainee_show')]
    public function show(Trainee $trainee, TraineeRepository $traineeRepository) : Response
    { 
        return $this->render('trainee/show.html.twig',[
            'trainee' => $trainee
        ]);
    }

    #[Route('/trainee/new', name: 'new_trainee')]
    #[Route('/trainee/{id}/edit', name: 'edit_trainee')]
    public function new_edit(Trainee $trainee = null ,Request $request,EntityManagerInterface $entityManager): Response
    {
        if (!$trainee) {
            $trainee = new Trainee();
        }
        
        $form = $this->createForm(TraineeType::class, $trainee);

        $form->handleRequest($request);//On prend en charge la requête demandée 

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

            $trainee = $form->getData();//Recuperation des données du formulaire

            $entityManager->persist($trainee);//Similaire à pdo->prepare

            $entityManager->flush();//Similaire à pdo->execute

            return $this->redirectToRoute('app_trainee');//Redirection vers la liste des entreprises
        }
        
        return $this->render('trainee/new.html.twig', [
            'formAddtrainee' => $form,
            'edit'=>$trainee->getId()
        ]);
    }
}
