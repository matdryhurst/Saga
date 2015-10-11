  var played = false;
  var pop;


  function urlfunction() {
      var param = encodeURIComponent(window.location.href);
      var url = "http://smartembeds.kairo.io/iframe?f=" + param;
      return url;
  }
  $(document).ready(function() {
      $("#player").hover(function() {
        if(!played) {
          // $("#player")[0].play();
          $("#player")[0].play();
          played = true;
        }
      });
       
      $("#player").click(function() {
        
        var player = $("#player")[0];
        if(player.paused) {
          player.play();
        } else {
          player.pause();
        }
      });
      $(".share").click(function() {
          var tumblrShareLink = "http://www.tumblr.com/share/video?embed=" + encodeURIComponent("<iframe width='100%' height='561' src='" + window.location.href + "' scrolling='no' frameborder='0'></iframe>");
          //alert(window.location.href.split("?").slice(1).join("?"));
          var popup = "<div class='popup'><div class='inner'><h2>Embed " + $(".calltip").text() + "</h2><div class='right'>Size:<select id='size'><option value='375|270'>375 &times; 270</option><option value='500|360'>500 &times; 360</option><option value='600|420'>600 &times; 420</option><option value='800|561' selected>800 &times; 561</option></select></div><textarea id='embedtext' disabled><iframe width='800' height='561' src='" + urlfunction() + "' scrolling='no' frameborder='0'></iframe></textarea> <a id='tumblrtext' target='_blank' href='" + tumblrShareLink + "' class='sharelink' title='Share on Tumblr'>Tumblr</a> <a class='sharelink' target='_blank' href='http://twitter.com/home/?status=Call Holly Herndon http://call.hollyherndon.com'>Twitter</a> <a target='_blank' href='http://www.facebook.com/sharer/sharer.php?u=http://call.hollyherndon.com' class='sharelink'>Facebook</a><a href='#' class='close'>&times;</a></div></div>";

          $(popup).appendTo($("body"));

          $("#tumblrtext").attr("href", tumblrShareLink);
          return false;
      });

      $("#body").on("change", "#size", function() {
          var sizes = $(this).val().split("|");
          $("#embedtext").val("<iframe width='" + sizes[0] + "' height='" + sizes[1] + "' src='" + urlfunction() + "' scrolling='no' frameborder='0'></iframe>");
      });

      $(".share").mouseenter(function() {
          $(".sharetip").show();
      }).mouseleave(function() {
          $(".sharetip").hide();
      });

      $(".call").mouseenter(function() {
          $(".calltip").show();
      }).mouseleave(function() {
          $(".calltip").hide();
      });


      $("#body").on("click", '.close', function() {
          $(".popup").hide();
          return false;
      });
      
  });

  $(window).load(function() {
    resize();
  });
  
  $(window).resize(function() {
    resize();
  });

  function resize() {
    

      // $("#container-div").height($("#title").position().top - 10)
      calculateHeights();
      //adjustPopcornHeight();

      var bottom = 0;
      if($("#title").width() <= 700) {
        bottom = $("#player").height() - $("#title").position().top - $("#title").height() + 3;
      } else {
        bottom = $("#player").height() - $("#title").position().top - $("#title").height() + 6;
      }

      $("#action").css({
          bottom: bottom,
          right: 15
      });
  }

  // function adjustPopcornHeight() {
  //   $("#footnotediv").height($("#player").height());
  // }


  function calculateHeights() {
    var bottomHeaderYPositon = $("#title").position().top;
    var totalAvailableHeight = bottomHeaderYPositon - 10;
    var upperHeaderHeight = 0.15 * totalAvailableHeight;
    var contentTotalSpace = totalAvailableHeight - upperHeaderHeight;

    var divCount = $("#container-div").find(".row").length;

    var marginPercentage = 0.4;
    var totalContentDivsHeight = divCount / (divCount + divCount * marginPercentage) * contentTotalSpace;
    var totalMarginDivsHeight = (divCount * marginPercentage) / (divCount + divCount * marginPercentage) * contentTotalSpace;
    var eachContentDivHeight = totalContentDivsHeight / divCount;
    var eachMarginHeight = totalMarginDivsHeight / divCount;

    $.each( $("#container-div").find(".row"), function( index, value ) {
      var $rowDiv = $(value);
      if(index == 0) {
        $rowDiv.css("margin-top", upperHeaderHeight);
      }
      $rowDiv.css("margin-bottom", eachMarginHeight);
      $rowDiv.css("height", eachContentDivHeight);
    });


  }

function changeText(idOfDiv, textOfDiv) {
  //$("#"+idOfDiv).text("");
  return textOfDiv;
}


document.addEventListener("DOMContentLoaded", function () {
         // Create a popcorn instance by calling Popcorn("#id-of-my-video")
         pop = Popcorn("#player");

         pop.footnotereplace({
           start: 1,
           end: 60,
           text: "Video has started playing. Yoohoo!",
           target: "redArea1"
         });

         pop.footnotereplace({
           start: 5,
           end: 60,
           text: "Now we change the second area",
           target: "redArea2"
         });

         pop.footnotereplace({
           start: 9,
           end: 60,
           text: "This is Mat",
           target: "redArea3"
         });

         pop.footnotereplace({
           start: 10,
           end: 60,
           text: "This is last",
           target: "redArea4"
         });

         pop.on('ended', function(){
            
            console.log('video has ended');
            $($('#player').children()[0]).attr('src','media/vapeblue.mp4');

            console.log($('video'));
            pop.load();
            pop.play();
            pop.off("ended");}



            
            
        );


            

            




         // add a footnote at 2 seconds, and remove it at 6 seconds
      //    pop.footnote({
      //      start: 1,
      //      end: 4,
      //      text: "Video has started playing. Yoohoo!",
      //      target: "footnotediv"
      //    });

      //    pop.webpage({
      //   id: "webpages-a",
      //   start: 5,
      //   end: 60,
      //   src: "http://wikipedia.com/",
      //   target: "footnotediv"
      // });

         // play the video right away
         //pop.play();

      }, false);