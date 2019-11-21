<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function test()
    {
        $data = array(
            'date' => date('d.m.Y')
        );
     return $this->render('pages/index.html.twig', $data);
    }
}