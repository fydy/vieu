 <?php if(   _hui('index_page_s') && $paged < 2 ) { 
         echo'<section class="hot_posts';echo get_wow_1();echo'"><div class="suiji">
           <h3>'._hui('index_suiji_h3').'</h3>
              <ul class="layout_ul">';
				           $args = array('numberposts' => _hui('index_suiji_item') , 'orderby' => 'rand', 'post_status' => 'publish');
                            $rand_posts = get_posts($args);
                            foreach ($rand_posts as $post): 
							
							echo'<li class="layout_li"><strong>['.get_the_time('m-d').']</strong><a href="'.get_permalink().'" title="'.get_the_title().'">';
							if (_hui('latest_visit_st') == 1){
							echo'<span>'._hui('index_suiji_text').'</span>';}
							elseif (_hui('latest_visit_st') == 2){echo _get_post_thumbnail();}
							elseif (_hui('latest_visit_st') == 3){}
							echo get_the_title().'</a></li>';
     					  endforeach; 
			echo'</ul>
			</div>';?>
	<?php echo'<div class="hots">	
              <h3>'._hui('index_rem_h3').'</h3>	
			<ul class="layout_ul">';
          if(function_exists('most_comm_posts')) most_comm_posts( _hui('index_rem_date'), _hui('index_rem_item')); 
     echo'</ul>
             </div>
 </section>'; } ?>
 