<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrimeNumbersController extends AbstractController
{
    #[Route('/prime_numbers', name: 'app_prime_numbers')]
    public function index(): Response
    {
        $minValue = 1;
        $maxValue = 100;

        $returnArray = array();

        for ($x = $minValue; $x <= $maxValue; $x++) {
            $arr = array();
            $i = 0;

            for ($y = $minValue; $y <= $maxValue; $y++) {
                if($x%$y == 0){
                    $arr[$i] = $y;
                    $i++;
                }
            }

            $count = count($arr);
            if($count == 2){
                $returnArray[$x] = "PRIME";
            } else {
                $returnArray[$x] = $arr;
            }
        }

        return $this->render('prime_numbers/index.html.twig', [
            'numbers' => $returnArray,
        ]);
    }
}
