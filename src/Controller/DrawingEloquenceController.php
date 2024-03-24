<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\EloquenceContestRepository;

class DrawingEloquenceController extends AbstractController
{
    #[Route(['/', '/{year}'], name: 'index', requirements: ['year' => '\d{4}'])]
    public function index(EloquenceContestRepository $eloquenceContestRepository, Request $request, ): Response
    {
        $year = $request->get('year');

        $contest = $eloquenceContestRepository->getParticipantsForYear($year);

        $list_participants_json = array_map(function ($item) {
            $formation = $item->getFormation();
            if(!is_null($formation)) {
                $formation = $formation->__toString();
            }

            return array(
                "id" => $item->getId(), 
                "firstname" => $item->getFirstname(), 
                "lastname" => $item->getLastname(),
                "photo" => $item->getPhoto(),
                "formation" => $formation,
            );
        }, $contest["participants"]->toArray());

        return $this->render('drawing_eloquence/index.html.twig', [
            'current_year' => $contest["year"],
            'list_participants' => $contest["participants"],
            'list_participants_json' => json_encode($list_participants_json),
        ]);
    }
}
