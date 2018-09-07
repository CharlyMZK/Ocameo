var contactTitle = true;
var mainTitle = true;
var mainBlog = true;
var mainBlog1 = true;
var blogbtn = true;
var mainPins = true;
var mainFilters = false;
var mainWrap = false;
var up = true;
var down = true;
var tabloc = window.location+"";
var loc = "";
var menu =false;



$('.down').click(function(){
  $('html, body').animate({
    scrollTop: 800
  }, 800);
});

setInterval(function(){ 
  $('#bump').removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
    $(this).removeClass();
  });
}, 3000);
   

tabloc = tabloc.split("/");
size = tabloc.length; 
loc = tabloc[size-1]; 
 

if(tabloc[size-1] == "login" || tabloc[size-2] == "register" || tabloc[size-2] == "profile" || tabloc[size-2] == "user" || tabloc[size-1] == "maliste" || tabloc[size-2] == "profile" || tabloc[size-1] == "friends" || tabloc[size-1] == "notifications"  || tabloc[size-2] == "get"  ){
  menu = true;
}

if(menu){
  $('.navbar').addClass('navbar-default');
} 

$(document).scroll(function(){
    var s = $(document).scrollTop();

   

   if(!menu){

    if(s > 0 && up){
      up = false;
      down = true;
      setTimeout(function(){ 
          $('#nav').removeClass().addClass('fadeOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
              $(this).removeClass();
          });
      }, 300);
      setTimeout(function(){ 
          $('.navbar').addClass('navbar-default');                    
          $('#nav').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();  
          });
      }, 300);

    }else if(s == 0 && down){
          up = true;
      down = false; 
      setTimeout(function(){ 
          $('#nav').removeClass().addClass('fadeOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
              $(this).removeClass();
          });
      }, 300);
      setTimeout(function(){ 
          $('.navbar').removeClass('navbar-default');                  
              $('#nav').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
              $(this).removeClass();  
          });
      }, 300);

    }
 }
  });


 


  $( document ).ready(function() {
     

      $('body').css('display','block');
  });



$(document).scroll(function(){
  var s = $(document).scrollTop();
  console.log(s);

  if(s > 370){
     if(mainTitle){
      $('#mainTitle').css('display','block');
      $('#mainTitle').removeClass().addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
      });
      mainTitle = false;
     }
  } 
  if(s > 1300 && mainBlog){
      mainBlog = false;  

      setTimeout(function(){ 
        $('#blogtitle').css('display','block');
        $('#blogtitle').removeClass().addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
      }, 300);

      setTimeout(function(){       
        $('#blog1').css('display','block');
        $('#blog1').removeClass().addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 600);

      setTimeout(function(){       
        $('#blog1text').css('display','block');
        $('#blog1text').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 1500);

      setTimeout(function(){       
        $('#blog2').css('display','block');
        $('#blog2').removeClass().addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 1200);

      setTimeout(function(){       
        $('#blog2text').css('display','block');
        $('#blog2text').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 2100);
  }
  if(s > 1800 && mainBlog1){
      mainBlog1 = false;
      setTimeout(function(){       
        $('#blog3').css('display','block');
        $('#blog3').removeClass().addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 1200);

      setTimeout(function(){       
        $('#blog3text').css('display','block');
        $('#blog3text').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 2100);

      setTimeout(function(){       
        $('#blog4').css('display','block');
        $('#blog4').removeClass().addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 1500);      
  
      setTimeout(function(){       
        $('#blog4text').css('display','block');
        $('#blog4text').removeClass().addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 2100);
  }
  if(s > 2300 && blogbtn){
      blogbtn = false;

      setTimeout(function(){       
        $('#buttoncv').css('display','block');
        $('#buttoncv').removeClass().addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 100);
  }
  if(s > 2600 && contactTitle){
      contactTitle = false;
 
      setTimeout(function(){       
        $('#contact-title').css('display','block');
        $('#contact-title').removeClass().addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 10);

         setTimeout(function(){       
        $('#contact-form').css('display','block');
        $('#contact-form').removeClass().addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 300);



   		setTimeout(function(){       
        $('#contact-send').css('display','block');
        $('#contact-send').removeClass().addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass();
        });
      }, 600);    
  }

});


$('.envoi').click(function(){
  $.post( "{{ path('pf_core_mail') }}",{name:$('#name').val(),email:$('#email').val(),subject:$('#subject').val(),message:$('#message').val()}, function( data ) {
    swal({
      title: data,
      text: "",
      type: "success",
      confirmButtonClass: 'btn-success',
      confirmButtonText: 'D\'accord !'
    });
  });
}); 