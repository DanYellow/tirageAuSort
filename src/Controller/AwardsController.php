<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

use App\Repository\AwardRepository;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class AwardsController extends AbstractController
{
    #[Route(['prix', 'prix/{year}'], name: 'awards', requirements: ['year' => '\d{4}'])]
    public function index(AwardRepository $awardRepository, Request $request, #[MapQueryParameter] array $routeParams = []): Response
    {
        $year = $request->get('year') ?? (array_key_exists('year', $routeParams) && $routeParams["year"]);
        $file_path = "{$this->getParameter('data_directory')}/main.yml";
        $main_data_file = Yaml::parseFile($file_path);

        // Fix route params from admin
        if ($routeParams) {
            $award = $awardRepository->getAward(
                $year,
                $routeParams['category']["value"],
                $routeParams['slug'],
            );

            $list_awards = $awardRepository->getAwardsForYear($year);
            $final_list_awards = array();
            foreach ($list_awards as $element) {
                $final_list_awards[$element->getCategory()->value][] = $element;
            }

            return $this->render('awards/awarded.html.twig', [
                "award" => $award[0] ?? null,
                'event_name' => $main_data_file["event_name"],
                "categories" => $final_list_awards,
            ]);
        }

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
            'event_name' => $main_data_file["event_name"],
        ]);
    }

    #[Route(['prix/{year}/{category}/{slug}'], name: 'awarded', requirements: ['year' => '\d{4}'])]
    public function awarded(AwardRepository $awardRepository, Request $request): Response
    {
        $year = $request->get('year');
        $file_path = "{$this->getParameter('data_directory')}/main.yml";
        $main_data_file = Yaml::parseFile($file_path);

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
            'event_name' => $main_data_file["event_name"],
            "categories" => $final_list_awards,
        ]);
    }
}
