<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CourseController extends AbstractController
{
    #[Route('/course', name: 'app_course')]
    public function index(CourseRepository $coursesRepository): Response
    {
        $courses = $coursesRepository->findAll();
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/course/{id}', name: 'app_course_show')]
    public function show(Course $course, Program $programs ) : Response
    {
        return $this->render('course/show.html.twig',[
            'course' => $course,
            'programs' => $programs
        ]);
    }
}
