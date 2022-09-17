$(function($){
    $('.slider').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
        arrows: false,
        responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false, 
                centerPadding: '40px',
                slidesToShow: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                arrows: false,             
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
    });
});