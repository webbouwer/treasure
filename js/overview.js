jQuery(function($) {

  //$(window).ready(function(){
  //$(window).load(function() {
  $('body').imagesLoaded( function( instance ) {

    var container = $('#loopcontainer'),
    gutterWidth = 0,
    colWidth = container.width() / 5,
    currCat = '',
    filterlist = [];
    defaultselect = 'foto',
    filters = '.'+defaultselect;// *


    // external js: isotope.pkgd.min.js
    // setup isotope
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

    $('ul li.but-'+defaultselect).addClass('selected');

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
      }).isotope('reloadItems').isotope({ filter: filters }).isotope( 'layout' );

    }


    // recall isotope
    doneResizing();

    $('#typemenu ul li:not(#menubutton)').each( function(){
      var chk = '.'+$(this).data('type');
      if ( $( chk ).length > 1 ) {
        $(this).addClass('available');
        $(this).find('span').append( '('+( $( chk ).length - 1)+')' );
      }else{
        $(this).addClass('notavailable');
      }
    });

      $('#typemenu ul, .item-icons ul').on('click', 'li:not(.unavailable,#menubutton)', function(){

        var butclass = '.'+$(this).data('type');
        var butname = '.but-'+$(this).data('type');
        /*
        if( $(this).hasClass('selected') ){
          // https://stackoverflow.com/questions/3596089/how-to-remove-specific-value-from-array-using-jquery
          filterlist.splice( $.inArray( butclass, filterlist ), 1 );
          $(this).removeClass('selected');
        }else{
          filterlist.push( butclass );
          $(this).addClass('selected');
        }
        if( filterlist.length > 0 ){
          filters = filterlist.join("");
        }else{
          filters = '*';
        }
        */
        $('#typemenu ul li, .item-icons ul li').removeClass('selected');
        $(this).addClass('selected');
        $('li'+butname).addClass('selected');
        filters = butclass;
        console.log(filters);
        container.isotope({ filter: filters }).isotope( 'layout' );

      });



  });

});
