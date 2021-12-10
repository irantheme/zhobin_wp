/**
 * Flex masonry class
 */
class FlexMasonryStyle {
  // Initialize
  constructor() {
    this.events();
  }
  // Events & run methods
  events() {
    this.flexMasonryInit();
    $(window).resize(function () {
      this.flexMasonryInit();
    });
  }
  // Flex masonry style init
  flexMasonryInit() {
    FlexMasonry.init('.flex-masonry', {
      /*
       * If `responsive` is `true`, `breakpointCols` will be used to determine
       * how many columns a grid should have at a given responsive breakpoint.
       */
      responsive: true,
      /*
       * A list of how many columns should be shown at different responsive
       * breakpoints, defined by media queries.
       */
      breakpointCols: {
        'min-width: 1500px': 3,
        'min-width: 1200px': 3,
        'min-width: 992px': 3,
        'min-width: 768px': 2,
        'min-width: 576px': 2,
        'min-width: 320px': 1,
      },
      /*
       * If `responsive` is `false`, this number of columns will always be shown,
       * no matter the width of the screen.
       */
      // numCols: 3,
    });
  }
}

export default FlexMasonryStyle;
