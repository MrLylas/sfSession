<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            
        ]);
    }

    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_session(Request $request,EntityManagerInterface $entityManager, Session $session = null)
    {
        if (!$session) {
                $session = new Session();
            }
        
        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);//On prend en charge la requête demandée 

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

            $session = $form->getData();//Recuperation des données du formulaire

            $entityManager->persist($session);//Similaire à pdo->prepare

            $entityManager->flush();//Similaire à pdo->execute

            return $this->redirectToRoute('app_session');//Redirection vers la liste des sessions
        }
        
        return $this->render('session/new.html.twig', [
            'formAddSession' => $form,
            // 'edit'=>$session->getId()
        ]);
    }

    #[Route('/session/{id}', name: 'app_session_show')]
    public function show(Session $session) : Response
    {
        return $this->render('session/show.html.twig',[
            'session' => $session
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete_session(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('app_session');
    }
}
