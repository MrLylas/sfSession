<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_program')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }

    #[Route('/program/{id}', name: 'app_program_show')]
    public function show(Session $session ,Program $program) : Response
    {
        return $this->render('program/show.html.twig',[
            'program' => $program,
            'session' => $session
        ]);
    }
}
