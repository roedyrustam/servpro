/*
Author       : Dreamguys
Template Name: ServPro - Bootstrap Template
Version      : 1.1
*/

(function($) {
    "use strict";

    // Sidebar
	
	if($(window).width() <= 991){
	var Sidemenu = function() {
		this.$menuItem = $('.main-nav a');
	};
	
	function init() {
		var $this = Sidemenu;
		$('.main-nav a').on('click', function(e) {
			if($(this).parent().hasClass('has-submenu')) {
				e.preventDefault();
			}
			if(!$(this).hasClass('submenu')) {
				$('ul', $(this).parents('ul:first')).slideUp(350);
				$('a', $(this).parents('ul:first')).removeClass('submenu');
				$(this).next('ul').slideDown(350);
				$(this).addClass('submenu');
			} else if($(this).hasClass('submenu')) {
				$(this).removeClass('submenu');
				$(this).next('ul').slideUp(350);
			}
		});
	}

	// Sidebar Initiate
	init();
	}

	// Mobile menu sidebar overlay
	
	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function() {
		$('main-wrapper').toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		return false;
	});
	$(document).on('click', '.sidebar-overlay', function() {
		$('html').removeClass('menu-opened');
		$(this).removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
	});
	
	$(document).on('click', '#menu_close', function() {
		$('html').removeClass('menu-opened');
		$('.sidebar-overlay').removeClass('opened');
		$('main-wrapper').removeClass('slide-nav');
	});
	

    //Service Categories Slider
    if($('.service-categories .swiper-container').length > 0) {
	    var swiper = new Swiper(".service-categories .swiper-container", {
	        slidesPerView: 4,
	        spaceBetween: 30,
	        speed: 1500,
	        loop: true,
	        navigation: {
          		nextEl: ".service-categories .swiper-button-next",
          		prevEl: ".service-categories .swiper-button-prev",
        	},
        	breakpoints: {
	          	1: {
	            	slidesPerView: 1,
	          	},
	          	768: {
	            slidesPerView: 3,
	          	},
	          	1024: {
	            	slidesPerView: 3,
	          	},
	          	1199: {
	            	slidesPerView: 4,
	          	},
        	},
	    });
	}

	//Technicians Slider
    if($('.technicians-section .swiper-container').length > 0) {
	    var swiper = new Swiper(".technicians-section .swiper-container", {
	        slidesPerView: 2,
	        spaceBetween: 40,
	        speed: 1500,
	        loop: true,
	        navigation: {
          		nextEl: ".technicians-section .swiper-button-next",
          		prevEl: ".technicians-section .swiper-button-prev",
        	},
        	breakpoints: {
	          	1: {
	            	slidesPerView: 1,
	          	},
	          	1024: {
	            	slidesPerView: 2,
	          	},
        	},
	    });
	}

	//Servide Details Slider
	if($('.service-details-section .mySwiper').length > 0) {
		var swiper = new Swiper(".service-details-section .mySwiper", {
	        spaceBetween: 10,
	        slidesPerView: 'auto',
	        freeMode: true,
	        watchSlidesVisibility: true,
	        watchSlidesProgress: true,
	      });
	}
	if($('.service-details-section .swiperthumb').length > 0) {
	      var swiper2 = new Swiper(".service-details-section .swiperthumb", {
	        spaceBetween: 10,
	        thumbs: {
	          	swiper: swiper,
	        },
	    });
  	}

  	//Advance Click Search
  	$(document).on('click', '.advance-search-btn', function(e) {
  		e.preventDefault();
  		$('.advance-search-col').slideToggle();
  	});
  	$(document).on('click', '.advance-btn-col #search_list', function(e) {
  		e.preventDefault();
  		$('.advance-search-col').slideUp();
  	});
  	// Select 2
	

  	//Radio Button Cheked Add Class
  	$('.time-slots-list input[type=radio]').on('click',function(){
        $('.time-slots-list input[type=radio]:not(:checked)').parent().parent().removeClass("active");
        $('.time-slots-list input[type=radio]:checked').parent().parent().addClass("active");
    });  


})(jQuery);

//Image Upload Preview	
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#avatarInput").on('change',function(){
    readURL(this);
});