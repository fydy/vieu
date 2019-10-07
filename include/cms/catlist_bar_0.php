
<div class="cms-cat cms-cat-s0">
<?php 
	$i=0;
	while (have_posts()&&$i<9) : the_post();
	$r = fmod($i,3)+1;$i++;
?>
<?php if($i<2){ ?>
    <div class="row-up">
        <article id="post-3830" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
		    <div class="entry-thumb hover-scale">
              <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
            </div>
            <div class="entry-detail">
             <h3 class="entry-title">
                <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
             </h3>
             <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,35);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
            </div>
        </article>
    </div>
<?php }else{ ?>
    <div class="row-small">
        <article id="post-3830" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
            <div class="entry-detail">
                <h3 class="entry-title"><strong>[<?php echo get_the_time('Y-m-d'); ?>]</strong>
                    <i class=""></i>
                    <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h3>
            </div>
        </article>
    </div>
<?php } ?>
<?php endwhile;?>
</div>
