<?php get_header(); ?>

<section class="container">
<?php _the_ads($name='ads_tag_01', $class='asb-tag asb-tag-01') ?>
<?php echo '<div class="pagetitle"><h1>标签：', single_tag_title(), '</h1>'.$pagedtext.'</div>'; ?>
	<div class="content-wrap">
	<div class="content">
		
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>第'.$paged.'页</small>';
		}

		
		
		get_template_part( 'excerpt' );
		_moloader('mo_paging');
		?>
	</div>
	</div>
	<?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>