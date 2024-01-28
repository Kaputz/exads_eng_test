<?php

namespace App\Controller;

use App\Repository\TvSeriesIntervalsRepository;
use App\Repository\TvSeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TvSeriesController extends AbstractController
{
    #[Route('/tv_series', name: 'app_tv_series')]
    public function index(TvSeriesRepository $tvSeriesRepo, TvSeriesIntervalsRepository $tvSeriesIntervalsRepo, Request $request): Response
    {
        $date = new \DateTime('now');
        $title = '';

        $form = $this->createFormBuilder()
            ->add('date', DateTimeType::class)
            ->add('title', TextType::class, ['required' => false])
            ->add('search', SubmitType::class, ['label' => 'Search'])
            ->setMethod('GET')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $date = $formData['date'];
            $title = $formData['title'];
        }

        $tvSeriesIntervals = $tvSeriesIntervalsRepo->getNextTvSeriesInterval($date, $title);
            $tvSeriesInterval = $tvSeriesIntervals->first();

        return $this->render('tv_series/index.html.twig', [
            'search_form' => $form,
            'search_date' => $date,
            'tv_series' => $tvSeriesInterval,
            //not really needed, adds table at bottom with all series just for consulting all shows. can be deleted safely.
            'all_tv_series' => $tvSeriesRepo->findAll(), 
        ]);
    }

    
}
