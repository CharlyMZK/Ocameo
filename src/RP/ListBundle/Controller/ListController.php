<?php

namespace RP\ListBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RP\CoreBundle\Entity\Anime;
use RP\CoreBundle\Entity\Serie;
use RP\CoreBundle\Entity\Film;
use RP\CoreBundle\Entity\FollowAnime;
use RP\CoreBundle\Entity\FollowSerie;
use RP\CoreBundle\Entity\FollowFilm;
use RP\UserBundle\Entity\Actualite;
use RP\UserBundle\Entity\User;
use RP\UserBundle\Entity\Friend;
class ListController extends Controller
{
    /**
     * Index
     * @return [type] [description]
     */
    public function indexAction()
    { 
    	$em = $this->getDoctrine()->getManager();

        // On recupère l'utilisateur
        $user = $this->get('security.context')->getToken()->getUser();
        
        // On récupère maintenant la liste des AdvertSkill
    	$listFollowSerie = $em
      		->getRepository('RPCoreBundle:FollowSerie')
      		->findBy(array('user' => $user),array('id' => 'ASC'))
    	;

    	$listFollowAnime = $em
      		->getRepository('RPCoreBundle:FollowAnime')
      		->findBy(array('user' => $user),array('id' => 'ASC'))
    	;
  
    	$listFollowFilm = $em
      		->getRepository('RPCoreBundle:FollowFilm')
      		->findBy(array('user' => $user),array('id' => 'ASC'))
    	;

	    return $this->render('RPListBundle:List:list.html.twig', array(
	      'user'           => $user,
	      'listFollowSerie' => $listFollowSerie,
	      'listFollowAnime' => $listFollowAnime,
	      'listFollowFilm' => $listFollowFilm
	    ));
    }
    /**
     * Change season from a followed serie or anime
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function modifSaisonAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();

        $cible = $request->get('cible');
        $id_suivi = $request->get('id_suivi');
        $retour = 0;
        
        if($cible == "serie"){

          $suivi_serie = $em->getRepository('RPCoreBundle:FollowSerie')->find($id_suivi);
          $suivi_serie->setSaison($request->get('saison'));
          $em->persist($suivi_serie);  
          $retour = $suivi_serie->getSaison();          

        }else if($cible == "anime"){

          $suivi_anime = $em->getRepository('RPCoreBundle:FollowAnime')->find($id_suivi);
          $suivi_anime->setSaison($request->get('saison'));
          $em->persist($suivi_anime);  
          $retour = $suivi_anime->getSaison();          

        }
        $em->flush(); 
        return new Response($retour);
    }
    /**
     * Change episode from a followed serie or anime
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function modifEpisodeAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();

        $mouvement = $request->get('mouvement');
        $id_suivi = $request->get('id_suivi');
        $cible = $request->get('cible');
        $retour = 0;

        if($cible == "serie"){

          $suivi_serie = $em->getRepository('RPCoreBundle:FollowSerie')->find($id_suivi);
          $suivi_serie->setEpisode($request->get('episode'));
          $em->persist($suivi_serie);    
          $retour = $suivi_serie->getEpisode();          

        }else if($cible == "anime"){
          $suivi_anime = $em->getRepository('RPCoreBundle:FollowAnime')->find($id_suivi);
          $suivi_anime->setEpisode($request->get('episode'));
          $em->persist($suivi_anime);    
          $retour = $suivi_anime->getEpisode();  
        } 
                
        $em->flush(); 

        return new Response($retour);
    }
    /**
     * Change if a film is seen or not
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function changeAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();

        $id_suivi = $request->get('id_suivi');
        $retour = 0;
 
        $suivi_film = $em->getRepository('RPCoreBundle:FollowFilm')->find($id_suivi);
        $seen = $suivi_film->getSeen();
        if($seen == 1){
          $suivi_film->setSeen(0);   
        }else{
          $suivi_film->setSeen(1);
        }

        $retour = $suivi_film->getSeen();
        $em->persist($suivi_film); 
                
        $em->flush();  

        return new Response($retour);
    }
    /**
     * Return a form from a request to /maliste/form
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function formAction(Request $request)
    { 
      $em = $this->getDoctrine()->getManager();
      $cible = $request->get('cible');
      $user = $this->container->get('security.context')->getToken()->getUser();
      if($cible == "serie"){
        $tab = $em->getRepository('RPCoreBundle:Serie')->findAll();  
        $list = $em
          ->getRepository('RPCoreBundle:FollowSerie')
          ->findByUser($user)
        ;

      }else if($cible == "anime") {
        $tab = $em->getRepository('RPCoreBundle:Anime')->findAll();  
        $list = $em 
          ->getRepository('RPCoreBundle:FollowAnime')
          ->findByUser($user)
        ;
      }else if($cible == "film") {
        $tab = $em->getRepository('RPCoreBundle:Film')->findAll();  
        $list = $em 
          ->getRepository('RPCoreBundle:FollowFilm')
          ->findByUser($user)
        ;
      }
      

      if($cible == "anime" || $cible == "serie"){
              $form = '
                <form class="form-horizontal">
                  <fieldset>
                   <!-- Form Name -->
                   <center><legend>Nouvelle <label id="cible">'.$cible.'</label> !</legend></center>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Nom</label>  
                      <div class="col-md-4">
                        <select id="nom" name="selectbasic" class="form-control">';
                        
                        foreach($tab as $t){
                          $ok = true;
                          foreach($list as $item){
                            if($cible == "serie"){
                              if($t->getName() == $item->getSerie()->getName()){
                                $ok = false;
                              }
                            }else{
                              if($t->getName() == $item->getAnime()->getName()){
                                $ok = false;
                              }
                            }                          
                          }
                          if($ok){
                             $form .= "<option>".$t->getName()."</option>";             
                          }       
                        }

                        $form.='</select>
                      </div>
                     </div>

                      <!-- Select Basic -->
                      <div class="form-group">
                        <label class="col-md-4 control-label" for="selectbasic">Saison</label>
                        <div class="col-md-4">
                          <select id="saison" name="selectbasic" class="form-control">
                          ';

                          for($i = 0;$i<=1000;$i++){
                            $form .= "<option>".$i."</option>"; 
                          } 
                         
                         $form .= '
                          </select>
                        </div>
                      </div>

                      <!-- Select Basic -->
                      <div class="form-group">
                        <label class="col-md-4 control-label" for="selectbasic">Episode</label>
                        <div class="col-md-4">
                          <select id="episode" name="selectbasic" class="form-control">
                          ';
                            for($i = 0;$i<=1000;$i++){
                              $form .= "<option>".$i."</option>"; 
                            }
          
                          $form .= '
                          </select>
                        </div>
                      </div>
                    </fieldset>
                  </form>
              ';      
      }

      if($cible == "film" ){
              $form = '
                <form class="form-horizontal">
                  <fieldset>
                   <!-- Form Name -->
                   <center><legend>Nouveau <label id="cible">'.$cible.'</label> !</legend></center>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="textinput">Nom</label>  
                      <div class="col-md-4">
                        <select id="nom" name="selectbasic" class="form-control">';
                        
                        foreach($tab as $t){
                          $ok = true;
                          foreach($list as $item){
                              if($t->getName() == $item->getFilm()->getName()){
                                $ok = false;
                              }                          
                          }
                          if($ok){ 
                             $form .= "<option>".$t->getName()."</option>";             
                          }       
                        }

                        $form.='</select>
                      </div>
                     </div>
                      <div class="form-group">
                      <label for="happy" class="col-sm-4 col-md-4 control-label text-right">Déjà vu ?</label>
                      <div class="col-sm-7 col-md-7">
                        <div class="input-group">
                          <div id="radioBtn" class="btn-group">
                            <a class="btn btn-primary btn-sm active" data-toggle="happy" id="Y" data-title="Y">Oui</a>
                            <a class="btn btn-primary btn-sm notActive" data-toggle="happy" id="N" data-title="N">Non</a>
                          </div>
                          <input type="hidden" name="seen" id="seen">
                        </div>
                      </div>
                    </div>

                    </fieldset>
                  </form>
                  <script>
                    $(\'#radioBtn a\').on(\'click\', function(){
                        var sel = $(this).data(\'title\');
                        var tog = $(this).data(\'toggle\');
                        $(\'#\'+tog).prop(\'value\', sel);
                        
                        $(\'a[data-toggle="\'+tog+\'"]\').not(\'[data-title="\'+sel+\'"]\').removeClass(\'active\').addClass(\'notActive\');
                        $(\'a[data-toggle="\'+tog+\'"][data-title="\'+sel+\'"]\').removeClass(\'notActive\').addClass(\'active\');
                    })
                  </script>
              ';     
      }
      
      return new Response($form);
    }
    /**
     * Add an item to my followed list
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajoutAction(Request $request)
    { 
        $nom = $request->get('nom'); 
        $saison = $request->get('saison');
        $episode = $request->get('episode');
        $cible = $request->get('cible');
        $seen = $request->get('seen');
        $retour = "ok";  
        $em = $this->getDoctrine()->getManager(); 

        $user = $this->get('security.context')->getToken()->getUser();
        $list_friendship_hold = $em
          ->getRepository('RPUserBundle:Friend') 
          ->findBy(
             array('holder'=>$user)
            )     
        ;
        $list_friendship_target = $em
          ->getRepository('RPUserBundle:Friend') 
          ->findBy(
             array('target'=>$user)
            )     
        ;

        $actualite = new Actualite();
        $actualite->setType('Liste');
        $actualite->setTitre('Nouveau suivi');
        $actualite->setUser($user);
        $actualite->setTarget($user);

        if($cible == "serie"){
          $serie = $em->getRepository('RPCoreBundle:Serie')->findOneBy(array('name' => $nom)); 
          foreach ($list_friendship_hold as $friend) {
            $actualite_holder = new Actualite(); 
            $actualite_holder->setType('Liste'); 
            $actualite_holder->setTitre('Nouveau suivi');
            $actualite_holder->setUser($friend->getTarget());
            $actualite_holder->setTarget($user);
            $actualite_holder->setContenu("<a href='/web/app_dev.php/user/".$user->getId()."'>".$user->getUsername()."</a> a ajouté <a class=\"post_link\" href=\"/web/app_dev.php/serie/".$serie->getId()."\" title=\"Standard Post 2\"> ".$nom."</a> a sa liste de séries");
            $em->persist($actualite_holder); 
          }
          foreach ($list_friendship_target as $friend) {
            $actualite_target = new Actualite();
            $actualite_target->setType('Liste');
            $actualite_target->setTitre('Nouveau suivi');
            $actualite_target->setUser($friend->getHolder());
            $actualite_target->setTarget($user);
            $actualite_target->setContenu("<a href='/web/app_dev.php/user/".$user->getId()."'>".$user->getUsername()."</a> a ajouté <a class=\"post_link\" href=\"/web/app_dev.php/serie/".$serie->getId()."\" title=\"Standard Post 2\"> ".$nom."</a> a sa liste de séries");
            $em->persist($actualite_target);   
          }
 
          $actualite->setContenu("<a href='/web/app_dev.php/user/".$user->getId()."'>".$user->getUsername()."</a> a ajouté <a class=\"post_link\" href=\"/web/app_dev.php/serie/".$serie->getId()."\" title=\"Standard Post 2\"> ".$nom."</a> a sa liste de séries");
          $em->persist($actualite);
          $retour = $serie->getId(); 
         
          $suivi_serie = new FollowSerie();
          $suivi_serie->setSaison($saison);
          $suivi_serie->setEpisode($episode);
          $suivi_serie->setSerie($serie);
          $suivi_serie->setUser($this->getUser()); 
          $suivi_serie->setDate(new \DateTime("now"));  
          $em->persist($suivi_serie);
          $em->flush();  
          $retour = "
          <tr id='suivi_serie_".$suivi_serie->getId()."'> 
            <td>".$suivi_serie->getId()."</td>
            <td>".$nom."</td>
            <td>
            <select class=\"selectpicker\" id=\"serieSaison".$suivi_serie->getId()."\" onchange=\"modifSaison('".$suivi_serie->getId()."','serie')\">";
            $retour .= "<option>".$suivi_serie->getSaison()."</option>";
            for($i = 0 ; $i <= 1000 ; $i++ ){
              $retour .= "<option>".$i."</option>";
            }
          
          $retour .= "
            </select>
            </td>
            <td>      
            <select class=\"selectpicker\" id=\"serieEpisode".$suivi_serie->getId()."\" onchange=\"modifEpisode('".$suivi_serie->getId()."','serie')\">";
            $retour .= "<option>".$suivi_serie->getEpisode()."</option>";
            for($i = 0 ; $i <= 1000 ; $i++ ){
              $retour .= "<option>".$i."</option>";
            }

            $retour .= "</select>
            </td>
            <td>
              <center>  
                <a href=\"index.php?page=ajoutAvisSerie&serie=".htmlspecialchars($nom) . "\" class='btn btn-sm btn-warning'><span class=\"glyphicon glyphicon-star-empty\"></span>
                </a>
              </center>
            </td> 
            <td>
              <center> 
                <a href=\"index.php?page=delete&conc=series&serie=". $serie->getId() ."\" class='btn btn-sm btn-danger'><span class=\"glyphicon glyphicon-remove\"></span> 
                </a>
              </center>
            </td> 
          </tr>
          ";
        }else if($cible == "anime"){ 
          $anime = $em->getRepository('RPCoreBundle:Anime')->findOneBy(array('name' => $nom));
          $actualite->setContenu("<a href='/web/app_dev.php/user/".$user->getId()."'>".$user->getUsername()."</a> a ajouté <a class=\"post_link\" href=\"/web/app_dev.php/anime/".$anime->getId()."\" title=\"Standard Post 2\"> ".$nom."</a> a sa liste d'animes");
           $em->persist($actualite);
          $retour = $anime->getId();
          $suivi_anime = new FollowAnime($saison,$episode,'',date("Y-m-d"),$anime->getId(),$id);
          $suivi_anime->setSaison($saison);
          $suivi_anime->setEpisode($episode);
          $suivi_anime->setAnime($anime);
          $suivi_anime->setUser($this->getUser());  
          $suivi_anime->setDate(new \DateTime("now")); 
          $em->persist($suivi_anime);
          $em->flush();

 
          $retour = "
          <tr id='suivi_anime_".$suivi_anime->getId()."'>
            <td>".$suivi_anime->getId()."</td>
            <td>".$nom."</td>
            <td>
            <select class=\"selectpicker\" id=\"animeSaison".$suivi_anime->getId()."\" onchange=\"modifSaison('".$suivi_anime->getId()."','anime')\">";
            $retour .= "<option>".$suivi_anime->getSaison()."</option>";
            for($i = 0 ; $i <= 1000 ; $i++ ){
              $retour .= "<option>".$i."</option>";
            }
          
            $retour .= "
            </select>
            </td>
            <td>      
            <select class=\"selectpicker\" id=\"animeEpisode".$suivi_anime->getId()."\" onchange=\"modifEpisode('".$suivi_anime->getId()."','anime')\">";
            $retour .= "<option>".$suivi_anime->getEpisode()."</option>";
            for($i = 0 ; $i <= 1000 ; $i++ ){
              $retour .= "<option>".$i."</option>";
            }
 
          $retour .= "</select>
            </td>  
            <td>
              <center>  
                <a href=\"index.php?page=ajoutAvisSerie&anime=".htmlspecialchars($nom) . "\" class='btn btn-sm btn-warning'><span class=\"glyphicon glyphicon-star-empty\"></span>
                </a>
              </center>
            </td> 
            <td>
              <center> 
                <a href=\"index.php?page=delete&conc=anime&anime=". $anime->getId() ."\" class='btn btn-sm btn-danger'><span class=\"glyphicon glyphicon-remove\"></span> 
                </a>
              </center>
            </td> 
          </tr>
          ";
        }else if($cible == "film"){
          $film = $em->getRepository('RPCoreBundle:Film')->findOneBy(array('name' => $nom));
          $actualite->setContenu("<a href='/web/app_dev.php/user/".$user->getId()."'>".$user->getUsername()."</a> a ajouté <a class=\"post_link\" href=\"/web/app_dev.php/film/".$film->getId()."\" title=\"Standard Post 2\"> ".$nom."</a> a sa liste de films");
           $em->persist($actualite); 
          $retour = $film->getId();
          $suivi_film = new FollowFilm();
          $suivi_film->setSeen($seen);
          $suivi_film->setUser($user);
          $suivi_film->setFilm($film);
          $suivi_film->setDate(new \DateTime("now"));  
          $em->persist($suivi_film);
          $em->flush();

          $retour = "
          <tr id='suivi_film_".$suivi_film->getId()."'>
            <td>".$suivi_film->getId()."</td>
            <td>".$nom."</td>
            ";
 
            if($seen == true){
              $retour .= '<td><a href="#" class="btn btn-sm btn-success" onclick="change("'. $suivi_film->getId() .'");"><span class="glyphicon glyphicon-ok"></span></a></td>';
            }else{
              $retour .= '<td><a href="#" class="btn btn-sm btn-danger" onclick="change("'. $suivi_film->getId() .'");"><span class="glyphicon glyphicon-remove"></span></a></td>';
            }

            $retour .= "
            <td>
              <center>  
                <a href=\"index.php?page=ajoutAvisSerie&film=".htmlspecialchars($nom) . "\" class='btn btn-sm btn-warning'><span class=\"glyphicon glyphicon-star-empty\"></span>
                </a>
              </center>
            </td> 
            <td>
              <center> 
                <a href=\"index.php?page=delete&conc=film&film=". $film->getId() ."\" class='btn btn-sm btn-danger'><span class=\"glyphicon glyphicon-remove\"></span> 
                </a>
              </center>
            </td> 
          </tr> 
          ";
        }   

        return new Response($retour);
    }
    /**
     * Delete an item to my followed list
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteAction(Request $request)
    { 
        $id = $request->get('id'); 
        $cible = $request->get('cible');
        $retour = "ok";   
        $em = $this->getDoctrine()->getManager(); 
        

        if($cible == "serie"){
          $suivi_serie = $em->getRepository('RPCoreBundle:FollowSerie')->find($id);
          $em->remove($suivi_serie);
         
         
        }else if($cible == "anime"){
          $suivi_anime = $em->getRepository('RPCoreBundle:FollowAnime')->find($id);
          $em->remove($suivi_anime);
        
        }else if($cible == "film"){
          $suivi_film = $em->getRepository('RPCoreBundle:FollowFilm')->find($id);
          $em->remove($suivi_film); 
        }   
                  
        $em->flush();  

        return new Response($retour);
    }
    /**
     * Add a note to an item
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function noterAction(Request $request)
    { 
        $id = $request->get('id'); 
        $cible = $request->get('cible');
        $retour = "ok";    
        $em = $this->getDoctrine()->getManager(); 
        

        if($cible == "serie"){
          $suivi_serie = $em->getRepository('RPCoreBundle:FollowSerie')->find($id);
          $suivi_serie->setNote($request->get('note'));
          $suivi_serie->setComment($request->get('commentaire')); 

          var_dump($suivi_serie);
        }else if($cible == "anime"){
          $suivi_anime = $em->getRepository('RPCoreBundle:FollowAnime')->find($id);
          $suivi_anime->setNote($request->get('note'));
          $suivi_anime->setComment($request->get('commentaire')); 
        
        }else if($cible == "film"){
          $suivi_film = $em->getRepository('RPCoreBundle:FollowFilm')->find($id);
          $suivi_film->setNote($request->get('note'));
          $suivi_film->setComment($request->get('commentaire')); 
        }   
                  
        $em->flush();  

        return new Response($retour);
    }
    /**
     * Share my list
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function shareAction(Request $request)
    { 
       $em = $this->getDoctrine()->getManager(); 
        $user = $this->get('security.context')->getToken()->getUser();

        //Poster chez moi 
        $post = "Ma liste : <a href='/web/app_dev.php/list/get/".$user->getId()."'> Cliquez ici </a>";
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
        return new Response($post);
    }
    /**
     * Get someone's list
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function getAction(User $user){  
      $em = $this->getDoctrine()->getManager();

        
        // On récupère maintenant la liste des AdvertSkill
      $listFollowSerie = $em
          ->getRepository('RPCoreBundle:FollowSerie')
          ->findBy(array('user' => $user),array('id' => 'ASC'))
      ;

      $listFollowAnime = $em
          ->getRepository('RPCoreBundle:FollowAnime')
          ->findBy(array('user' => $user),array('id' => 'ASC'))
      ;
  
      $listFollowFilm = $em
          ->getRepository('RPCoreBundle:FollowFilm')
          ->findBy(array('user' => $user),array('id' => 'ASC'))
      ;

      return $this->render('RPListBundle:List:get.html.twig', array(
        'user'           => $user,
        'listFollowSerie' => $listFollowSerie,
        'listFollowAnime' => $listFollowAnime,
        'listFollowFilm' => $listFollowFilm
      ));
    } 
}
 