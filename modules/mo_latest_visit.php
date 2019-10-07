<?php 
$pop = $wpdb->get_results("SELECT DISTINCT ID, post_title, post_password, user_id, comment_ID, comment_post_ID, comment_author, comment_date, comment_approved,comment_author_email, comment_type,comment_author_url, SUBSTRING(comment_content,1,100) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_post_ID!='' AND comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date DESC LIMIT 6"); ?>
<section class="container<?php if(_hui('banner_style')< 2){echo' oldvist';} ?>">	
 <div class="latest-visit">
<?php 
       foreach($pop as $post) : ?>

 <div class="content-item<?php echo get_wow_1(); ?>">
        <a href="<?php echo get_permalink($post->comment_post_ID); ?>">
          <div class="item-box">
		  <div class="item-list"><span>最新访问</span><p><?php echo $post->comment_author.' 曾在'. _get_time_ago( $post->comment_date ); echo '评论：'.convert_smilies(strip_tags($post->com_excerpt)); ?></p></div>
		  
            <div class="img-area">
              <img src="<?php echo image_url($post->comment_post_ID); ?>" alt="" class="normal-img">
            </div>
            <div class="box-header">
              <p>
               <?php echo get_the_title($post->comment_post_ID); ?>
              </p>
			  <time><i class="fa fa-clock-o"></i> <?php echo get_the_time('Y-m-d', $post->comment_post_ID); ?></time>
			  <strong><i class="fa fa-eye"></i> <?php echo _get_post_views(); ?></strong>
            </div>
          </div>
        </a>
		
      </div>
 
<?php endforeach;
 ?>
 </div>
</section>	