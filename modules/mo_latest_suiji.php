<section class="container oldvist">	
 <div class="latest-visit">
	 <?php  global $post;
       $rand_posts = get_posts("numberposts=6&orderby=rand");
        foreach( $rand_posts as $post ) : ?>
	     <div class="content-item<?php echo get_wow_1(); ?>">
          <a href="<?php echo get_permalink(); ?>">
          <div class="item-box">
		  <div class="item-list"><span>随机推荐</span><p><?php if(has_excerpt())  echo wp_trim_words( get_the_excerpt(), 25,' .....' );
             else echo mb_strimwidth(strip_tags($post->post_content),0,60,' .....'); ?></p></div>
            <div class="img-area">
              <?php echo _get_post_thumbnail(); ?>
            </div>
            <div class="box-header">
              <p>
               <?php echo get_the_title(); ?>
              </p>
			  <time><i class="fa fa-clock-o"></i> <?php echo get_the_time('m-d'); ?></time>
			  <strong><i class="fa fa-eye"></i> <?php echo _get_post_views(); ?></strong>
            </div>
          </div>
        </a>		
      </div>
    <?php endforeach; ?>
 </div>
</section>	
