/*Buscador*/
(function() {
    var cx = '008572255874373046644:chip1p1uf-4';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
  
  function checkBck(){
    if(jQuery('.gsc-search-button input').attr('src')){
        jQuery('.gsc-search-button input').attr('src','http://unal.edu.co/fileadmin/templates/plugins/ke_search/search.png')
          jQuery('.gsc-input input').attr('placeholder','Buscar en la Universidad')
          }else{
        window.setTimeout(function(){checkBck()},100);
          }
  }
 checkBck()
jQuery(document).ready(function($) {
    $('body').addClass('row-offcanvas row-offcanvas-right');
    $('#services').css({'right':parseInt($('#services').width())*-1})
  $('.indicator','#services').click(function() {
	$(this).toggleClass('active');
    $b=$('body');
    $s=$('#services');
    $s.height($(window).height()).toggleClass('active');
    $('ul',$s).height($(window).height());
    $('.row-offcanvas').toggleClass('active');
    if($b.hasClass('active')){
      $b.css({'right':$('#services').width(),'overflow':'hidden'})
      $s.css({'right':0})
    }else{
      $b.css({'right':0,'overflow':''})
      $s.css({'right':parseInt($('#services').width())*-1})
    }
  });
});
