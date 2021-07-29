jQuery(function($) {
  $(window).ready(function(){
    var selectedCat,filterClass;
    // external js: isotope.pkgd.min.js
    var container = $('#loopcontainer');

      container.isotope({
      itemSelector: '.post-artifact',
      animationEngine: 'best-available',
      transitionDuration: '0.9s',
      masonry: {
          //isFitWidth: true,
          columnWidth: container.innerWidth/4,
          gutter: 10,
      },
    });
    container.isotope( 'layout' );
  });
});
