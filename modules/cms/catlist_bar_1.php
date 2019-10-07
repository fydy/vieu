<?php 
	$i=0;
	while (have_posts()&&$i<5) : the_post();
	$i++;
?>
<?php if($i==1){ ?>
	        <div class="col col-full clearfix">
              <article id="post-3773" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
                    <div class="entry-thumb hover-scale">
                         <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
					</div>
                    <div class="entry-detail">
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h3>
						<p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,120);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
                        <div class="entry-meta">
                            <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                            <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                            <span class="comments-count text-muted"><i class="fa fa-comments"></i><?php echo _get_post_comments() ?></span>
                        </div>
                      
                     <?php if( _hui('post_plugin_like') ){ echo'<p class="like">';
                       echo hui_get_post_like($class='post-like');
                        echo'</p>';   }?>
                 
                    </div>
             </article>
            </div>
<?php }else{ ?> 
	         <div class="col col-small col-1_2 col-s1">
                <article id="post-3665" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
                    <div class="entry-thumb hover-scale">
                          <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
					</div>
                    <div class="entry-detail">
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h3>
						<p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,35);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
                        <div class="entry-meta">
                            <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>

                            <?php if ( comments_open()) {?>
                            <span class="comments-count text-muted"><i class="fa fa-comments"></i> 评论<?php echo get_comments_number('0', '1', '%') ?></span>
					        <?php }?>
                        </div>
                    </div>
                </article>
            </div> 
<?php } ?>
<?php endwhile;?>