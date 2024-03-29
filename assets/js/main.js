(function ($) {
  /* ===============================================================
  Categories adding toggle active & realign layout
=============================================================== */
  // Back to all posts
  $('#all-categories').on('click', function () {
    // Remove all active list category
    $('.content-category ul li a').removeClass('active');
    // Add active to clicked category
    $(this).addClass('active');
    $('#posts .post-holder[data-cate]').show();
    masonryPkgInit();
  });
  // Categorize and alignment posts
  $('.content-category ul li a:not(#all-categories)').on('click', function () {
    // Remove all active list category
    $('.content-category ul li a').removeClass('active');
    // Add active to clicked category
    $(this).addClass('active');
    // Remove all posts
    $('#posts .post-holder[data-cate]').hide();
    // Get current category data
    var baseData = $(this).data('cate');
    var posts = $('#posts .post-holder[data-cate]');
    // Loop from posts
    for (let i = 0; i < posts.length; i++) {
      // Split data post
      let dataPost = $(posts[i]).attr('data-cate').split(',');
      // Remove last additional index array
      dataFiltered = dataPost.filter(function (el) {
        return el != '';
      });
      // Check duplicated data and destroy
      let uniqueData = [];
      $.each(dataFiltered, function (i, el) {
        if ($.inArray(el, uniqueData) === -1) uniqueData.push(el);
      });
      // Loop from data filtered post
      for (let j = 0; j < uniqueData.length; j++) {
        // Check base data (main) with post data
        if (uniqueData[j] == baseData) {
          // Display same cate post
          $(posts[i]).show();
          break;
        }
      }
    }
    masonryPkgInit();
  });

  /* ===============================================================
  Load more post Json
=============================================================== */
  // Check remaining post for hiding button load
  function hideLoadingButton() {
    // Get current body post length
    $.getJSON(wpData.root_url + '/wp-json/json/v1/post', (result) => {
      let postCount = $('#posts .post-holder').length;
      // Get unload post length
      var postUnloadCount = 0;
      // Assign length unload post
      postUnloadCount = result.post.length;
      // Check count of current post and unload post
      if (postCount >= postUnloadCount) $('.load-more').hide();
    });
  }
  hideLoadingButton();

  // Loading remaining of posts in click load button
  $('#loading-more').on('click', function () {
    $(this).find('span i').addClass('animate-rotate');
    setTimeout(loadingPosts(), 1000);
    setTimeout(() => {
      $(this).find('span i').removeClass('animate-rotate');
    }, 1001);
    hideLoadingButton();
  });

  // Get json data posts
  function loadingPosts() {
    // Get json data with api
    $.getJSON(wpData.root_url + '/wp-json/json/v1/post', (result) => {
      // Temporary posts of result post
      let posts = result.post;
      // Get length of body posts
      let currentPostsCount = $('#posts .post-holder').length;
      // Slicing body posts from loaded posts
      posts.splice(0, currentPostsCount);
      // Divide posts to sliced posts
      posts = posts.splice(0, 6);
      // Append rest posts
      $('#posts .container .grid-masonry').append(`
          ${posts
            .map(
              (item) => `
              <div class="post-holder grid-item" data-cate="${
                item.dataCategory
              }">
                <article class="post">
                  ${(() => {
                    // Check video elements
                    if (item.postFormat == 'video' && item.video) {
                      let videoOutput = `
                      <div class="post-video">${item.video}</div>
                      `;
                      return videoOutput;
                    } else if (item.postFormat == 'gallery' && item.gallery) {
                      // Init output with essential tags and thumbnail (If has thumbnail)
                      let output = `
                        <div class="post-slider">
                          <a href="${item.permalink}" class="post-slider-link">
                          <div class="swiper gallery-swiper">
                          <div class="swiper-wrapper">
                            ${(() => {
                              if (item.imageSrc) {
                                return `<div class="swiper-slide"><img src="${item.imageSrc}" alt="تصویر اصلی"></div>`;
                              }
                            })()}`;
                      // Add gallery array src
                      for (let i = 0; i < item.gallery.length; i++) {
                        output += `
                          <div class="swiper-slide"><img src="${item.gallery[i]}" alt="گالری"></div>
                        `;
                      }
                      output += '</div>';
                      // Add arrow slider
                      output += `
                        <div class="post-image-slider-buttons">
                          <div class="post-image-next"><i class="lni lni-chevron-right"></i>
                          </div>
                          <div class="post-image-prev"><i class="lni lni-chevron-left"></i>
                          </div>
                        </div>
                      `;
                      // Add category post slider
                      output += `
                        ${(() => {
                          if (item.category) {
                            // Category holder temp
                            var cate_temp = '';
                            // Add parent tag
                            cate_temp += '<div class="post-category">';
                            // Loop from keys and append to cate temp
                            for (let i = 0; i < item.category.length; i++) {
                              let key = Object.keys(item.category[i]);
                              cate_temp += '<span>' + key + '</span>';
                            }
                            // Add ending parent tag
                            cate_temp += '</div>';
                          }
                          return cate_temp;
                        })()}
                      `;
                      // Add ending tags
                      output += `
                        </div>
                        </a>
                      `;
                      return output;
                    } else if (item.imageSrc) {
                      let output = `
                        <div class="post-image">
                        <a href="${item.permalink}" class="post-image-link">
                          <img src="${item.imageSrc}" alt="Image post">
                          ${(() => {
                            if (item.category) {
                              // Category holder temp
                              var cate_temp = '';
                              // Add parent tag
                              cate_temp += '<div class="post-category">';
                              // Loop from keys and append to cate temp
                              for (let i = 0; i < item.category.length; i++) {
                                let key = Object.keys(item.category[i]);
                                cate_temp += '<span>' + key + '</span>';
                              }
                              // Add ending parent tag
                              cate_temp += '</div>';
                            }
                            return cate_temp;
                          })()}
                        </a>
                      </div>
                      `;
                      return output;
                    } else {
                      let output = `
                          ${(() => {
                            if (item.category) {
                              // Category holder temp
                              var cate_temp = '';
                              // Add parent tag
                              cate_temp += '<div class="post-category">';
                              // Loop from keys and append to cate temp
                              for (let i = 0; i < item.category.length; i++) {
                                let key = Object.keys(item.category[i]);
                                let link = item.category[i][key];
                                cate_temp +=
                                  '<a href="' + link + '">' + key + '</a>';
                              }
                              // Add ending parent tag
                              cate_temp += '</div>';
                            }
                            return cate_temp;
                          })()}
                      `;
                      return output;
                    }
                  })()}
                  <div class="post-content">
                    <div class="post-date">
                      <span>${item.date}</span>
                    </div>
                    <div class="post-heading">
                      <h2><a href="${item.permalink}">${item.title}</a></h2>
                    </div>
                    <div class="post-text">
                      <p>${item.content}</p>
                    </div>
                  </div>
                  <div class="post-info">
                    <!-- Post author -->
                    <div class="post-author">
                      <img src="${item.authorAvatar}" alt="Author">
                      <div>
                        <cite>${item.author}</cite>
                        <span>${item.authorNickname}</span>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            `
            )
            .join('')}
        `);
      masonryPkgInit();
    });
  }

  /* ===============================================================
  Search Live Json
=============================================================== */
  // Previous search input value
  var previousSearchInputValue = '';
  // Keydown press for getting data
  $('.search-input').on('keydown', function (e) {
    var searchInputValue = $.trim($(this).val());
    keycode = e.keyCode;
    if (keycode != 8 && searchInputValue != '') {
      if (
        searchInputValue != previousSearchInputValue &&
        $.trim(searchInputValue).length > 0
      ) {
        // Spinner running!
        spinnerShow();
        setTimeout(() => {
          // Getting data search results
          getLiveSearchResult();
          previousSearchInputValue = searchInputValue;
        }, 1000);
      }
    } else {
      $('.search-results').html('');
    }
  });

  // Get json data search live
  function getLiveSearchResult() {
    // Get json data with api
    $.getJSON(
      wpData.root_url +
        '/wp-json/json/v1/search/?term=' +
        $('.search-input').val(),
      (result) => {
        $('.search-results').html(`
          ${
            result.generalInfo.length
              ? ''
              : '<div class="search-not-found">نتیجه ای برای کلمات جستجو شده یافت نشد</div>'
          }
          <div class="grid-masonry">
            <div class="grid-sizer"></div>
            ${result.generalInfo
              .map(
                (item) => `
                <div class="search-holder grid-item">
                  <div class="search-result-box">
                    <a href="${item.permalink}">
                      ${
                        item.imageSrc
                          ? '<img src="' +
                            item.imageSrc +
                            '" alt="عکس جستجو شده">'
                          : ''
                      }
                      <b>${item.title}</b>
                      <p>${item.content}</p>
                    </a>
                  </div>
                </div>
              `
              )
              .join('')}
          </div>
        `);
        // Stop spinner!
        searchIconShow();
        masonryPkgInit();
      }
    );
  }

  // Show icon search & hide spinner
  function searchIconShow() {
    $('#search-alt').show();
    $('#spinner-alt').hide();
  }
  // Show spinner & hide icon search
  function spinnerShow() {
    $('#search-alt').hide();
    $('#spinner-alt').show();
  }

  /* ===============================================================
  Swiper Gallery & Slide Init
=============================================================== */
  // Single gallery clickable init
  function gallerySingleClickable() {
    // Open single gallery overlay
    $('.single-gallery.active img').click(function () {
      var data = parseInt($(this).data('gallery'));
      $('.single-gallery-overlay').fadeIn();
      if (data) gallerySingleOverlay(data);
      else gallerySingleOverlay();
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
  gallerySingleClickable();

  // Gallery single overlay
  function gallerySingleOverlay(dataGallery = 0) {
    this.gallerySingle = new Swiper('.swiper-gallery-overlay', {
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

  // Gallery main post
  function galleryMainPosts() {
    this.galleryPost = new Swiper('.gallery-swiper', {
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
  galleryMainPosts();

  // Slider latest comments
  function sliderLatestComments() {
    this.commentSlider = new Swiper('.comments-swiper', {
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
  sliderLatestComments();

  /* ===============================================================
  Extra features
=============================================================== */
  // Initialize bootstrap tooltip
  function tooltipInit() {
    $('[data-toggle="tooltip"]').tooltip();
  }
  tooltipInit();

  // Animation scroll spy
  function scrollSpy() {
    $('a[href*="#"]:not([href="#"])').click(function () {
      // Get hash for create id
      var hash = this.hash;
      // Select element for move
      $('html, body').animate(
        {
          scrollTop: $(hash).offset().top,
        },
        1000
      );
      // Checking specific id (mouse-down-toggle)
      if (this.id == 'mouse-down-toggle') {
        // Adding active class
        $(this).addClass('active');
        // Remove active class with delay (After scrolled)
        setTimeout(function () {
          $('#mouse-down-toggle').removeClass('active');
        }, 1000);
      }
    });
  }
  scrollSpy();

  // Nav toggle
  function navToggle() {
    // Nav toggle type -----------------------------------
    $('*[id*=nav-]').click(function () {
      // Get data type of nav-
      var type = $(this).data('type');
      // Assign status of data search
      var searchStatus = $(this).data('search');
      // Check of nav- data type
      if (type == 'open') {
        // Open nav
        $('#nav-open').addClass('active');
        $('#nav-mask').fadeIn(300);
        $('#navigation').addClass('active');
      } else if (type == 'close') {
        // Close nav
        $('#nav-open').removeClass('active');
        $('#nav-mask').fadeOut(300);
        $('#navigation').removeClass('active');
      }
      // Check search status
      if (searchStatus && searchStatus == '1') {
        // Open search overlay
        $('#search-overlay').fadeIn();
        $('.search-input').val('');
        $('.search-results').html('');
        $('.search-input').focus();
      } else if (searchStatus == '0') {
        // Close search overlay
        $('#search-overlay').fadeOut();
      }
    });
  }
  navToggle();

  /* ===============================================================
  Masonry package init
=============================================================== */
  // Masonry package js init
  function masonryPkgInit() {
    // init Masonry
    var $grid = $('.grid-masonry').masonry({
      itemSelector: '.grid-item',
      columnWidth: '.grid-sizer',
      percentPosition: true,
      // gutter: 20,
      // horizontalOrder: true,
      // fitWidth: true,
      originLeft: false,
      transitionDuration: '0.5s',
      // initLayout: false,
      // disable window resize behavior
      // resize: false,
      stagger: 30,
      // containerStyle: null,
      // originTop: false,
      // stamp: '.stamp',
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function () {
      $grid.masonry('layout');
    });
    $grid.masonry('reloadItems');
    $grid.masonry('layout');
    $('#loading-more').click(() => {
      // layout Masonry after each image loads
      setTimeout(() => {
        $grid.masonry('reloadItems');
        $grid.masonry('layout');
      }, 501);
    });
  }
  masonryPkgInit();
})(jQuery);
