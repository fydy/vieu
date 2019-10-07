<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<link rel="dns-prefetch" href="//apps.bdimg.com">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-title" content="<?php echo get_bloginfo('name') ?>">
<meta http-equiv="Cache-Control" content="no-siteapp">
<title><?php echo _title(); ?></title>
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php echo _hui('ico_src'); ?>">
<!--[if lt IE 9]><script src="<?php echo get_stylesheet_directory_uri() ?>/js/libs/html5.min.js"></script><![endif]-->
<?php tb_xzh_head_var() ?>
</head>
<body <?php body_class(_bodyclass()); ?>>
<?php echo tb_xzh_render_head();
$i= _hui('banner_style');
echo'<header class="';if( $i>1){echo'header">';}else{echo'oldtb">';echo'<style type="text/css">.usertitle{margin-top: 66px;}.container-page{margin-top: 81px;}@media (max-width: 720px){.container-page {margin-top: 0px;}.usertitle{ margin-top: 0px;}</style>';}?>
<section class="container">
		<?php echo _the_logo();   ?>	
        <?php _moloader('mo_navbar', false);?>        
                  <div class="m-navbar-start"><i class="fa fa-bars m-icon-nav"></i></div>
				<div class="search-i"><a href="javascript:;" class="search-show active"><i class="fa fa-search"></i></a></div>
                 <div class="site-search">
	
		<?php  
			if( _hui('search_baidu') && _hui('search_baidu_code') ){
				echo '<form class="site-search-form"><input id="bdcsMain" class="search-input" type="text" placeholder="输入关键字"><button class="search-btn" type="submit"><i class="fa fa-search"></i></button></form>';
				echo _hui('search_baidu_code');
			}else{
				echo '
            <div class="sb-search">
                <form action="'.esc_url( home_url( '/' ) ).'">
                    <input class="sb-search-input" placeholder="输入关键字 Enter键搜索..."  type="text"  name="s" type="text" value="'.htmlspecialchars($s).'">
                  
                </form>
            </div>';
			}
		?>

</div>
</section>
</header>