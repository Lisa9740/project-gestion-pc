<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

       $date = new DateTime();

        return $this->render('home/home.html.twig', [
            'date' => $date->format('d/m/Y')
        ]);
    }

    /**
     * @Route("/date", name="date", methods={"POST", "GET"})
     */
    public function getDate(Request $request): Response
    {

        $dateParam = $request->query->get('date');
        $date = $request->request->get('date');

        if (isset($date)) {
            $date = DateTime::createFromFormat('d/m/Y', $date);
        }

        if (isset($dateParam)) {
            $date = DateTime::createFromFormat('d/m/Y', $dateParam);
        }


        return $this->render('home/date.html.twig', [
            'date' => $date
        ]);
    }
}

