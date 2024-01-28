<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsciiController extends AbstractController
{
    #[Route('/ascii', name: 'app_ascii')]
    public function index(): Response
    {
        $ascii_chr_start = ",";
        $ascii_chr_stop = "|";

        $pos_start = 0;
        $pos_end = 0;

        // make full array of all ascii chrs 
        $bytes =  range (0 , 255);
        $arr = array_map('chr', $bytes);

        // find positions of characters to truncate the array
        for($x = 0; $x <= 255; $x++){
            if($arr[$x] == $ascii_chr_start){
                $pos_start = $x;
                break;
            }
        }

        for($x = 0; $x <= 255; $x++){
            if($arr[$x] == $ascii_chr_stop){
                $pos_end = $x;
                break;
            }
        }

        // truncate and copy
        $arr_len = $pos_end - $pos_start;
        $arr = array_slice($arr, $pos_start, $arr_len);
        $arr2 = $arr;

        // shuffle the array and discard random element
        shuffle($arr);
        unset($arr[array_rand($arr, 1)]);

        /*  ALTERNATIVE 1: we could just do this. but it seems to miss the point of the exercise, so i opted to include this option while also doing it manually below 
        $missing_chrs = array_diff($arr2, $arr);
        $missing_chr = array_values($missing_chrs)[0];
        */

        /* ALTERNATIVE 2 */
        $flag = false;
        $missing_chr = null; 

        foreach ($arr2 as $value2) {
            foreach ($arr as $value) {
                if($value2 == $value){
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $missing_chr = $value2;
                break;
            }
            $flag = false;
        }

        return $this->render('ascii/index.html.twig', [
            'ascii_table' => $arr,
            'missing_chr' => $missing_chr,
        ]);
    }
}
