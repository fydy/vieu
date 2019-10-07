		<?php if( _hui('post_prevnext_s') ){ 
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        echo'<nav class="nav-reveal">
		'; 
		   if (!empty( $prev_post )):
			   echo'<a class="prev" href="'; echo get_permalink( $prev_post->ID ).'">
						<span class="icon-wrap"><i class="fa fa-angle-left"></i></span>
						<div>
							<h3>'; echo $prev_post->post_title.'<span>上一篇</span></h3>
							<img src="'; echo image_url($prev_post->ID).'" alt="';echo $next_post->post_title .'">
						</div>
					</a>'; endif;
				if (!empty( $next_post )): 
				  	echo'<a class="next" href="'; echo get_permalink( $next_post->ID ).'">
						<span class="icon-wrap"><i class="fa fa-angle-right"></i></span>
						<div>
							<h3>'; echo $next_post->post_title .'<span>下一篇</span></h3>
							<img src="'; echo image_url($next_post->ID).'"';echo $next_post->post_title .'">
						</div>
					</a>';
				  endif;
			 echo'</nav>'; } ?>	