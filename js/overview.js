jQuery(function($) {


  $(window).ready(function(){
    /*var logobox = $('<div class="post-artifact logobox"><div class="innerpadding">'
    +'<img class="wp-post-image" src="https://webdesigndenhaag.net/lab/project/treasure/wp-content/uploads/2021/07/dehoekseschatkist_logo_rgb.jpg" />'
    + '</div></div>');
    */

    var container = $('#loopcontainer'),
    gutterWidth = 0,
    colWidth = container.width() / 5,
    currCat = '',
    filters = '';

    // external js: isotope.pkgd.min.js
    //container.prepend(logobox);

    container.isotope({
      itemSelector: '.post-artifact',

      animationEngine: 'best-available',
      transitionDuration: '0.9s',
      masonry: {
          //isFitWidth: true,
          columnWidth: colWidth,
          gutter: gutterWidth,
      },

    });


    /* on resize */


    var resizeId;
    $(window).resize(function() {
      clearTimeout(resizeId);
      resizeId = setTimeout(doneResizing, 20);
    });

    function doneResizing() {
      setColumnWidth();
    }

    function setColumnWidth() {
      var w = container.width();
      /* check width for small screens .. */
      colWidth = w / 5;

      container.isotope({
        masonry: {
          columnWidth: colWidth,
          gutter: gutterWidth,
        }
      });

    }

    setTimeout(doneResizing, 80);

      $('#typemenu ul').on('click', 'li', function(){
        //alert( $(this).data('type') );
        filters = '.'+$(this).data('type');
        container.isotope({ filter: filters }).isotope( 'layout' );
      });

  });

});
