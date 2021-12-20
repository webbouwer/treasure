<?php
/* treasure
 * htmlhead.php
 */
echo '<!DOCTYPE HTML>';
echo '<html '; language_attributes(); echo '><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
echo '<title>'.get_bloginfo( 'name' ).'</title>';
echo '<meta name="description" content="De Hoekse Schatkist - Hoek van Holland Erfgoed en objecten - Cultuur en Archief ">';
echo '<meta name="keywords" content="de hoekse, schatkist, de hoekse schatkist, chateau du lac, objecten, foto, video, gedicht, schilderij, verhaal, sculptuur, audio, pers, overige, erfgoed">';
if ( ! isset( $content_width ) ) $content_width = 360;
wp_head();
?>
<script>
jQuery(function($) {
  // on resize
  var resizeThemeId;
  $(window).resize(function() {
    clearTimeout(resizeThemeId);
    resizeThemeId = setTimeout(themeResizing, 20);
  });

  function themeResizing() {
    var srcnw = $(window).width();
    var cls = "medium";
    if (srcnw < 460) {
      cls = "small";
    } else if (srcnw > 1100) {
      cls = "large";
    }
    $('body').removeClass('medium small large');
    $('body').addClass(cls);
  }
  $(window).ready(function() {
    themeResizing();
  });
});
</script>
<?php
echo '</head>';
