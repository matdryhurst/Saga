<?php echo theme_view('header'); ?>
<div id='container'>

  <h1><img src='../images/saga-logo-white.png' alt='SAGA' style="width:800px;"/></h1>            
  <?php foreach($embeds as $embed) { $token = bin2hex(openssl_random_pseudo_bytes(16));?>  
    <iframe width='800' height='561' src='<?php echo site_url().'iframe/?f='. urlencode(site_url(). 'static/'. $embed->name. '/?'. $token) ; ?>' scrolling='no' frameborder='0'></iframe>
  <?php }?>  
</div>

<div id='action'>
  <a class='credits' target="_blank" href='<?php echo base_url(uri_string()); ?>'><img src='../images/saga-white-bg.png'style="width:100px" /></a>
</div>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>   
<script src="/js/imagesloaded.min.js"></script>

<script>
  (function(e){e.fn.visible=function(t,n,r){var i=e(this).eq(0),s=i.get(0),o=e(window),u=o.scrollTop(),a=u+o.height(),f=o.scrollLeft(),l=f+o.width(),c=i.offset().top,h=c+i.height(),p=i.offset().left,d=p+i.width(),v=t===true?h:c,m=t===true?c:h,g=t===true?d:p,y=t===true?p:d,b=n===true?s.offsetWidth*s.offsetHeight:true,r=r?r:"both";if(r==="both")return!!b&&m<=a&&v>=u&&y<=l&&g>=f;else if(r==="vertical")return!!b&&m<=a&&v>=u;else if(r==="horizontal")return!!b&&y<=l&&g>=f}})(jQuery)

      jQuery(function($) {
        
        $(window).scroll(function() {
          $('iframe').each(function() {
            var iframe = $(this).contents();
            var img = $(iframe).find("#image");

            if($(this).visible(true)) {              
              
              if($(img).attr("src") === "img.jpg") {
                $(img).attr("src", "img.gif");                                
              }
            } else {
              $(img).attr("src", "img.jpg");
            }

          });

        });

        $(".credits").mouseenter(function() {
          $(".creditstip").show();
        });

        $("#action").mouseleave(function() {
          $(".creditstip").hide();          
          $(".rvngtip").hide();
        });

        $(".credits").mouseleave(function() {
          $(".creditstip").hide();          
        });
        
        $("body").click(function() {
          $(".creditstip-show").hide();
        });
        
        $(".credits").click(function() {
          $(".creditstip-show").show();
          return false;
        });
              
        $(".rvng").mouseenter(function() {
          $(".rvngtip").show();
        })

        $(".rvng").mouseleave(function() {
          $(".rvngtip").hide();
        });
        

      });
</script>
    
<script>
  var _gaq=[['_setAccount','UA-2277673-1'],['_trackPageview'],['_trackPageLoadTime']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script> 

<?php echo theme_view('footer'); ?>