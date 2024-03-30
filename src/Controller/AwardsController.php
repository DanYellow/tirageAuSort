<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Repository\AwardRepository;

class AwardsController extends AbstractController
{
    #[Route(['prix', 'prix/{year}'], name: 'awards', requirements: ['year' => '\d{4}'])]
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

    #[Route(['prix/{year}/{category}/{slug}'], name: 'awarded', requirements: ['year' => '\d{4}'])]
    public function awarded(AwardRepository $awardRepository, Request $request): Response
    {
        $year = $request->get('year');

        $award = $awardRepository->getAward(
            $year,
            $request->get('category'),
            $request->get('slug'),
        );

        $list_awards = $awardRepository->getAwardsForYear($year);
        $final_list_awards = array();
        foreach ($list_awards as $element) {
            $final_list_awards[$element->getCategory()->value][] = $element;
        }


        return $this->render('awards/awarded.html.twig', [
            "award" => $award[0] ?? null,
            "categories" => $final_list_awards,
        ]);
    }
}
