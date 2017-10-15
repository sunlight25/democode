(function($){
$(document).ready(function ($) {
	"use strict";
	// Initialize collapse button
	$(".so-main-menu").sideNav();
	$(".so-login").sideNav({
		menuWidth: 300, // Default is 300
		edge: 'left', // Choose the horizontal origin
		closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
		draggable: true, // Choose whether you can drag to open on touch screens,
		//onOpen: function(el) { /* Do Stuff */ }, // A function to be called when sideNav is opened
		//onClose: function(el) { /* Do Stuff * / }, // A function to be called when sideNav is closed
	});
	// Initialize collapsible (uncomment the line below if you use the dropdown variation)
	$('.collapsible').collapsible();
	$('select').material_select();
	$('.dropdown-button').dropdown();		
	$('.tooltipped').tooltip({
		delay: 50
	});
	$('.carousel.carousel-slider').carousel({fullWidth: true});
	$('ul.tabs').tabs();
	$('.modal').modal();
	$('.owl-carousel').owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
});	
	$("#hide_welcome").click(function () {
		$("#dash_welcome").fadeOut(500);
	});

	$("#header_search_btn").click(function () {
		$("#header_search").toggle(100);
	});
	
	$(window).resize(function () {
		var window_size = $(window).height() - 156;
		$(".bh").css("max-height", (window_size));
		$(".bh").css("height", (window_size));
	}).resize(); //trigger resize on page load

	$("#page_loader").delay(1000).queue(function(next){
		$(this).addClass("hidden");
		next();
	});	
}).resize();

$(window).scroll(function () {
	"use strict";
	var scroll = jQuery(window).scrollTop();
	if (scroll >= 150) {
		jQuery("#site_header").addClass("stick");
		//jQuery("#after_header").addClass("stuck-header");
	}
	if (scroll <= 150) {
		jQuery("#site_header").removeClass("stick");
		//jQuery("#after_header").removeClass("stuck-header");
	}
});

$("#event_info_toggle").click(function () {
	"use strict";
	$("#event_info").toggle("slide", function () {
		// Animation complete.
	});
});
})(jQuery); // end of jQuery name space


/*
* For The Drupal JS Use
* 
*/

/*(function($){
  $(function(){

    $('.button-collapse').sideNav();
    $('.parallax').parallax();

  }); // end of document ready
})(jQuery); // end of jQuery name space*/