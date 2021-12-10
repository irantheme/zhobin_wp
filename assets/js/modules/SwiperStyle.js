/**
 * Swiper style class
 */
class SwiperStyle {
  // Initialize
  constructor() {
    this.events();
    this.data = 0;
    this.galleryMainPost = null;
    this.gallerySingleOverlay = null;
    this.sliderLatestComments = null;
  }
  // Event & run methods
  events() {
    this.galleryInit();
    this.galleryMainPosts();
    this.sliderLatestComments();
  }
  galleryInit() {
    // Open single gallery overlay
    $('.single-gallery img').click(function () {
      this.data = parseInt($(this).data('gallery'));
      $('.single-gallery-overlay').fadeIn();
      gallerySingleOverlay(this.data);
    });
    // Close single gallery overlay with overlay clickable
    $('.single-gallery-overlay').click(function (e) {
      if (e.target == e.currentTarget) $(this).fadeOut();
    });
    // Close single gallery overlay with toggle button
    $('#close-gallery-overlay').click(function () {
      $('.single-gallery-overlay').fadeOut();
    });
  }
  // Gallery main post
  galleryMainPosts() {
    this.galleryMainPost = new Swiper('.gallery-swiper', {
      navigation: {
        nextEl: '.post-image-next',
        prevEl: '.post-image-prev',
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
  }
  // Gallery single overlay
  gallerySingleOverlay(dataGallery = 0) {
    this.gallerySingleOverlay = new Swiper('.swiper-gallery-overlay', {
      pagination: {
        el: '.swiper-pagination',
        type: 'progressbar',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      initialSlide: dataGallery,
    });
  }
  // Slider latest comments
  sliderLatestComments() {
    this.sliderLatestComments = new Swiper('.comments-swiper', {
      slidesPerView: 3,
      spaceBetween: 30,
      freeMode: true,
      // centeredSlides: true,
      // grabCursor: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        },
        // when window width is >= 480px
        575: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        // when window width is >= 640px
        767: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        991: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      },
    });
  }
}

export default SwiperStyle;
