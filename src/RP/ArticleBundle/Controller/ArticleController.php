<?php

namespace RP\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RP\ArticleBundlel\Entity\Article;
use RP\CoreBundle\Entity\Anime;
use RP\CoreBundle\Entity\Serie;
use RP\CoreBundle\Entity\Film;
use RP\CoreBundle\Entity\FollowAnime;
use RP\CoreBundle\Entity\FollowFilm;
use RP\CoreBundle\Entity\FollowSerie;


class ArticleController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RPArticleBundle:Default:index.html.twig', array('name' => $name));
    }
    
    /**
     * Animes part
     */

    /**
     *  Return the view animes.html.twig
     *  To the request /animes
     * @return [View]
     */
    public function animesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $moyenne = 0;

        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Anime')
        ;
        $category = $repository->createQueryBuilder('anime')
        ->select('anime.type')
        ->distinct()
        ->getQuery();

        $categories = $category->getResult();

        $listAnimes = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );

        foreach($listAnimes as $anime){  
          $listFollowAnime = $em
            ->getRepository('RPCoreBundle:FollowAnime')
            ->findBy(array('anime' => $anime),array('id' => 'ASC'))
          ;
          if(sizeof($listFollowAnime) > 0){
            foreach($listFollowAnime as $follow){
              $moyenne += $follow->getNote();
            } 
            $moyenne = $moyenne / sizeof($listFollowAnime);
            $notes[] = $moyenne;
            $moyenne = 0;
          }else{
            $notes[] = null;
          }
        }
        return $this->render('RPArticleBundle:Articles:animes.html.twig', array('listAnimes' => $listAnimes, 'types' => $categories,'notes'=>$notes));
    }  
    /**
     * @param  Anime
     *
     * Return the view show_anime.html.twig
     * To the request /anime/{id}
     * 
     * @return [View]
     */
    public function showanimeAction(Anime $anime)
    {
      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Serie')
      ; 
      $listSeries = $repository->findBy(
        array(), // Critere
        array(),        // Tri
        10,                              // Limite
        0                               // Offset
      );
      $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();

      $categories = $category->getResult();
      return $this->render('RPArticleBundle:Articles:show_anime.html.twig', array('anime'=>$anime,'listSeries' => $listSeries,'types' => $categories));
    }
    /**
     * Return the view topanime
     * To the request /topanimes
     * @return [View]
     */
    public function topanimesAction()
    {
        $moyenne = 0;
        $notes = array(); 
        $em = $this->getDoctrine()->getManager();
        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Anime') 
        ; 

        $listAnimes = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );

        $category = $repository->createQueryBuilder('anime')
        ->select('anime.type')
        ->distinct()
        ->getQuery();

        $categories = $category->getResult();

        foreach($listAnimes as $anime){  
          $listFollowAnime = $em
            ->getRepository('RPCoreBundle:FollowAnime')
            ->findBy(array('anime' => $anime),array('id' => 'ASC'))
          ;
          if(sizeof($listFollowAnime) > 0){
            foreach($listFollowAnime as $follow){
              $moyenne += $follow->getNote();
            } 
            $moyenne = $moyenne / sizeof($listFollowAnime);
            $notes[] = $moyenne;
            $moyenne = 0;
          }else{
            $notes[] = null;
          }
        }

        return $this->render('RPArticleBundle:Articles:topanimes.html.twig', array('listAnimes' => $listAnimes,'types' => $categories,'notes'=>$notes));
    }

    /**
     * Series part
     */
    
    /**
     * Return the view series.html.twig
     * To the request /series
     * @return [View]
     */
    public function seriesAction()
    {
      $moyenne = 0;
      $notes = array(); 
      $em = $this->getDoctrine()->getManager();
      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Serie')
      ; 
      $listSeries = $repository->findBy(
        array(), // Critere
        array(),        // Tri
        10,                              // Limite
        0                               // Offset
      );
      $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();

      $categories = $category->getResult();
        foreach($listSeries as $serie){
            $listFollowSerie = $em
              ->getRepository('RPCoreBundle:FollowSerie')
              ->findBy(array('serie' => $serie),array('id' => 'ASC'))
            ;
            if(sizeof($listFollowSerie) > 0){
              foreach($listFollowSerie as $follow){
                $moyenne += $follow->getNote();
              }
              $moyenne = $moyenne / sizeof($listFollowSerie);
              $notes[] = $moyenne;
              $moyenne = 0;
            }else{
              $notes[] = null;
            }
        }
        return $this->render('RPArticleBundle:Articles:series.html.twig', array('listSeries' => $listSeries,'types' => $categories,'notes'=>$notes));
    }
    /**
     * @param  Serie
     *
     * Return the view show_serie.html.twig
     * To the request /serie/{id}
     * 
     * @return [View]
     */
    public function showserieAction(Serie $serie)
    {
      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Film')
      ; 
      $listFilms = $repository->findBy(
        array(), // Critere
        array(),        // Tri
        10,                              // Limite
        0                               // Offset
      );
      $category = $repository->createQueryBuilder('film')
      ->select('film.type')
      ->distinct()
      ->getQuery();

      $categories = $category->getResult();

      return $this->render('RPArticleBundle:Articles:show_serie.html.twig', array('serie'=>$serie,'listFilms' => $listFilms,'types' => $categories));
    }
    /**
     * Return the view topserie.html.twig
     * To the request /topseries
     * @return [View]
     */
    public function topseriesAction()
    {
        $moyenne = 0;
        $notes = array(); 
        $em = $this->getDoctrine()->getManager();
        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Serie')
        ; 

        $listSeries = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );


        $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();

        $categories = $category->getResult();

          foreach($listSeries as $serie){
            $listFollowSerie = $em
                ->getRepository('RPCoreBundle:FollowSerie')
                ->findBy(array('serie' => $serie),array('id' => 'ASC'))
            ;
            if(sizeof($listFollowSerie) > 0){
              foreach($listFollowSerie as $follow){
                $moyenne += $follow->getNote();
              }
              $moyenne = $moyenne / sizeof($listFollowSerie);
              $notes[] = $moyenne;
              $moyenne = 0;
            }else{
              $notes[] = null;
            }
         

        }

        return $this->render('RPArticleBundle:Articles:topseries.html.twig', array('listSeries' => $listSeries,'types' => $categories,'notes'=>$notes));
    }
    /**
     * Return the view film.html.twig
     * To the request /film
     * 
     * @return [View]
     */
    public function filmsAction()
    {
      $moyenne = 0;
      $notes = array(); 
      $em = $this->getDoctrine()->getManager();

      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Film')
      ; 

      $listFilms = $repository->findBy(
        array(), // Critere
        array(),        // Tri
        10,                              // Limite
        0                               // Offset
      );
      foreach($listFilms as $film){  
        $listFollowFilm = $em
          ->getRepository('RPCoreBundle:FollowFilm')
          ->findBy(array('film' => $film),array('id' => 'ASC'))
        ;
        if(sizeof($listFollowFilm) > 0){
          foreach($listFollowFilm as $follow){
            $moyenne += $follow->getNote();
          }  
          $moyenne = $moyenne / sizeof($listFollowFilm);
          $notes[] = $moyenne;
          $moyenne = 0;
        }else{
           $notes[] = null;
        }
      }
        
      $category = $repository->createQueryBuilder('film')
       ->select('film.type')
       ->distinct()
       ->getQuery();

      $categories = $category->getResult();

      return $this->render('RPArticleBundle:Articles:films.html.twig', array('listFilms' => $listFilms,'types' => $categories,'notes'=>$notes));
    }
    /**
     * Return show_film.html.twig
     * To the request /film/{id}
     * @param  Film
     * @return [View]
     */
    public function showfilmAction(Film $film)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Serie')
        ; 
        $listSeries = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );
        $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();

        $categories = $category->getResult();

        return $this->render('RPArticleBundle:Articles:show_film.html.twig', array('film'=>$film,'listSeries' => $listSeries,'types' => $categories));
    }
    /**
     * Return the view topfilm.html.twig 
     * To the request /topfilms
     * @return [View]
     */
    public function topfilmsAction()
    { 
      $moyenne = 0;
      $notes = array(); 
      $em = $this->getDoctrine()->getManager();
      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Film') 
      ; 

      $listFilms = $repository->findBy(
        array(), // Critere
        array(),        // Tri
        10,                              // Limite
        0                               // Offset
      );


      $category = $repository->createQueryBuilder('film')
       ->select('film.type')
       ->distinct()
       ->getQuery();

      $categories = $category->getResult();

      foreach($listFilms as $film){  
        $listFollowFilm = $em
          ->getRepository('RPCoreBundle:FollowFilm')
          ->findBy(array('film' => $film),array('id' => 'ASC'))
        ;
        if(sizeof($listFollowFilm) > 0){
          foreach($listFollowFilm as $follow){
            $moyenne += $follow->getNote();
          }  
          $moyenne = $moyenne / sizeof($listFollowFilm);
          $notes[] = $moyenne;
          $moyenne = 0;
        }else{
           $notes[] = null;
        }
      }

      return $this->render('RPArticleBundle:Articles:topfilms.html.twig', array('listFilms' => $listFilms,'types' => $categories,'notes'=>$notes));
    }
    /**
     * Return the view article.html.twig
     * To the request /article/{id}
     * @param  [cible:serie/anime/film]
     * @param  [int id]
     * @return [type]
     */
    public function articleAction($cible,$id)
    {
      $em = $this->getDoctrine()->getManager();

      $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Film')
        ; 

      $repCible = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:'.ucfirst($cible))
        ; 

      $listFilms = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
      );

      $category = $repository->createQueryBuilder('film')
        ->select('film.type')
        ->distinct()
        ->getQuery();

      $categories = $category->getResult();
      
      $obj = $em
        ->getRepository('RPCoreBundle:'.ucfirst($cible))
        ->find($id)
      ;
      
      if($cible == "serie"){
        $article = $em
         ->getRepository('RPArticleBundle:Article')
         ->findBy(array("serie" => $obj));
        ;
      }else if($cible == "anime"){
        $article = $em
          ->getRepository('RPArticleBundle:Article')
          ->findBy(array("anime" => $obj));
        ;      
      }else if($cible == "film"){
        $article = $em
          ->getRepository('RPArticleBundle:Film')
          ->findBy(array("film" => $obj));
        ;     
      }
      return $this->render('RPArticleBundle:Articles:articles.html.twig', array('listFilms' => $listFilms,'types' => $categories,'article' => $article[0]));
    }

    public function typeAction($cible)
    {
      $em = $this->getDoctrine()->getManager();

      $repository = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:Film')
        ; 
 
      $repCible = $this
          ->getDoctrine()
          ->getManager() 
          ->getRepository('RPCoreBundle:'.ucfirst($cible))
        ; 

      $listFilms = $repository->findBy(
          array(), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
      );

      $category = $repository->createQueryBuilder('film')
        ->select('film.type')
        ->distinct()
        ->getQuery();

   
      $categories = $category->getResult();

      return $this->render('RPArticleBundle:Articles:types.html.twig', array('listFilms' => $listFilms,'types' => $categories));
    }
}
   