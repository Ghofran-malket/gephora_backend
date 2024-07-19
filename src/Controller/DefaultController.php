<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function home() : Response
    {
        $number = rand(0, 100);
	    return $this->render('notre-selection.html.twig', [
    	  	'number' => $number,
	    ]);
       
    }
}
