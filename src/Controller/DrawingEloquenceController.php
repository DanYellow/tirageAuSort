<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

use App\Repository\EloquenceContestRepository;
use App\Service\DefaultValues;

class DrawingEloquenceController extends AbstractController
{
    #[Route(['/', '/{year}'], name: 'homepage', requirements: ['year' => '\d{4}'])]
    public function homepage(EloquenceContestRepository $eloquenceContestRepository, Request $request, ): Response
    {
        $year = $request->get('year');
        $file_path = "{$this->getParameter('data_directory')}/main.yml";
        $main_data_file = Yaml::parseFile($file_path);

        $contest = $eloquenceContestRepository->getParticipantsForYear($year);

        $list_participants_json = array_map(function ($item) {
            $formation = $item->getFormation();
            $subject = $item->getSubject();
            if(!is_null($formation)) {
                $formation = $formation->__toString();
            }

            if(!is_null($subject)) {
                $subject = $subject->__toString();
            }

            return array(
                "id" => $item->getId(), 
                "firstname" => $item->getFirstname(), 
                "lastname" => $item->getLastname(),
                "photo" => $item->getPhoto(),
                "subject" => $subject,
                "formation" => $formation,
            );
        }, $contest["participants"]->toArray());

        return $this->render('drawing_eloquence/index.html.twig', [
            'current_year' => $contest["year"],
            'event_name' => DefaultValues::getEventName($main_data_file),
            'list_participants' => $contest["participants"],
            'list_participants_json' => json_encode($list_participants_json),
        ]);
    }
}
