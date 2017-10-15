(function ($) {            
  Drupal.behaviors.autocompleteSupervisor = {
    attach: function (context) {
      $(".on-off-ceremony-venue").on("click", function(){                               
         $(".ceremony-venue").trigger("mousedown");
      });
      
      $(".on-off-reception-venue").on("click", function(){                     
         $(".ceremony-venue").trigger("mousedown");
      });
      
      $('.timepicker').pickatime({
                                default: 'now',
                                twelvehour: false, // change to 12 hour AM/PM clock from 24 hour
                                donetext: 'OK',
                                autoclose: false,
                                vibrate: true // vibrate the device when dragging clock hand
      });
      
  
      $("input#edit-field-venues-und-0-target-id", context).bind('autocompleteSelect', function(event, node) {          
        if($(this).val() =='Other Venue (96)')  {             
           //jQuery("#edit-add-button").trigger('click');
           //$( "input#edit-add-button" ).trigger("click");
           $("input#edit-add-button", context ).trigger('click');
           jQuery('#edit-field-other-reception-venue').show();                
           $('.timepicker').pickatime({
                                default: 'now',
                                twelvehour: false, // change to 12 hour AM/PM clock from 24 hour
                                donetext: 'OK',
                                autoclose: false,
                                vibrate: true // vibrate the device when dragging clock hand
           });
           // console.log($(this).val()); // user-entered string
           // console.log($(node).data('autocompleteValue')); // key of selected item
           // console.log($(node).text()); // label of selected item               
        } else {
            
            jQuery('#edit-field-other-reception-venue').hide();     
            
        }                         
      });
      $("input#edit-field-ceremony-venue-und-0-target-id", context).bind('autocompleteSelect', function(event, node) {          
        if($(this).val() =='Other Venue (96)') {
           jQuery('#edit-field-other-ceremony-venue').show();     
        } else {
           jQuery('#edit-field-other-ceremony-venue').hide();     
        }                         
      });            
    }
  };
})(jQuery);



/*(function ($) {    
    jQuery(document).ready(function ($) {
        $("#customer_menu").mmenu({
            "extensions": [
                "pagedim-black",
                "theme-dark"
            ],
            "offCanvas": {
                "position": "right",
                "zposition": "front"
            },
            "counters": true,
            "iconPanels": true,
            "scrollBugFix": true,
            "navbar": {
                "add": false
            },
            "navbars": [
                {
                    "position": "bottom",
                    "content": [
                        "<a class='fa fa-envelope' href='#/'></a>",
                        "<a class='fa fa-twitter' href='#/'></a>",
                        "<a class='fa fa-facebook' href='#/'></a>"
                    ]
                }
            ]
        });
    });
    var $menu = $("#main_menu").mmenu({        
        "extensions": [
            //"pagedim-black",
            "theme-dark",
            "border-full",
            //"shadow-page",
            "shadow-panels"
        ],
        "setSelected": {
            "hover": true,
            "parent": true
        },
        "counters": true,
        "iconPanels": true,
        "navbars": [
            {
                "position": "top",
                "content": [
                    "searchfield"
                ]
            },
            {
                "position": "bottom",
                "content": [
                    "<a class='fa fa-envelope' href='#/'></a>",
                    "<a class='fa fa-twitter' href='#/'></a>",
                    "<a class='fa fa-facebook' href='#/'></a>"
                ]
            }
        ]    
    });   
    var $icon = $(".my-icon");
    var API = $menu.data("mmenu");
    $icon.on("click", function () {
        API.open();
    });
    API.bind("opened", function () {
        setTimeout(function () {
            $icon.addClass("is-active");
        }, 100);
    });
    API.bind("closed", function () {
        setTimeout(function () {
            $icon.removeClass("is-active");
        }, 100);
    });
})(jQuery);*/


function displayMap() {
        document.getElementById('map').style.display = "block";
        initialize();
    }
var map;
function initialize() {
        // Create the map with no initial style specified.
        // It therefore has default styling.
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.86, lng: 151.209},
            zoom: 13,
            mapTypeControl: false
        });

        // Add a style-selector control to the map.
        var styleControl = document.getElementById('style-selector-control');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(styleControl);

        // Set the map's style to the initial value of the selector.
        var styleSelector = document.getElementById('style-selector');
        map.setOptions({styles: styles[styleSelector.value]});

        // Apply new JSON when the user selects a different style.
        styleSelector.addEventListener('change', function () {
            map.setOptions({styles: styles[styleSelector.value]});
        });
    }
var styles = {
        default: null,
        silver: [
            {
                elementType: 'geometry',
                stylers: [{color: '#f5f5f5'}]
            },
            {
                elementType: 'labels.icon',
                stylers: [{visibility: 'off'}]
            },
            {
                elementType: 'labels.text.fill',
                stylers: [{color: '#616161'}]
            },
            {
                elementType: 'labels.text.stroke',
                stylers: [{color: '#f5f5f5'}]
            },
            {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#bdbdbd'}]
            },
            {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#eeeeee'}]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#757575'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{color: '#e5e5e5'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#ffffff'}]
            },
            {
                featureType: 'road.arterial',
                elementType: 'labels.text.fill',
                stylers: [{color: '#757575'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#dadada'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{color: '#616161'}]
            },
            {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            },
            {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#e5e5e5'}]
            },
            {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#eeeeee'}]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{color: '#c9c9c9'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            }
        ],
        night: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
                featureType: 'administrative.locality',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{color: '#263c3f'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#6b9a76'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#38414e'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry.stroke',
                stylers: [{color: '#212a37'}]
            },
            {
                featureType: 'road',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9ca5b3'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#746855'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#1f2835'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{color: '#f3d19c'}]
            },
            {
                featureType: 'transit',
                elementType: 'geometry',
                stylers: [{color: '#2f3948'}]
            },
            {
                featureType: 'transit.station',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{color: '#17263c'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#515c6d'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#17263c'}]
            }
        ],
        retro: [
            {elementType: 'geometry', stylers: [{color: '#ebe3cd'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#523735'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},
            {
                featureType: 'administrative',
                elementType: 'geometry.stroke',
                stylers: [{color: '#c9b2a6'}]
            },
            {
                featureType: 'administrative.land_parcel',
                elementType: 'geometry.stroke',
                stylers: [{color: '#dcd2be'}]
            },
            {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#ae9e90'}]
            },
            {
                featureType: 'landscape.natural',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
            },
            {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#93817c'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry.fill',
                stylers: [{color: '#a5b076'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#447530'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#f5f1e6'}]
            },
            {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [{color: '#fdfcf8'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#f8c967'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#e9bc62'}]
            },
            {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry',
                stylers: [{color: '#e98d58'}]
            },
            {
                featureType: 'road.highway.controlled_access',
                elementType: 'geometry.stroke',
                stylers: [{color: '#db8555'}]
            },
            {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#806b63'}]
            },
            {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
            },
            {
                featureType: 'transit.line',
                elementType: 'labels.text.fill',
                stylers: [{color: '#8f7d77'}]
            },
            {
                featureType: 'transit.line',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#ebe3cd'}]
            },
            {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#dfd2ae'}]
            },
            {
                featureType: 'water',
                elementType: 'geometry.fill',
                stylers: [{color: '#b9d3c2'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#92998d'}]
            }
        ],
        hiding: [
            {
                featureType: 'poi.business',
                stylers: [{visibility: 'off'}]
            },
            {
                featureType: 'transit',
                elementType: 'labels.icon',
                stylers: [{visibility: 'off'}]
            }
        ]
    };
 
 /*fancybox popup*/   
/*$(document).ready(function() {
    $.fancybox(
        '<h2>Hi!</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eu elit tempor facilisis id et neque</p>',
        {                        
            'width'             : '450px', 
            'height'             : '450px', 
        }
    );
});*/

/*jQuery(document).ready(function() {
        jQuery.fancybox.open('<div class="message"><h2>Hello!</h2><p>You are awesome!</p></div>');
});*/
            
                /*$(document).ready(function() {
                    alert(4544);
                }); */    
      /*$(".on-off-ceremony-venue").on("click", function(){                     
               alert(45454545);
               //$(".ceremony-venue").trigger("click");
                $("#edit-add-button").trigger("mousedown");
      });*/