<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\EloquenceContestRepository;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;




class DrawingEloquenceController extends AbstractController
{
    #[Route('/', name: 'app_drawing_eloquence')]
    public function index(EloquenceContestRepository $eloquenceContestRepository): Response
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                // print($object);
                return "{}";
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $contest = $eloquenceContestRepository->getParticipantsForYear();
        $serializer = new Serializer([$normalizer], [$encoder]);

        $list_participants_json = array_map(function ($item) {
            return array("firstname" => $item->getFirstname(), "lastname" => $item->getLastname());
        }, $contest["participants"]->toArray());
        // var_dump(json_encode($list_participants_json));
        // // var_dump($serializer->serialize($contest["participants"], 'json'));
        // exit;

        return $this->render('drawing_eloquence/index.html.twig', [
            'controller_name' => 'DrawingEloquenceController',
            'current_year' => $contest["year"],
            'list_participants' => $contest["participants"],
            // 'list_participants_json' => $serializer->serialize($contest["participants"], 'json'),
            'list_participants_json' => json_encode($list_participants_json),
        ]);
    }
}
