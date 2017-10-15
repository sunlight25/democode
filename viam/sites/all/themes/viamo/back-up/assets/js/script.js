// JavaScript Document
jQuery(document).ready(function($) {
"use strict";
		$(window).resize(function(){	
					var window_size = $(window).height()-172.5;
					$(".bh").css("min-height", (window_size));
				})
		.resize();//trigger resize on page load
}).resize();
//
	jQuery(window).scroll(function() {
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