<?php

namespace RP\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RPListBundle:Default:index.html.twig', array('name' => $name));
    }
}
