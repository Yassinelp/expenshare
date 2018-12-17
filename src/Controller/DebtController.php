<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DebtController extends AbstractController
{
    /**
     * @Route("/debt", name="debt")
     */
    public function index()
    {
        return $this->render('debt/index.html.twig', [
            'controller_name' => 'DebtController',
        ]);
    }
}
