<?php 
	$i=0;
	while (have_posts()&&$i<9) : the_post();
	$r = fmod($i,3)+1;$i++;
?>
<?php if($i<4){ ?>
<div class="col col-large">
    <article class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
            <div class="entry-thumb hover-scale">
                <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
            </div>
            <div class="entry-detail">
                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="entry-meta">
                    <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                    <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                  
                </div>
                <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,120);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
            </div>
    </article>
</div>
<?php }else{ ?>
<div class="col col-small">
<article class=" post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
	<div class="entry-thumb hover-scale">
        <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
    </div>
	<div class="entry-detail">
		<h3>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h3>
		 <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,30);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
	</div>
</div>
</article>
<?php } ?>
<?php endwhile;?>