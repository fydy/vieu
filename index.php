<?php 
	get_header(); 
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<?php       $fd_st= _hui('banner_style');
			if( $paged==1 && _hui('focusslide_s') ){ 
			
			if	( $fd_st==1 ){_moloader('mo_old_slider', false);
			}elseif	( $fd_st==2 ){_moloader('mo_slider', false);
			}elseif	( $fd_st==3 ){_moloader('mo_zs_slider', false);}
			mo_slider('focusslide');
			} ?>
			<?php  if	( $fd_st==3 || $fd_st==2 ){ echo'<div class="focusslide_bottom"></div>';}
			if(_hui('latest_visit_s') && $fd_st==2 || _hui('latest_visit_s') && $fd_st==3 ){ echo get_template_part( 'modules/mo_latest_visit' ); }elseif(_hui('latest_visit_s') && $fd_st==1){ echo get_template_part( 'modules/mo_latest_suiji' ); } ?>
			
<section class="container">		
	<div class="content-wrap">
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
		<?php $banner_style= _hui('banner_style');  if( _hui('index_page_s') && $banner_style==2 || _hui('index_page_s') && $banner_style==3) { echo get_template_part( 'modules/mo_page' );} ?>
		<?php if( $paged < 2 ) {  echo'<div class="'.get_wow_1().'">';if( _hui('index_tool_s') ){ echo _hui ('index_tool');} echo'</div>';} ?>

        <?php       	$thelayout = the_layout(); 
				if(_hui('index_cms_new') && $thelayout == 'index-cms' || $thelayout == 'index-card' || $thelayout == 'index-blog'){ echo'<div class="lead-title'.get_wow_1().'">
			<h3>'; 
				echo _hui('index_list_title') ? _hui('index_list_title') : '最新发布';
			    echo $pagedtext;
			echo'</h3>';
			if( _hui('index_list_title_r') ){
					echo '<div class="more">'._hui('index_list_title_r').'</div>';
				} 
		echo'</div>'; }
       if($thelayout == 'index-cms'){if(_hui('index_cms_new')){$posts = query_posts($query_string . '&orderby=date&showposts='._hui('index_cms_new_list').'');get_template_part( 'excerpt' );} get_template_part( 'modules/mo_cms' ); 
		 }else if($thelayout == 'index-card'){get_template_part( 'modules/mo_card' );
		       }else{get_template_part( 'excerpt' );_moloader('mo_paging');} 
		        _the_ads($name='ads_index_02', $class='asb-index asb-index-02') ?>
	</div>
	</div>
	<?php get_sidebar(); ?>
</section>

<?php get_footer();  