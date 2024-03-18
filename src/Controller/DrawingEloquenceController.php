<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\EloquenceContestRepository;

class DrawingEloquenceController extends AbstractController
{
    #[Route('/', name: 'app_drawing_eloquence')]
    public function index(EloquenceContestRepository $eloquenceContestRepository): Response
    {
        $contest = $eloquenceContestRepository->getParticipantsForYear();

        $list_participants_json = array_map(function ($item) {
            return array(
                "id" => $item->getId(), 
                "firstname" => $item->getFirstname(), 
                "lastname" => $item->getLastname(),
                "photo" => $item->getPhoto(),
                "formation" => $item->getFormation(),
            );
        }, $contest["participants"]->toArray());


        return $this->render('drawing_eloquence/index.html.twig', [
            'controller_name' => 'DrawingEloquenceController',
            'current_year' => $contest["year"],
            'list_participants' => $contest["participants"],
            'list_participants_json' => json_encode($list_participants_json),
        ]);
    }
}
