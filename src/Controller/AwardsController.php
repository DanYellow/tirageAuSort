<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Repository\AwardRepository;

class AwardsController extends AbstractController
{
    #[Route(['awards/{year}', '/awards'], name: 'awards', requirements: ['year' => '\d{4}'])]
    public function index(AwardRepository $awardRepository, Request $request): Response
    {
        $year = $request->get('year');

        $list_awards = $awardRepository->getAwardsForYear($year);

        
        // $list_participants_json = array_map(function ($item) {
        //     return array(
        //         "id" => $item->getId(), 
        //         "firstname" => $item->getFirstname(), 
        //         "lastname" => $item->getLastname(),
        //         "photo" => $item->getPhoto(),
        //         "formation" => $item->getFormation(),
        //     );
        // }, $list_awards["participants"]->toArray());

        $final_list_awards = array();

        foreach ($list_awards as $element) {
            $final_list_awards[$element->getCategory()->value][] = $element;
        }

        return $this->render('awards/listing.html.twig', [
            "categories" => $final_list_awards,
        ]);
    }

    #[Route(['awards/{year}/{category}', '/awards'], name: 'awarded', requirements: ['year' => '\d{4}'])]
    public function awarded(AwardRepository $awardRepository, Request $request): Response
    {
        $year = $request->get('year');

        $list_awards = $awardRepository->getAwardsForYear($year);

        
        // $list_participants_json = array_map(function ($item) {
        //     return array(
        //         "id" => $item->getId(), 
        //         "firstname" => $item->getFirstname(), 
        //         "lastname" => $item->getLastname(),
        //         "photo" => $item->getPhoto(),
        //         "formation" => $item->getFormation(),
        //     );
        // }, $list_awards["participants"]->toArray());

        $final_list_awards = array();

        foreach ($list_awards as $element) {
            $final_list_awards[$element->getCategory()->value][] = $element;
        }

        return $this->render('awards/listing.html.twig', [
            "categories" => $final_list_awards,
        ]);
    }
}
