<?php

namespace RP\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use RP\CoreBundle\Entity\Anime;
use RP\CoreBundle\Entity\Serie;
use RP\CoreBundle\Entity\Film;
use RP\CoreBundle\Entity\FollowAnime;
use RP\CoreBundle\Entity\FollowFilm;
use RP\CoreBundle\Entity\FollowSerie;
use RP\ArticleBundle\Entity\Article;
 
class CoreController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Anime')
        ;



        $listAnimes = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          3,                              // Limite
          0                               // Offset
        );


        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Serie')
        ;


        $listSeries = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          3,                              // Limite
          0                               // Offset
        );


        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPArticleBundle:Article')
        ;


        $listArticles = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          3,                              // Limite
          0                               // Offset
        );




        return $this->render('RPCoreBundle:Core:index.html.twig', array('listAnimes' => $listAnimes, 'listSeries' => $listSeries,'listArticles' => $listArticles));
    }

}
