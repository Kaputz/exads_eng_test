<?php

namespace App\Controller;

use Exads\ABTestData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestingController extends AbstractController
{
    #[Route('/testing', name: 'app_testing')]
    public function index(): Response
    {
        $promoId = 3;
        $designs = $this->getData($promoId);
        $designId = $this->chooseDesign($designs);
        return $this->redirectToRoute('app_testing_show', ['promoId' => $promoId,'designId' => $designId]);
    }

    #[Route('/testing/{promoId}/{designId}', name: 'app_testing_show')]
    public function show(int $promoId, int $designId): Response
    {
        $abTest = new ABTestData($promoId);
        $promotionName = $abTest->getPromotionName();
        $design = $abTest->getDesign($designId);

        return $this->render('testing/show.html.twig', [
            'promotion_name' => $promotionName,
            'design' => $design,
        ]);
    }

    /**
     * @return array Returns all designs from a promotion
     */
    public function getData(int $promoId): array{
        $abTest = new ABTestData($promoId);
        $designs = $abTest->getAllDesigns();

        return array_map(function ($item) {
            return $item;
        }, $designs);
    }

    /**
     * @return int Returns a design ID
     */
    public function chooseDesign($designs): int{
        $randomNumber = mt_rand(1, 100);
        $cumulativeSplit = 0;

        foreach ($designs as $design) {
            $cumulativeSplit += $design['splitPercent'];

            if ($randomNumber <= $cumulativeSplit) {
                return $design['designId'];
            }
        }

        //default to the first design if no match is found (fallback)
        return $designs[0]['designId'];
    }
}
