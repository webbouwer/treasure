jQuery(function($) {

  //$(window).ready(function(){
  //$(window).load(function() {

  $('body').imagesLoaded( function( instance ) {

    var container = $('#loopcontainer'),
    gutterWidth = 0,
    colWidth = container.width() / 7,
    currCat = '',

    defaultselect = 'foto',
    filters = '.'+defaultselect,
    filterlist = Array(filters);// *


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

    //$('ul li.but-'+defaultselect).addClass('selected');
    $('#typemenu ul li.but-'+defaultselect).addClass('selected');


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
      colWidth = w / 7;

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
        //$(this).find('span').append( '('+( $( chk ).length - 1)+')' );
      }else{
        $(this).addClass('notavailable');
      }
    });


    $('#typemenu ul').on('click', 'li.available', function(){

      var type = $(this).data('type');
      var butclass = '.'+type;
      var butname = '.but-'+type;

      if( $(this).data('type') != 'foto' && $.inArray( butclass, filterlist ) < 0){ // remove default foto
        if( $.inArray( '.foto', filterlist ) >= 0){
          filterlist.splice( $.inArray( '.foto', filterlist ), 1 );
          $('#typemenu ul li.but-foto').removeClass('selected');
        }
      }

      if( $.inArray( butclass, filterlist ) >= 0){
        filterlist.splice( $.inArray( butclass, filterlist ), 1 );
        $(this).removeClass('selected');
      }else{
        filterlist.push(butclass);
        $(this).addClass('selected');
      }

      if(filterlist.length < 1){

        filters = '.'+defaultselect,
        filterlist = Array(filters);
        $('#typemenu ul li.but-'+defaultselect).addClass('selected');

      }else{
        filters = filterlist.join(","); // = or/or .. and/and :: filterlist.join(",");
      }

      console.log(filters);
      container.isotope({ filter: filters }).isotope( 'layout' );

    });



    $(document).on( 'click', '.post-artifact .overlay, .entry-title a,.item-icons ul li', function( event ) {

        // ajax request
        event.preventDefault();

        var pid = $(this).parent().closest('.post-artifact').data('id');

        var mtype = 'foto';
        if( $(this).hasClass('icon-button') ){
          mtype = $(this).data('type');
        }

            var data = {
                action: 'artifact_view',
                id: pid
            };

            $.getJSON( artifact_view_data.ajaxurl, data, function( json ) {
                if ( json.success ) {
                    var p = json.data.postdata;
                    var html = '<div class="popcontainer">'
                    +'<div class="mediabox"><img src="'+p.image+'" class="wp-post-image" alt="" /></div>'
                    +'<div class="contentbox"><div class="column">'
                    +'<h2>'+p.title+'</h2>'
                    +'<div class="text">'+p.excerpt+'</div>'
                    +'</div>';

                    var bundle = json.data.postmedia;

                    $('#typemenu ul li:not(#menubutton)').each( function( c, el){
                      var countmedia = 0;
                      html += '<div class="column">';

                      html += $(el).find('span').text();
                      $.each(bundle, function(i, media) {
                          if( media.type_slug === $(el).data('type') ){
                            countmedia++;
                            //html += media.title;
                          }
                      });

                      html += '('+countmedia+')';
                      html += '</div>';

                    });
                    html += '</div>';

                    activeOverlay( html );
                    //alert( JSON.stringify(json.data) );
                } else {
                    //alert( json.data.message );
                }
            } );

    });

    /*
    $(document).mouseup(function(e){

      if( $('#overlaycontainer').length > 0 ){
        var container = $("#overlaycontainer .outermargin");
        // If the target of the click isn't the container
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $('#overlaycontainer').removeClass('intro');
            $('#overlaycontainer').fadeOut(300, function() { $(this).remove(); });
            $('#loopcontainer').fadeIn(200);
        }
      }
      if( $('#infoboxcontainer').length > 0 ){

        if( $('#menubutton').hasClass('selected') ){
          $('#menubutton').removeClass('selected');
        }
        var container = $("#infoboxcontainer .outermargin");
        // If the target of the click isn't the container
        if(!container.is(e.target) && container.has(e.target).length === 0){
            $('#infoboxcontainer').fadeOut(300, function() { $(this).remove(); });
            $('#loopcontainer').fadeIn(200);
        }
      }

    });
    */

    function activeOverlay( content ){
      if( $('#infoboxcontainer').length > 0 ){
        $('#infoboxcontainer').fadeOut(300, function() { $(this).remove(); });
      }
      if( $('#overlaycontainer').length < 1 )
      {
        $('<div id="overlaycontainer"><div class="closeoverlay"></div><div class="outermargin"></div></div>').hide().appendTo($('#viewcontainer'));
      }
      $('#overlaycontainer .outermargin').html(content);

      $('#overlaycontainer').fadeIn(200);
      $('#loopcontainer').fadeOut(300);
    }

    $(document).on( 'click', '#menubutton', function( event ) {
      var menu = $('#mainmenu').clone();
      activeInfobox( menu );
      $(this).addClass('selected');
    });

    function activeInfobox( content ){
      if( $('#overlaycontainer').length > 0 ){
        $('#overlaycontainer').fadeOut(300, function() { $(this).remove(); });
      }
      if( $('#infoboxcontainer').length < 1 )
      {
        $('<div id="infoboxcontainer"><div class="closeinfobox"></div><div class="outermargin"></div></div>').hide().appendTo($('#viewcontainer'));
      }
      $('#infoboxcontainer .outermargin').html(content);

      $('#infoboxcontainer').fadeIn(200);
      $('#loopcontainer').fadeOut(300);
    }

    $(document).on( 'click', '.closeoverlay', function( event ) {
      //var container = $("#overlaycontainer .outermargin");
      // If the target of the click isn't the container
      //if(!container.is(e.target) && container.has(e.target).length === 0){
          $('#overlaycontainer').removeClass('intro');
          $('#overlaycontainer').fadeOut(300, function() { $(this).remove(); });
          $('#loopcontainer').fadeIn(200);
      //}
    });

    $(document).on( 'click', '.closeinfobox,#menubutton.selected', function( event ) {
      var container = $("#overlaycontainer .outermargin");
      if( $('#menubutton').hasClass('selected') ){
        $('#menubutton').removeClass('selected');
      }
      //var container = $("#infoboxcontainer .outermargin");
      // If the target of the click isn't the container
      //if(!container.is(e.target) && container.has(e.target).length === 0){
          $('#infoboxcontainer').fadeOut(300, function() { $(this).remove(); });
          $('#loopcontainer').fadeIn(200);
      //}
    });


  });

});
