<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RP\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use RP\UserBundle\Entity\Actualite;
use RP\UserBundle\Entity\User;
use RP\CoreBundle\Entity\Anime;
use RP\CoreBundle\Entity\Serie;
use RP\UserBundle\Entity\Friend;
use RP\UserBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
/**use RP\CoreBundle\Entity\Film;
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{

  /**
   * Show a user
   * @return [view] [description]
   */
  public function showAction()
  {
      $user = $this->getUser();
        $repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('RPUserBundle:Actualite')
		  ;

		  $em = $this->getDoctrine()->getManager();
		  // On récupère la liste des candidatures de cette annonce
		  $listActualite = $em
		    ->getRepository('RPUserBundle:Actualite')
		    ->findBy(array(), array('id' => 'desc'),10,0)
		  ;
    
      $listDemandes = $em
        ->getRepository('RPUserBundle:Friend')
        ->findByTarget($user,array('id' => 'desc')) 
      ; 

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

      $myRequests = $em
        ->getRepository('RPUserBundle:Friend')
        ->findBy(array('target'=>$user,'statut'=>'waiting')) 
      ;
    


      $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();
      
      $categories = $category->getResult();
    
      /*if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
        }*/
 
      return $this->render('RPUserBundle:Profile:show.html.twig', array(
        'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'listDemandes' => $listDemandes,'myRequests'=>$myRequests
      ));
  }
 
  public function loadAction()
  {
      $user = $this->getUser();
        $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('RPUserBundle:Actualite')
      ;

      $em = $this->getDoctrine()->getManager();
      // On récupère la liste des candidatures de cette annonce
      $listActualite = $em
        ->getRepository('RPUserBundle:Actualite')
        ->findBy(array(), array('id' => 'desc'),10,0)
      ;
    
      $listDemandes = $em
        ->getRepository('RPUserBundle:Friend')
        ->findByTarget($user,array('id' => 'desc')) 
      ; 

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
    
      /*if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
        }*/

      return $this->render('FOSUserBundle:Load:content.html.twig', array(
        'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'listDemandes' => $listDemandes
      ));
  }

  public function loadfromAction(Request $request)
  {
      $user = $this->getDoctrine()
        ->getRepository('RPUserBundle:User')
        ->find($request->get('id'));


        $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('RPUserBundle:Actualite')
      ;

      $em = $this->getDoctrine()->getManager();
      // On récupère la liste des candidatures de cette annonce
      $listActualite = $em
        ->getRepository('RPUserBundle:Actualite')
        >findBy(array(), array('id' => 'desc'),10,0) 
      ;
    
      $listDemandes = $em
        ->getRepository('RPUserBundle:Friend')
        ->findByTarget($user,array('id' => 'desc')) 
      ; 

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
    
      /*if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
        }*/

      return $this->render('FOSUserBundle:Load:content.html.twig', array(
        'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'listDemandes' => $listDemandes
      ));
  }
  /**
   * Load more actu
   * @return [view] [description]
   */
  
  public function moreAction(Request $request)
  {
      $user = $this->getUser();
      
        $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('RPUserBundle:Actualite')
      ;

      $em = $this->getDoctrine()->getManager();
      // On récupère la liste des candidatures de cette annonce
      $listActualite = $em
        ->getRepository('RPUserBundle:Actualite')
        ->findBy(array(), array('id' => 'desc'))
      ;
    
      $listDemandes = $em
        ->getRepository('RPUserBundle:Friend')
        ->findByTarget($user,array('id' => 'desc')) 
      ; 

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
    
      /*if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
        }*/

      return $this->render('FOSUserBundle:Profile:more.html.twig', array(
        'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'listDemandes' => $listDemandes
      ));
  } 
  /**
   * Load a user notifications
   * @return [type] [description]
   */
  public function notificationsAction(){
      $user = $this->getUser();
      $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('RPUserBundle:Actualite')
      ;

      $em = $this->getDoctrine()->getManager();
      // On récupère la liste des candidatures de cette annonce
      $listActualite = $em
        ->getRepository('RPUserBundle:Actualite')
        ->findByUser($user,array('id' => 'desc')) 
      ;
    

      $listDemandes = $em
        ->getRepository('RPUserBundle:Friend')
        ->findByTarget($user,array('id' => 'desc')) 
      ;
      
      $repository = $this
        ->getDoctrine()
        ->getManager() 
        ->getRepository('RPCoreBundle:Serie')
      ; 

      $listSeries = $repository->findBy(
        array(), 
        array(),        
        10,                             
        0                               
      );

      $category = $repository->createQueryBuilder('serie')
        ->select('serie.type')
        ->distinct()
        ->getQuery();

      $categories = $category->getResult();
        
        /*if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }*/

        return $this->render('FOSUserBundle:Profile:notifications.html.twig', array(
            'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'myRequests' => $listDemandes
        ));
  }
  /**
   * Get a user profile
   * @param  User   $user [description]
   * @return [view]       [description]
   */
  public function getAction(User $user)
  {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('RPUserBundle:Actualite')
        ;

        $em = $this->getDoctrine()->getManager();
        // On récupère la liste des candidatures de cette annonce

        $listActualite = $em
          ->getRepository('RPUserBundle:Actualite')
          ->findBy(array(), array('id' => 'desc'),10,0)
        ;
        
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
        

        $session_user = $this->get('security.context')->getToken()->getUser();
        $amitie = $em
          ->getRepository('RPUserBundle:Friend') 
          ->findBy(
             array('holder'=>$session_user,'target'=>$user)
            )     
        ; 

        if(sizeof($amitie) < 1){
            $amitie = $em
              ->getRepository('RPUserBundle:Friend') 
              ->findBy(
                 array('holder'=>$user,'target'=>$session_user) 
                )      
            ; 
        }
        /*if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }*/
        $session = $this->get('security.context')->getToken()->getUser();
        return $this->render('FOSUserBundle:Profile:get.html.twig', array(
            'user' => $user,'listActualite' => $listActualite,'listSeries' => $listSeries,'types' => $categories,'session' => $session,'amities'=>$amitie
        ));
  }
  /**
   * Edit a user
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function editAction(Request $request)
  {
    $user = $this->getUser();
    if (!is_object($user) || !$user instanceof UserInterface) {
        throw new AccessDeniedException('This user does not have access to this section.');
    }

    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');
    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

    if (null !== $event->getResponse()) {
        return $event->getResponse();
    }

    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    $formFactory = $this->get('fos_user.profile.form.factory');

    $form = $formFactory->createForm();
    $form->setData($user);
    $form->handleRequest($request);

    if ($form->isValid()) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_profile_show');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
        return $response;
    }

    return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
        'user' =>$user,'form' => $form->createView()
    ));
  }
  /**
   * Add a new friendship
   * @param Request $request [description]
   */
  public function addAction(Request $request)
  { 
    $em = $this->getDoctrine()->getManager();
    $id_target = $request->get('id');
    $rep = 0;
 
    $id = $this->get('session');
    $id = $id->getId(); 
    $holder = $this->get('security.context')->getToken()->getUser();
    $target = $em->getRepository('RPUserBundle:User')->findOneBy(array('id' => $id_target));

    $friendship = new Friend();
    $friendship->setStatut("waiting");
    $friendship->setDate(new \DateTime("now"));  
    $friendship->setHolder($holder);
    $friendship->setTarget($target);      
  
    $em->persist($friendship);
    $em->flush();  
    return new Response($rep);
  }
  /**
   * accept a new friendship
   * @param  Request $request [description]
   * @return [Response]           [description]
   */ 
  public function acceptAction(Request $request){
    $retour = 0;
    $em = $this->getDoctrine()->getManager();
    $id_holder = $request->get('ask');
    $friend = $em->getRepository('RPUserBundle:Friend')->find($id_holder);
    $friend->setStatut('ami');
    $em->persist($friend);
    $em->flush();
    return new Response($retour);
  }
  /**
   * refuse a new friendship
   * @param  Request $request [description]
   * @return [Response]           [description]
   */
  public function refuseAction(Request $request){
    $retour = 0;
    $em = $this->getDoctrine()->getManager();
    $id_holder = $request->get('ask');
    $friend = $em->getRepository('RPUserBundle:Friend')->find($id_holder);
    $em->remove($friend);
    $em->flush();
    return new Response($retour);
  }
  /**
   * Post a message on your own wall
   * @param  Request $request [description]
   * @return [Response]           [description]
   */
  public function expressAction(Request $request){
    if ($request->isXmlHttpRequest())
    {
      $em = $this->getDoctrine()->getManager(); 

      //Post de l'actualité
      $post = $request->get('post');
      $user = $this->get('security.context')->getToken()->getUser();
      $actualite = new Actualite();
      $actualite->setType('Statut');
      $actualite->setTitre('Statut');
      $actualite->setUser($user);
      $actualite->setTarget($user);
      $actualite->setContenu($post);
      $em->persist($actualite); 
     
      
      //Post aux amis
      $my_friends = $em->getRepository('RPUserBundle:Friend')->findBy(array('holder'=>$user));
      foreach($my_friends as $friend){
        $cible = $friend->getTarget();
        $actualite = new Actualite();
        $actualite->setType('Statut');
        $actualite->setTitre('Statut');
        $actualite->setUser($user);
        $actualite->setTarget($cible); 
        $actualite->setContenu($post); 
        $em->persist($actualite); 
      } 

      $em->flush();    
      var_dump($my_friends);
      return new Response($post);
    }
  }
  /**
   * Post a message on a friend's wall
   * @param  Request $request [description]
   * @return [Response]           [description]
   */
  public function expresstoAction(Request $request){
    $em = $this->getDoctrine()->getManager(); 
    $post = $request->get('post');
    $id_target = $request->get('target');
    $target = $em->getRepository('RPUserBundle:User')->findOneBy(array('id' => $id_target));
    $me = $this->get('security.context')->getToken()->getUser();
    $actualite = new Actualite();
    $actualite->setType('message');  
    $actualite->setTitre('Message');
    $actualite->setUser($me); 
    $actualite->setTarget($target);
    $actualite->setContenu($post);
    $em->persist($actualite);    
    $em->flush();    
    return new Response($post);
  }
  /**
   * Get your friend list 
   * @param  Request $request [description]
   * @return [View]           [description]
   */
  public function friendsAction(Request $request){
    $retour = 0;
    $em = $this->getDoctrine()->getManager(); 
    $user = $this->get('security.context')->getToken()->getUser();

    $list_friendship_hold = $em
      ->getRepository('RPUserBundle:Friend') 
      ->findBy(
        array('holder'=>$user)
    );
       
    $list_friendship_target = $em
      ->getRepository('RPUserBundle:Friend') 
      ->findBy(
        array('target'=>$user)
    );
        
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


    $myRequests = $em
      ->getRepository('RPUserBundle:Friend')
      ->findBy(array('target'=>$user,'statut'=>'waiting')) 
    ;
    


    $category = $repository->createQueryBuilder('serie')
      ->select('serie.type')
      ->distinct()
      ->getQuery();

    $categories = $category->getResult();

    return $this->render('RPUserBundle:Profile:friends.html.twig', array(
      'user'           => $user,
      'listFriendshipHold' => $list_friendship_hold,
      'listFriendshipTarget' => $list_friendship_target,
      'listSeries' => $listSeries,
      'types' => $categories,
      'myRequests'=>$myRequests,
    ));
  }

  public function deleteAction(Request $request){
    $em = $this->getDoctrine()->getManager(); 
    $id = $request->get('id'); 
    $suivi_serie = $em->getRepository('RPUserBundle:Actualite')->find($id);
    $em->remove($suivi_serie);      
    $em->flush();     
    return new Response(0);
  }
  public function commentAction(Request $request){
    $em = $this->getDoctrine()->getManager(); 
    $user = $this->get('security.context')->getToken()->getUser();   
    $comment = new Comment();
    $id = $request->get('id');
    $actualite = $em->getRepository('RPUserBundle:Actualite')->find($id);
    $content = $request->get('comment');
    $comment->setUser($user);  
    $comment->setActualite($actualite);
    $comment->setContent($content); 
    $em->persist($comment); 
    $em->flush();  
    return new Response(0);
  }   
  public function loadCommentAction(Request $request){
     $em = $this->getDoctrine()->getManager(); 
     $id = $request->get('id');
     $actualite = $em->getRepository('RPUserBundle:Actualite')->find($id);
     $listComments = $em
      ->getRepository('RPUserBundle:Comment')
      ->findByActualite($actualite,array('id' => 'desc')) 
     ;   
    return $this->render('RPUserBundle:Profile:comments.html.twig', array(
      'listComments' => $listComments,
    ));
  }
  public function addFriendAction(Request $request){
     $em = $this->getDoctrine()->getManager(); 
     $username = $request->get('user');
     $user = $this->get('security.context')->getToken()->getUser();   
     $useradd = $em
        ->getRepository('RPUserBundle:User') 
        ->findByUsername($username) 
     ;  
     $useradd = $useradd[0];
     $rep = 0;
      
     $exist_hold = $em->getRepository('RPUserBundle:Friend')->findOneBy(array('holder' => $user, 'target' => $useradd));
     $exist_target = $em->getRepository('RPUserBundle:Friend')->findOneBy(array('target' => $user, 'holder' => $useradd));
     if(isset($exist_hold) || isset($exist_target)){
      $rep = 3;
     }else{
       if($user !== $useradd){
         $rep = 1;
         $friendship = new Friend();
         $friendship->setStatut("waiting");
         $friendship->setDate(new \DateTime("now"));  
         $friendship->setHolder($user);
         $friendship->setTarget($useradd); 
         $em->persist($friendship);
         $em->flush();      
       }else{
        $rep = 0;
       }     
     } 

  
     return new Response($rep);
  }
}
 