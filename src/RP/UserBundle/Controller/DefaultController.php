<?php

namespace RP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RPUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
