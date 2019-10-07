<?php 
	$i=0;
	while (have_posts()&&$i<8) : the_post();
	$r = fmod($i,2)+1;$i++;
	if($r==1)$cls='left';else $cls='right';
?>
<div class="col col-<?php echo $cls; ?>">
	<article id="post-1524" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
        <div class="entry-thumb hover-scale">
            <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
        </div>
        <div class="entry-detail">
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,30);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
        </div>
    </article> 
</div>
<?php endwhile;?>
