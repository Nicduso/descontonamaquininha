var swiper = new Swiper(".swiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    centeredSlides: true,
    loop: true,
    grapCursor: true,

    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    breakpoints: {
        // when window width is >= 640px
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        // when window width is >= 960px
        960: {
                slidesPerView: 3,
                spaceBetween: 10,
        },
        // when window width is >= 1250px
        1250: {
          slidesPerView: 4,
          spaceBetween: 10,
        }
      }

  });