  if($('.service-slider').length > 0 ){
    $('.service-slider').owlCarousel({
      rtl:true,
      items:2,
      margin:30,
      dots:true,
      responsiveClass:true,
      responsive:{
        0:{
          items:1
        },
        768:{
          items:2
        },
        1170:{
          items:2,
          loop:false
        }
      }
    }); 
  }

  if($('.service-provider-slider').length > 0 ){
    $('.service-provider-slider').owlCarousel({
      rtl:true,
      items:2,
      margin:30,
      dots:true,
      responsiveClass:true,
      responsive:{
        0:{
          items:1
        },
        768:{
          items:2
        },
        1170:{
          items:2,
          loop:false
        }
      }
    }); 
  }