<?php 
get_header(); 

// paging
$pagedtext = '';
if( $paged && $paged > 1 ){
	$pagedtext = ' <small>第'.$paged.'页</small>';
}

_moloader('mo_is_minicat', false);

$description = trim(strip_tags(category_description()));
?>

<?php if( mo_is_minicat() ){ ?>
<div class="pageheader">
	<div class="container">
		<div class="share">
			<?php _moloader('mo_share', false); mo_share('renren'); ?>
		</div>
	  	<h1><?php single_cat_title(); echo $pagedtext; ?></h1>
	  	<div class="note"><?php echo $description ? $description : '去分类设置中添加分类描述吧' ?></div>
	</div>
</div>
<?php } ?>

<section class="container">

			<?php _the_ads($name='ads_cat_01', $class='asb-cat asb-cat-01') ?>
			<?php 
				if( mo_is_minicat() ){
					echo'<div class="content-wrap"><div class="middle_line"></div>';
					while ( have_posts() ) : the_post(); 
					    echo '<div class="content-ggbox"><div class="zdgd'.get_wow_1().'">';
							if( _hui('post_plugin_date') ){
					            echo '<time><i class="fa fa-clock-o"></i>'.get_the_time('Y-m-d').'</time>';
					        }
					        echo '<div class="content-gg"><h2><a'._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title()._get_delimiter().get_bloginfo('name').'">'.get_the_title().'</a></h2>';
					        echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200,"......"); echo '</div>';
							
					    echo '</div></div>';

					endwhile; 
					echo'</div>';
					wp_reset_query();

					_moloader('mo_paging');

				}else{
					echo '<div class="catleader'.get_wow_1().'"><h1>', single_cat_title(), $pagedtext.'</h1>'.'<div class="catleader-desc">'.$description.'</div></div><div class="content-wrap">
		                      <div class="content">';
					get_template_part( 'excerpt' ); 
					_moloader('mo_paging'); echo'</div> </div>';  get_sidebar(); }
			?>

</section>

<?php get_footer(); ?>