<?php
/*
Template Name: 在线演示
*/
 $pid = $_GET['pid'];
   $values = get_post_meta($pid, 'down_demo_url', true);
     if(empty($values)){
       Header('Location:/');
     }else{$yanshi = $values;
} ?>
<!DOCTYPE html>
<html> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="演示" />
    <link rel="stylesheet" id="_bootstrap-css" href="<?php echo get_stylesheet_directory_uri() ?>/css/device.css" type="text/css" media="all">
    <title>Demo：
      <?php echo get_the_title($pid); ?>–
        <?php echo get_bloginfo( 'name') ?></title>
    <script src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript">var calcHeight = function() {
        var headerDimensions = $('#header-bar').height();
        $('#preview-frame').height($(window).height() - headerDimensions);
      }
      $(document).ready(function() {
        calcHeight();
        $('#header-bar a.close').mouseover(function() {
          $('#header-bar a.close').addClass('activated');
        }).mouseout(function() {
          $('#header-bar a.close').removeClass('activated');
        });
      });
      $(window).resize(function() {
        calcHeight();
      }).load(function() {
        calcHeight();
      });</script>
  </head>
  
  <body id="by">
    <div id="header-bar">
      <div class="close-header">
        <script type="text/javascript">document.write("<a id=\"close-button\" title=\"关闭工具条\" class=\"close\" href=\"<?php echo $yanshi; ?>\">X</a>");</script></div>
      <p class="meta-data">
        <script type="text/javascript">document.write("<a target=\"_blank\" class=\"close\" href=\"<?php echo $yanshi; ?>\">移除顶部</a>");</script>
        <a class="back" href="<?php echo get_permalink($pid); ?>">返回原文：
          <?php echo get_the_title($pid); ?></a>
        <a class="back" href="<?php echo get_bloginfo('url'); ?>">返回首页</a></p>
      <div id="switcher">
        <div class="center">
          <ul>
            <li class="device-monitor">
              <a href="javascript:">
                <div class="icon-monitor active"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-tablet"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-mobile-1"></div>
              </a>
            </li>
            <li class="device-mobile-2">
              <a href="javascript:">
                <div class="icon-mobile-2"></div>
              </a>
            </li>
            <li class="device-mobile-3">
              <a href="javascript:">
                <div class="icon-mobile-3"></div>
              </a>
            </li>
        </div>
      </div>
      <a style="background: url(<?php echo _hui('logo_src'); ?>) no-repeat; background-size: auto 30px;" class="preview-logo" href="<?php echo get_bloginfo('url'); ?>" title="<?php echo get_bloginfo('name') ?>">
        <?php echo get_bloginfo( 'name') ?></a>
    </div>
    <script type="text/javascript">var theme_list_open = false;
      $(document).ready(function() {
        function fixHeight() {
          var headerHeight = $("#switcher").height();
          $("#iframe").attr("height", $(window).height() - 84 + "px")
        }
        $(window).resize(function() {
          fixHeight()
        }).resize();
        $('.icon-monitor').addClass('active');
        $(".icon-mobile-3").click(function() {
          $("#by").css("overflow-y", "auto");
          $('#preview-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('preview-frame').addClass('mobile-width-3');
          $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
          $(this).addClass('active');
          return false
        });
        $(".icon-mobile-2").click(function() {
          $("#by").css("overflow-y", "auto");
          $('#preview-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-3').removeClass('preview-frame').addClass('mobile-width-2');
          $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
          $(this).addClass('active');
          return false
        });
        $(".icon-mobile-1").click(function() {
          $("#by").css("overflow-y", "auto");
          $('#preview-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width-2').removeClass('mobile-width-3').removeClass('preview-frame').addClass('mobile-width');
          $('.icon-tablet,.icon-mobile,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
          $(this).addClass('active');
          return false
        });
        $(".icon-tablet").click(function() {
          $("#by").css("overflow-y", "auto");
          $('#preview-frame').removeClass('full-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('mobile-width-3').removeClass('preview-frame').addClass('tablet-width');
          $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
          $(this).addClass('active');
          return false
        });
        $(".icon-monitor").click(function() {
          $("#by").css("overflow-y", "hidden");
          $('#preview-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('mobile-width-3').addClass('preview-frame');
          $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
          $(this).addClass('active');
          return false
        })
      });</script>
    <script type="text/javascript">document.write("<iframe id=\"preview-frame\" src=\"<?php echo $yanshi; ?>\" name=\"preview-frame\" frameborder=\"0\" class=\"preview-frame\" noresize=\"noresize\"></iframe>");</script></body>

</html>