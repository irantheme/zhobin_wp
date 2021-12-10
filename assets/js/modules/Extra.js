/**
 * Extra script features
 */
class Extra {
  // Initialize
  constructor() {
    this.events();
  }
  // Events & run methods
  events() {
    this.scrollSpy();
    this.tooltipInit();
    this.navToggle();
  }
  // Tooltip Init
  tooltipInit() {
    var tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }
  // Animation scroll spy
  scrollSpy() {
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
  // Nav toggle
  navToggle() {
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
        // Flex masonry init --------------------------------
        new FlexMasonryStyle();
      } else if (searchStatus == '0') {
        // Close search overlay
        $('#search-overlay').fadeOut();
      }
    });
  }
}

export default Extra;
