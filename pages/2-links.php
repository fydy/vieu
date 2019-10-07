<?php 
/**
 * Template name: Links(友情链接修改版)
 * Description:   A links page
 */

get_header();

?>

<div class="container container-page">
	<?php _moloader('mo_pagemenu', false) ?>
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</header>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>

		<div class="page-links">
    		<ul>
        	<?php $default_ico = get_template_directory_uri().'/img/defaultfavicon.png'; //默认 ico 图片位置
			      $bookmarks = get_bookmarks('title_li=&categorize=0&category=13&orderby=rand'); //全部链接随机输出
        		  /*$bookmarks = get_bookmarks('title_li=&orderby=rating&order=asc'); //全部链接随机输出*/
        			//如果你要输出某个链接分类的链接，更改一下get_bookmarks参数即可
        			//如要输出链接分类ID为5的链接 title_li=&categorize=0&category=5&orderby=rand
        			if ( !empty($bookmarks) ) {
            		foreach ($bookmarks as $bookmark) {
            		echo '<li><div><img src="'. $bookmark->link_url . '/favicon.ico" onerror="javascript:this.src=\'' . $default_ico . '\'" /><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_name . '" target="_blank" >' . $bookmark->link_name . '</a><p>'. $bookmark->link_description .'</p></div></li>';
            		}
        		}
        	?>
    		</ul>
		</div>

		<?php comments_template('', true); ?>
	</div>
</div>

<?php

get_footer();