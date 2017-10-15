/**
 * @file
 * Contains helper functions to work with theme.
 */

jQuery(".body_full").hide();
jQuery(".showmore").on("click", function (e) {
    //jQuery(".body_trim").hide();
    var sid = jQuery(this).attr('alt');
    jQuery("#showmore"+sid).show();
    jQuery("#showless"+sid).hide();
});



jQuery(".showless").on("click", function (e) {
    //jQuery(".body_full").hide();
    var sid = jQuery(this).attr('alt');
    jQuery("#showless"+sid).show();
    jQuery("#showmore"+sid).hide();
});

jQuery(".edit_comment").on("click", function (e) {jQuery("#edit_commentV").val(jQuery(this).attr('href'));});

jQuery(".checkcomment").on("click", function (e) {
    
var commentV = jQuery("#edit_commentV").val();

 
if(jQuery(commentV+" .form-textarea").val() === ''){

        Materialize.toast('<ul>\n<li>Please add expert comment.</li>\n</ul>\n', 5000, "toast alert-error");
	e.preventDefault();
	return false;
}

});


(function ($) {
  "use strict"

  /**
   * Changes caret icon for fieldset when it is being collapsed or expanded.
   */
  Drupal.behaviors.materializeFieldset = {
    attach: function (context) {
      jQuery('fieldset', context).on('collapsed', function (data) {
        var $caretIcon = jQuery('.fieldset-title i', this);
        if (data.value === true) {
          $caretIcon.removeClass('mdi-hardware-keyboard-arrow-down').addClass('mdi-hardware-keyboard-arrow-right');
        }
        else {
          $caretIcon.removeClass('mdi-hardware-keyboard-arrow-right').addClass('mdi-hardware-keyboard-arrow-down');
        }
      });
    }
  };
  jQuery(".button-collapse").sideNav();
})(jQuery);


(function ($) {
        $(document).ready(function () {		
        $('select').material_select();
        $('.button-collapse').sideNav();
        $('#showmenu').click(function() {
                $('#showmenunewfirst').slideToggle("fast");
        });
		$('#showmenunew').click(function() {
                $('#showmenunew1').slideToggle("fast");
        });
		$('#tagarrow').click(function() {
                $('#tagarrowrow').slideToggle("fast");
				$(this).toggleClass('updownarrow');
				
        });
        
        $(document).scroll(function () {
	  var $nav = $(".dark-red");
	  $nav.toggleClass('fixedmenu', $(this).scrollTop() > $nav.height());
          
          var schoollist = $("#school-list");
	  schoollist.toggleClass('school-list-fixed', $(this).scrollTop() > $nav.height());
	});
        
       /***Start Mobile Menu***/  
       jQuery("#buttin-collapse-mobile-view").live("click", function (e) {
            e.preventDefault();
           // jQuery("#block-menu-menu-top-main-menu-mobile-view > div.content > ul.menu").animate({left: '0px'});
            //jQuery("body").append("<div id='sidenav-overlay' class='sidenav-overlay' style='opacity: 1;'></div>");
            jQuery('.sidenav-overlay').css('cursor','pointer')
        });
        jQuery(document).on('click', '.sidenav-overlay',  function(e) {
                e.preventDefault()
             //   jQuery("#block-menu-menu-top-main-menu-mobile-view > div.content > ul.menu").animate({left: '-250px'},200);
                jQuery(".sidenav-overlay").remove();
        });
        jQuery("li.tools-mobile-view > ul.dropdown-content-submenu > li > a").click(function (event) {
            var href = jQuery(this).attr("href");
            //window.location = href;
            window.open(href, '_blank'); 
            return false;
        });
        jQuery("li.tools-mobile-view").click(function (e) {
            e.preventDefault();            
           // alert(1);
            jQuery(this).find(".dropdown-content-submenu").toggle();
            jQuery(this).find(".dropdown-content-submenu").css({'position':'relative','opacity':'1'});
            
        });
        jQuery("li.campusmate-mobile-view > ul.dropdown-content > li > a").live("click", function (event) {
            var href = jQuery(this).attr("href");
            window.location = href;            
            return false;
        });
        jQuery("li.campusmate-mobile-view").live("click", function (e) {
            e.preventDefault();
            jQuery(this).find(".dropdown-content").toggle();
            jQuery(this).find(".dropdown-content").css({'position':'relative','opacity':'1'});
        });
        jQuery("li.apply-mobile-view > ul.dropdown-content > li > a").live("click", function (event) {
            var href = jQuery(this).attr("href");
            window.location = href;
            //window.open(href, '_blank');
            return false;
        });
        jQuery("li.apply-mobile-view").live("click", function (e) {
            e.preventDefault();
            jQuery(this).find(".dropdown-content").toggle();
            jQuery(this).find(".dropdown-content").css({'position':'relative','opacity':'1'});
        });
        /*****End Mobile Menu********/ 
        $('.modal').modal();        
        
        $(document).ajaxStart(function(){
            show_global_loading_overlay();
        });  	
	/* -----------------------------------------
        * Back to top
        * ----------------------------------------- */
        jQuery(function () {            
            jQuery('#back-to-top-block').click(function () {
                jQuery('body,html').animate({scrollTop: 0}, 500);
            });            
        });          
    });            
}(jQuery));

var isLoaded = 0; //Set the flag OFF 
jQuery(document).one("ready", function() {   
  var j = jQuery.noConflict();
        j(document).ajaxSuccess(function() {
            j('select').material_select();
                    // j('.view-schools').find('.cd-gallery').addClass('filter-is-visible');
//                     j('.view-schools').find('.cd-tab-filter').addClass('filter-is-visible');
  //                   j('.view-schools').find('.cd-filter').addClass('filter-is-visible');
    //                 j('.view-schools').find('.cd-filter-trigger').addClass('filter-is-visible');
                     
      //               j('#block-views-exp-schools-page').find('.cd-filter').addClass('filter-is-visible');
        //             j('#block-views-exp-schools-page').find('.cd-filter-trigger').addClass('filter-is-visible');
        });
        j(document).ajaxStop(function() {       
          j('#global-overlay').remove();  
          var lang = Drupal.settings.current_lang;
          var base_url = Drupal.settings.base_url;         
          if(window.location.pathname == '/schools' || window.location.pathname == '/'+lang+'/schools'){
            if(isLoaded){ //If flag is OFF then return false  
                isLoaded = 0; //Turn ON the flag                 
                return false;
            }
        j.getScript(base_url+'/sites/all/themes/ukschool/js/main.js', function() {
            isLoaded = 1; //Turn ON the flag                          
        });
          }                             
        });                                       
});


function show_global_loading_overlay() {    
    var overlay = jQuery('<div id="global-overlay"><div class="global-overlay-inside"></div> </div>');
    overlay.appendTo(document.body)
}


function updateTextInput(val) {    
    var slider = document.getElementById('');    
    document.getElementById('statutory-age').value=val;
    // slider.value();
}


jQuery(document).ajaxComplete(function(e, xhr, settings) {
  var lang = Drupal.settings.current_lang; 
  var langPath='';
  if(lang!='en'){
      langPath=lang+'/';
  } else {
      langPath='';
  }  
  
  if (settings.url == "/views/ajax?sort_by=field_teacher_first_name_value" || settings.url == "/views/ajax?sort_by=created" || settings.url == Drupal.settings.basePath + "?q=views/ajax" || settings.url == Drupal.settings.basePath +langPath+"views/ajax" || settings.url == Drupal.settings.basePath + "?q=system/ajax" ||  settings.url == Drupal.settings.basePath +langPath+"system/ajax") {       
                /*jQuery('.view-schools').find('.cd-gallery').addClass('filter-is-visible');
                jQuery('.view-schools').find('.cd-tab-filter').addClass('filter-is-visible');
                jQuery('.view-schools').find('.cd-filter').addClass('filter-is-visible');
                jQuery('.view-schools').find('.cd-filter-trigger').addClass('filter-is-visible');

                jQuery('#block-views-exp-schools-page').find('.cd-filter').addClass('filter-is-visible');
                jQuery('#block-views-exp-schools-page').find('.cd-filter-trigger').addClass('filter-is-visible');*/                
                var Filter_Status = Drupal.settings.FilterOpenStatus; 
                
                if(Filter_Status=='NO') {                    
                    jQuery('.cd-close').trigger("click");                                        
                }
  }       
});

jQuery(function($) {
	//Initiat WOW JS
	new WOW().init();   
	$('#counter').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
		if (visible) {
			$(this).find('.timer').each(function () {
				var $this = $(this);
				$({ Counter: 0 }).animate({ Counter: $this.text() }, {
					duration: 2000,
					easing: 'swing',
					step: function () {
						$this.text(Math.ceil(this.Counter));
					}
				});
			});
			$(this).unbind('inview');
		}
	});
});

(function ($) {
    Drupal.jsAC.prototype.found = function (matches) {
        // If no value in the textfield, do not show the popup.
        if (!this.input.value.length) {
            return false;
        }
        if (this.input.id == 'edit-title' || this.input.id == 'edit-title-top-menu-search') {
                // Prepare matches.
                var ul = $('<ul></ul>');
                var ac = this;
                for (key in matches) {
                  var res = key.split('|');                                                      
                  $('<li class="mv-row" data="' + res[1] + '"></li>')                            
                    .html($('<div></div>').html(res[0]))
                    .mousedown(function () { ac.hidePopup(this); })
                    .mouseover(function () { ac.highlight(this); })
                    .mouseout(function () { ac.unhighlight(this); })
                    .data('autocompleteValue', res[0])
                    .appendTo(ul);
                }
        } else {
            // Prepare matches.
            var ul = $('<ul></ul>');
            var ac = this;
            for (key in matches) {
              $('<li></li>')
                .html($('<div></div>').html(matches[key]))
                .mousedown(function () { ac.hidePopup(this); })
                .mouseover(function () { ac.highlight(this); })
                .mouseout(function () { ac.unhighlight(this); })
                .data('autocompleteValue', key)
                .appendTo(ul);
            }
            
        }

        /* -----------------------------------------
         * Show popup with matches, if any
         * ----------------------------------------- */
        if (this.popup) {
            if (ul.children().length) {
                $(this.popup).empty().append(ul).show();
                $(this.ariaLive).html(Drupal.t('Autocomplete popup'));
            }
            else {
                $(this.popup).css({visibility: 'hidden'});
                this.hidePopup();
            }
        }
    };

    Drupal.jsAC.prototype.hidePopup = function (keycode) {
        // Select item if the right key or mousebutton was pressed.
        if (this.selected && ((keycode && keycode != 46 && keycode != 8 && keycode != 27) || !keycode)) {
            this.input.value = $(this.selected).data('autocompleteValue');
            if (this.input.id == 'edit-title' || this.input.id == 'edit-title-top-menu-search') {
                var search_page_url = $(this.selected).attr('data');
                if (typeof search_page_url != 'undefined') {
                    window.location.href = search_page_url;
                }
            }
        }
        var popup = this.popup;
        if (popup) {
            this.popup = null;
            $(popup).fadeOut('fast', function () {
                $(popup).remove();
            });
        }
        this.selected = false;
        $(this.ariaLive).empty();
    };

    /**
     * Highlights a suggestion.
     */
    Drupal.jsAC.prototype.highlight = function (node) {
        if (this.selected) {            
            $('.autocomplete-select > div').removeClass('highlight-text');            
            $(this.selected).removeClass('autocomplete-select');
        }
        
        $(node).addClass('autocomplete-select');
        this.selected = node;                
        $('.autocomplete-select > div').addClass('highlight-text');
        $(this.ariaLive).html($(this.selected).html());
    };

    /**
     * Unhighlights a suggestion.
     */
    Drupal.jsAC.prototype.unhighlight = function (node) {        
        $('.autocomplete-select  > div').removeClass('highlight-text');        
        $(node).removeClass('autocomplete-select');
        this.selected = false;
        $(this.ariaLive).empty();
    };   
})(jQuery);


