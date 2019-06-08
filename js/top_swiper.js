'use strict';
{
  let mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    slidesPerView: 2,
    centeredSlides : true,
    loop: true,
    autoHeight: false,
    roundLengths: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    // breakpoints: {
    //   767: {
    //     slidesPerView: 1,
    //     spaceBetween: 0,
    //   },
    // },
    grabCursor: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
  });
}