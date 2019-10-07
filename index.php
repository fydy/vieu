<?php 
	get_header(); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<?php       $fd_st= _hui('banner_style');
			if( $paged==1 && _hui('focusslide_s') ){ 
			
			if	( $fd_st==2 ){_moloader('mo_slider', false);mo_slider('focusslide');
			}
			if	( $fd_st==3 ){_moloader('mo_zs_slider', false);
			mo_slider('focusslide');
			}
			
			} 
			
			if	( $fd_st==1 ){
				echo '<style type="text/css">.header{background-color: transparent;}</style>';
			}
			
			if($paged==1){echo '<style type="text/css">.header{background-color: transparent;}@media (max-width: 720px){.focusslide_bottom{margin-bottom: 10px;}}</style>';}elseif($paged>1){
				echo '<style type="text/css">body {padding-top: 95px;}@media (max-width: 720px){body {padding-top: 60px;}}</style>';
			} ?>
			<?php if( $paged < 2 && $fd_st > 1) {  echo'<div class="'.get_wow_1().'">';if( _hui('index_tool_s') ){ echo _hui ('index_tool');} echo'</div>';} ?>
			<?php  if	( $fd_st==3 || $fd_st==2 ){ echo'<div class="focusslide_bottom"></div>';} ?>
			
<section class="container">		
 <?php if( $paged==1 && $fd_st==1 ){ echo'<div class="slibottom"></div>'; } ?>
	<div class="content-wrap">
	<?php      
			if( $paged==1 && _hui('focusslide_s') ){ 
			
			if	( $fd_st==1 ){_moloader('mo_old_slider', false);
			mo_slider('focusslide');
			}
			
			} ?>
			
	<div class="content">
	
		<?php 
			$pagedtext = ''; 
			if( $paged > 1 ){
				$pagedtext = ' <small>第'.$paged.'页</small>';
			}
		?>
		<?php  
			if( _hui('minicat_home_s') ){
				_moloader('mo_minicat');
			}
		?>
		<?php  echo get_template_part( 'include/modules/mo_page' ); ?>
		

        <?php       echo _the_ads($name='ads_index_01', $class='asb-index asb-index-01') ;
              		$thelayout = the_layout(); 
				if(_hui('index_cms_new') && $thelayout == 'index-cms' || $thelayout == 'index-card' || $thelayout == 'index-blog'){ echo'<div class="lead-title'.get_wow_1().'">
			<h3>'; 
				echo _hui('index_list_title') ? _hui('index_list_title') : '最新发布';
			    echo $pagedtext;
			echo'</h3>';
			if( _hui('index_list_title_r') ){
					echo '<div class="more">'._hui('index_list_title_r').'</div>';
				} 
		echo'</div>'; }?>
			
			
   <?php 
			$pagenums = get_option( 'posts_per_page', 10 );
			$offsetnums = 0;
			$stickyout = 0;
			$sticky_ids = get_option('sticky_posts');
			if( _hui('home_sticky_s') && in_array(_hui('home_sticky_n'), array('1','2','3','4','5')) && $pagenums>_hui('home_sticky_n') && count($sticky_ids)>0 ){
				if( $paged <= 1 ){
					$pagenums -= count($sticky_ids);
					rsort( $sticky_ids );
					$args = array(
						'post__in'            => $sticky_ids,
						'showposts'           => _hui('home_sticky_n'),
						'ignore_sticky_posts' => 1
					);
					query_posts($args);
					get_template_part( 'excerpt' );
					wp_reset_query();
				}else{
					$offsetnums = _hui('home_sticky_n');
				}
				$stickyout = get_option('sticky_posts');
			}


			$args = array(
				'post__not_in'        => array(),
				'ignore_sticky_posts' => 1,
				'showposts'           => $pagenums,
				'paged'               => $paged
			);
			if( $offsetnums ){
				$args['offset'] = $pagenums*($paged-1) - $offsetnums;
			}
			if( _hui('notinhome') ){
				$pool = array();
				foreach (_hui('notinhome') as $key => $value) {
					if( $value ) $pool[] = $key;
				}
				if( $pool ) $args['cat'] = '-'.implode($pool, ',-');
			}
			if( _hui('notinhome_post') ){
				$pool = _hui('notinhome_post');
				$args['post__not_in'] = explode("\n", $pool);
			}
			if( $stickyout ){
				$args['post__not_in'] = array_merge($stickyout, $args['post__not_in']);
			}
			
			
			if($thelayout == 'index-cms'){
				if(_hui('index_cms_new')){
			query_posts($args);
			get_template_part( 'excerpt' ); 
			wp_reset_query();
					} 
					get_template_part( 'include/modules/mo_cms' ); 
		 }
		 else
			 
		 if($thelayout == 'index-card'){
			 get_template_part( 'include/modules/mo_card' );
		       }
			   else
			   {  
		         query_posts($args);
		        get_template_part( 'excerpt' );
				_moloader('mo_paging');
				 wp_reset_query();
				   } 
		?>
		        <?php _the_ads($name='ads_index_02', $class='asb-index asb-index-02') ?>
	</div>
	</div>
	<?php get_sidebar(); ?>
</section>
<?php get_footer();  