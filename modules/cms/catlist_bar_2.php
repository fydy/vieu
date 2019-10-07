<?php 
	$i=0;
	while (have_posts()&&$i<6) : the_post();
	$i++;
?>
<?php if($i==1){ ?>
    <div class="col col-left">
        <article id="post-3489" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
            <div class="entry-thumb hover-scale">
                <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
            </div>
            <div class="entry-detail">
                <h3 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="entry-meta">
                    <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                    <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                    <span class="comments-count text-muted"><i class="fa fa-comments"></i><?php echo _get_post_comments() ?></span>
                </div>
                <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,120);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
            </div>
        </article>    <?php if(_hui('bar_2_asb')){ ?><div class="bar-asb-2<?php echo get_wow_1(); ?>"><?php echo _hui('bar_2_asb'); ?></div><?php } ?>
    </div>
<?php }else{ ?>
<?php if($i==2){echo '<div class="col col-right"> ';} ?>          
	<article id="post-1524" class="post type-post status-publish format-standard<?php echo get_wow_1(); ?>">
        <div class="entry-thumb hover-scale">
            <a href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
        </div>
        <div class="entry-detail">
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="entry-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,35);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
        </div>
    </article> 
<?php } ?>
<?php endwhile;?>
<?php if($i>1) echo '</div>'; ?>