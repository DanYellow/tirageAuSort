<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\EloquenceContestParticipantRepository;

class DrawingEloquenceController extends AbstractController
{
    #[Route('/', name: 'app_drawing_eloquence')]
    public function index(EloquenceContestParticipantRepository $eloquenceContestParticipantRepository): Response
    {
        $listProjects = $eloquenceContestParticipantRepository
            ->getParticipantsForYear();
        dump($listProjects);
        return $this->render('drawing_eloquence/index.html.twig', [
            'controller_name' => 'DrawingEloquenceController',
            'current_year' => date("Y"),
            'list_participants' => $listProjects
        ]);
    }
}
