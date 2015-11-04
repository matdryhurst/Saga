  /*
    For Adding a new plugin support for eg: image 
    1) Define event in a movieEvents with key: value pair i-e
    [{
    'eventName': 'image',
     options: {
            start: 5,
          // seconds
          end: 15,
          href: "http://www.drumbeat.org/",
          src: "https://www.drumbeat.org/media//images/drumbeat-logo-splash.png",
          text: "DRUMBEAT",
          target: "imagediv"
     }
    }]

    2) Go to function applyMovieEvents() and add a case there incase of image we will do
    pop.image(currentEvent.options); same follows by other plugins i-e pop.[pluginname](currentEvent.options)

    3) For adding two events to a sequence let say 1 we will do this in movieEvents 
    {
      0:[{
      'eventName':'footnotereplace',
      'options': {
         start: 1,
         end: 2,
         text: "This is first video - first event",
         target: "redArea1"
      }

      },
      {'eventName':'footnotereplace',
      'options':{
       start: 3,
       end: 4,
       text: "This is first video - second event",
       target: "redArea2"
      }

  }],


    */

$('player').on('contextmenu', function(e) {e.preventDefault();}); 

  var played = false;
  var pop;
  var movieIndex = 0;
  var isMobile;
  var shareClicked = false;

  var movieArray = [
      'media/white.mov',
      'media/red.mov','media/pink.mov','media/black.mov',
      
  ];
  //      pop.webpage({
  //   id: "webpages-a",
  //   start: 0,
  //   end: 5,
  //   src: "http://webmademovies.org/",
  //   target: "webpagediv"
  // });
  var movieEvents = {
      0: [{
          'eventName': 'footnotereplace',
          'options': {
              start: 0,
              end: 1,
              text: "I",
              target: "redArea2"
          }

      },
      {
          'eventName': 'image',
          'options': {
              start: 1,
              end: 5,
               src: "img/expressions/positive/love.png",
              text: "",
              target: "imageOverlayFront"
          }

    
     },
     
     {
          'eventName': 'footnotereplace',
          'options': {
              start: 1,
              end: 2,
              text: "GO",
              target: "redArea2"
          }
       



 },
     
     {
          'eventName': 'footnotereplace',
          'options': {
              start:2,
              end: 3,
              text: "WHERE",
              target: "redArea2"
          }
       

          
          },
     
     {
          'eventName': 'footnotereplace',
          'options': {
              start:3,
              end: 4,
              text: "IT",
              target: "redArea2"
          }
       

},
     
    {
          'eventName': 'footnotereplace',
          'options': {
              start: 4,
              end: 5,
              text: "GOES",
              target: "redArea2"
          }
          
        
                   
        
      
      

      }],
      // ],
      1: [{
          'eventName': 'footnotereplace',
          'options': {
              start: 1,
              end: 5,
              text: "#2",
              target: "redArea2"
          }
           },
      {
          'eventName': 'image',
          'options': {
              start: 0,
              end: 5,
               src: "img/expressions/negative/negativelink.png",
              text: "",
              target: "imageOverlayFront"
          }


          
          
      }],
      2: [{
          'eventName': 'image',
          'options': {
              start: 0,
              end: 5,
              src: "img/expressions/negative/no.png",
              text: "",
              target: "imageOverlayFront"
          }
          },
      {
          'eventName': 'footnotereplace',
          'options': {
              start: 1,
              end: 5,
              text: "#3",
              target: "redArea2"          }
          
          
          
      }],
      3: [{
          'eventName': 'image',
          'options': {
              start: 0,
              end: 5,
              href: "",
              src: "img/expressions/negative/negativelink.png",
              text: "",
              target: "imageOverlayFront"
          }
          
          },
      {
          'eventName': 'footnotereplace',
          'options': {
              start: 1,
              end: 5,
              text: "#4",
              target: "redArea2"          }
          
          
      }]
      //   {'eventName':'webpage',
      //     'options':{
      //                start: 1,
      //                end: 20,
      //                src: "http://mathewdryhurst.com",
      //                id: "webpages-a",
      //                target: "footnotediv"
      //               }

      //   }],
      // 1:[{'eventName':'footnote',
      //     'options':{
      //                start: 1,
      //                end: 6,
      //                text: "This is second video - first event",
      //                target: "redArea3"
      //              }

      //   }],
      // 2:[{'eventName':'footnote',
      //     'options':{
      //                start: 1,
      //                end: 4,
      //                text: "This is third video - first event",
      //                target: "footnotediv"
      //               }

      //   }],
      // 3:[]
  };

  function initPopUp() {
    $(".popup").find("textarea").text("<iframe width='1280' height='720' src='" + urlfunction() + "' scrolling='no' frameborder='0'></iframe>");

    var tumblrShareLink = "http://www.tumblr.com/share/video?embed=" + encodeURIComponent("<iframe width='100%' height='561' src='" + window.location.href + "' scrolling='no' frameborder='0'></iframe>");
    $("#tumblrtext").attr("href", tumblrShareLink);
    // $("#embedtext").flexibleArea();
    // $("#embedtext").autogrow();
  }

  function resizePopup() {
    console.log("POPUP");
    var videoWidth = $("video").width();
    var popWidth = 0.5;
    if(videoWidth < 1000) {
      popWidth = 0.75;
    } else if(videoWidth < 700) {
      // popWidth = 0.85;
    }
    
    $(".popup").width(videoWidth*popWidth);
    $(".popup").css("left", ((1-popWidth) * videoWidth)/2);
    // $("#embedtext").trigger('updateHeight');
    var popHeight = $(".right").outerHeight(true) + $(".popup").find("h2").outerHeight(true) + $("#embedtext").outerHeight(true) + $("#tumblrtext").outerHeight(true) + parseInt($(".inner").css("padding-bottom")) + parseInt($(".inner").css("padding-top"));
    $(".popup").height(popHeight);

    var topPos = ($("video").height() - popHeight)/2;
    $(".popup").css("top",topPos);
  }


  function urlfunction() {
      var param = encodeURIComponent(window.location.href);
      var url = "http://playground.kairo.io/iframe?f=" + param;
      return url;
  }

  function hoverFunction() {
    $("#player")[0].play();
    played = true;
  }

  function clickFunction() {
    // console.log("In Click Function");
    var player = $("#player")[0];
    if (player.paused) {
        // console.log("Play now");
        player.play();
    } else {
      // console.log("Pause now");
        player.pause();
    }
  }

  $(document).ready(function() {
      initMobile();
      if (checkMobile()) {
          //if(true){
          //mobile video
          //$('#myElement').show();
          //$('#responsive-div').hide();
          movieArray = [
              'media/white.mov',
      'media/red.mov','media/pink.mov','media/black.mov',
              
          ];
          var player = $("#player");
          player.find("source").attr("src", "media/white.mov");
          //$('#redArea1,#redArea2,#redArea3,#redArea4').hide();
          //player.play();
          /*jwplayer("myElement").setup({

                file: "media/Saga_demo_tiny.mp4",
            width: "100%",
            aspectratio: "16:9"
            //,
                //image: "/uploads/myPoster.jpg"
            });*/
      } else {

      }
      // Create a popcorn instance by calling Popcorn("#id-of-my-video")
      pop = Popcorn("#player");
      pop.on('ended', function() {
          movieIndex = (movieIndex + 1) % movieArray.length;

          $($('#player').children()[0]).attr('src', movieArray[movieIndex]);
          pop.load();
          pop.play();
      });

      pop.on('loadeddata', function() {
          applyMovieEvents();
      });
      // play the video right away
      //pop.play();
      applyMovieEvents();

      // console.log("document ready");
      $("#player").hover(function() {
          if (!played) {
              hoverFunction();
          }
      });
      // $(".row").hover(function() {
      //     if (!played) {
      //         hoverFunction();
      //     }
      // });
      // $(".imageOverlay").hover(function() {
      //     if (!played) {
      //         hoverFunction();
      //     }
      // });

      $(".row").on("click", function() {
          console.log("row click");
          // clickFunction();
      });

      $("#container-div").on("click", function() {
        console.log("Container Div");
        // clickFunction();
      });

      $(".imageOverlay").on("click", function() {
          console.log("Image Overlay");
          // clickFunction();
      });

      // $("#title").on("click", function() {
      //     // console.log("Image Overlay");
      //     // clickFunction();
      // });

      $("#player").click(function() {

          clickFunction();
      });
      $(".share").click(function() {
          // var tumblrShareLink = "http://www.tumblr.com/share/video?embed=" + encodeURIComponent("<iframe width='100%' height='561' src='" + window.location.href + "' scrolling='no' frameborder='0'></iframe>");
          // var popup = "<div class='popup'><div class='inner'><h2>Embed " + $(".calltip").text() + "</h2><div class='right'>Size:<select id='size'><option value='375|270'>375 &times; 270</option><option value='500|360'>500 &times; 360</option><option value='600|420'>600 &times; 420</option><option value='800|561' selected>800 &times; 561</option></select></div><textarea id='embedtext' disabled><iframe width='800' height='561' src='" + urlfunction() + "' scrolling='no' frameborder='0'></iframe></textarea> <a id='tumblrtext' target='_blank' href='" + tumblrShareLink + "' class='sharelink' title='Share on Tumblr'>Tumblr</a> <a class='sharelink' target='_blank' href='http://twitter.com/home/?status=SAGA | Mat Dryhurst http://sa-ga.city'>Twitter</a> <a target='_blank' href='http://www.facebook.com/sharer/sharer.php?u=http://sa-ga.city' class='sharelink'>Facebook</a><a href='#' class='close'>&times;</a></div></div>";

          // if (!shareClicked) {
              // $(popup).appendTo($("body"));
              // shareClicked = true;
          // } else {
              // $(".popup").show()
          // }
          $(".popup").toggle();
          resizePopup();

          // $("#tumblrtext").attr("href", tumblrShareLink);
          return false;
      });

      $("#body").on("change", "#size", function() {
          var sizes = $(this).val().split("|");
          $("#embedtext").val("<iframe width='" + sizes[0] + "' height='" + sizes[1] + "' src='" + urlfunction() + "' scrolling='no' frameborder='0'></iframe>");
      });

      $(".share").mouseenter(function() {
          // $(".sharetip").css("width", $("#action").outerWidth())
          // $(".sharetip").css("bottom", $("#action").outerHeight())
          // $(".sharetip").css("right", $("#action").outerHeight())
          //$(".sharetip").show();
      }).mouseleave(function() {
          //$(".sharetip").hide();
      });

      $(".call").mouseenter(function() {
          //$(".calltip").show();
      }).mouseleave(function() {
          //$(".calltip").hide();
      });


      $("#body").on("click", '.close', function() {
          $(".popup").hide();
          return false;
      });

      initPopUp();

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
      $(".imageOverlay").width($("#player").outerWidth());
      $(".imageOverlay").height($("#player").outerHeight());
      //adjustPopcornHeight();

      var bottom = 0;
      // if ($("#title").width() <= 700) {
      //     bottom = $("#player").height() - $("#title").position().top - $("#title").height() + 3;
      // } else {
      //     bottom = $("#player").height() - $("#title").position().top - $("#title").height() + 6;
      // }

      // $("#action").css({
      //     bottom: bottom,
      //     right: 15
      // });

      //resizePopup();
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

      $.each($("#container-div").find(".row"), function(index, value) {
          var $rowDiv = $(value);
          if (index == 0) {
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

  function checkMobile() {
      var md = new MobileDetect(window.navigator.userAgent);
      return md.mobile() != null;
  }


  function initMobile() {
      isMobile = {
          Android: function() {
              return navigator.userAgent.match(/Android/i);
          },
          BlackBerry: function() {
              return navigator.userAgent.match(/BlackBerry/i);
          },
          iOS: function() {
              return navigator.userAgent.match(/iPhone|iPad|iPod/i);
          },
          Opera: function() {
              return navigator.userAgent.match(/Opera Mini/i);
          },
          Windows: function() {
              return navigator.userAgent.match(/IEMobile/i);
          },
          any: function() {
              return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
          }

      };
  }

  function applyMovieEvents() {
      var allEvents = movieEvents[movieIndex];

      // if(movieIndex>0){
      // console.log("movieIndex "+movieIndex);
      var events = pop.getTrackEvents();
      for (e in events) {
          pop.removeTrackEvent(events[e]._id);
      }
      //}
      if (typeof movieEvents[movieIndex] != 'undefined') {
          for (var i = 0; i < allEvents.length; i++) {
              // console.log("value of i "+i);
              var currentEvent = allEvents[i];
              switch (currentEvent.eventName) {
                  case 'footnote':
                      // console.log("footnote called");
                      pop.footnote(currentEvent.options);
                      break;
                  case 'footnotereplace':
                      // console.log("footnotereplace called");
                      pop.footnotereplace(currentEvent.options);
                      break;
                  case 'webpage':
                      pop.webpage(currentEvent.options);
                      break;
                  case 'image':
                      // console.log("footnotereplace called");
                      pop.image(currentEvent.options);
                      break;

              }
          }
      }
  }