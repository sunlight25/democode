$.fancyConfirm = function (opts) {
	"use strict";
	opts = $.extend(true, {
		title: 'Are you sure?',
		message: '',
		okButton: 'OK',
		noButton: 'Cancel',
		callback: $.noop
	}, opts || {});

	$.fancybox.open({
		type: 'html',
		src: '<div class="fc-content">' +
			'<h3>' + opts.title + '</h3>' +
			'<p class="mb-4">' + opts.message + '</p>' +
			'<p class="tright">' +
			'<a class="btn v-blue mr-2" data-value="0" data-fancybox-close>' + opts.noButton + '</a>' +
			'<button data-value="1" data-fancybox-close class="btn v-blue">' + opts.okButton + '</button>' +
			'</p>' +
			'</div>',
		opts: {
			animationDuration: 300,
			animationEffect: 'material',
			modal: true,
			baseTpl: '<div class="fancybox-container fc-container" role="dialog" tabindex="-1">' +
				'<div class="fancybox-bg"></div>' +
				'<div class="fancybox-inner">' +
				'<div class="fancybox-stage"></div>' +
				'</div>' +
				'</div>',
			afterClose: function (instance, current, e) {
				var button = e ? e.target || e.currentTarget : null;
				var value = button ? $(button).data('value') : 0;

				opts.callback(value);
			}
		}
	});

};

// Step 2: Start using it!
// =======================

$("#confirm_remove_item").click(function () {
	"use strict";
	// Open customized confirmation dialog window
	$.fancyConfirm({
		title: "Remove this product",
		message: "By removing this product it will be removed from this list. To re add this product pleast visit the gift shop.",
		okButton: 'Confirm Remove',
		noButton: 'Keep',
		callback: function (value) {
			if (value) {
				$("#confirm_remove_item_rez").html("Removed");
				setTimeout(function () {
					$.fancybox.close();
				}, 1500); // 3000 = 3 secs
				$(".quick-view-aside .progress").addClass("active");
				setTimeout(function () {
					Materialize.toast('Product Removed', 5000)
				}, 2500); // 4000 is the duration of the toast
			} else {
				$("#confirm_remove_item_rez").html("Remove cancelled");
			}
		}
	});

});




$(function () {
	// Step 2: Start using it!
	// =======================
	"use strict";

	/*

			Advanced example - Product quick view
			=====================================

		*/

	$(".quick_view").fancybox({
		baseClass: 'quick-view-container',
		infobar: false,
		buttons: false,
		thumbs: false,
		margin: 0,
		touch: {
			vertical: false
		},
		animationEffect: "zoom",
		transitionEffect: "slide",
		transitionDuration: 500,
		baseTpl: '<div class="fancybox-container" role="dialog">' +
			'<div class="quick-view-content">' +
			'<div class="quick-view-carousel">' +
			'<div class="fancybox-stage"></div>' +
			'</div>' +
			'<div class="quick-view-aside"><div class="progress"><div class="indeterminate"></div></div></div>' +
			'<button data-fancybox-close class="quick-view-close">X</button>' +
			'</div>' +
			'</div>',

		onInit: function (instance) {

			/*

				#1 Create bullet navigation links
				=================================

			*/

			var bullets = '<ul class="quick-view-bullets">';

			for (var i = 0; i < instance.group.length; i++) {
				bullets += '<li><a data-index="' + i + '" href="javascript:;"><span>' + (i + 1) + '</span></a></li>';
			}

			bullets += '</ul>';

			$(bullets).on('click touchstart', 'a', function () {
					var index = $(this).data('index');

					$.fancybox.getInstance(function () {
						this.jumpTo(index);
					});

				})
				.appendTo(instance.$refs.container.find('.quick-view-carousel'));


			/*

				#2 Add product form
				===================

			*/

			var $element = instance.group[instance.currIndex].opts.$orig;
			var form_id = $element.data('qw-form');

			instance.$refs.container.find('.quick-view-aside').append(

				// In this example, this element contains the form
				$('#' + form_id).clone(true).removeClass('hidden')
			);

		},

		beforeShow: function (instance) {

			/*
				Mark current bullet navigation link as active
			*/

			instance.$refs.container.find('.quick-view-bullets')
				.children()
				.removeClass('active')
				.eq(instance.currIndex)
				.addClass('active');

		}

	});

});
