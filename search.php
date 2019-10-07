<?php 
get_header();

if( !have_posts() ){
	get_template_part( 'content-404' ); 
	get_footer();
	exit;
}
?>

<section class="container">	
<?php _the_ads($name='ads_search_01', $class='asb-search asb-search-01') ?>
			<div class="pagetitle"><h1><?php echo $s; ?> 的搜索结果</h1></div>
	<div class="content-wrap">

		<div class="content">
			
			<?php 
				get_template_part( 'excerpt' ); 
				_moloader('mo_paging');
			?>
		</div>
	</div>
	<?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>