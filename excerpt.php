<?php
/**
 * Used for index/archive/search/author/catgory/tag.
 *
 */


$ii = 0;
while ( have_posts() ) : the_post(); 

    $_thumb = _get_post_thumbnail();

    $_excerpt_text = '';
    if( _hui('list_type')=='text' || (_hui('list_type') == 'thumb_if_has' && strstr($_thumb, 'data-thumb="default"')) ){
        $_excerpt_text .= ' excerpt-text';
    }
    if( _hui('home_sticky_s') && is_sticky() ){
        $_excerpt_text .= ' excerpt-sticky';
    }

    $ii++;
    echo '<article class="excerpt excerpt-'.$ii.$_excerpt_text,get_wow_1().'">';

        if( _hui('list_type') == 'thumb' ){
            echo '<a'._post_target_blank().' class="focus" href="'.get_permalink().'">'.$_thumb.'</a>';
        }else if( _hui('list_type') == 'thumb_if_has' && !strstr($_thumb, 'data-thumb="default"') ){
            echo '<a'._post_target_blank().' class="focus" href="'.get_permalink().'">'.$_thumb.'</a>';
        }
        echo'<div class="excerpt-post">';
        echo '<header class="'.get_wow_4().'">';
				if( _hui('home_sticky_s') && is_sticky() ){
                echo '<div class="btn btn-danger btn-xs m-zd">置顶</div>';
            }
            if( _hui('post_plugin_cat') && !is_category() ) {
                $category = get_the_category();
                if($category[0]){
                    echo '<a class="btn btn-primary btn-xs cat" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'<i></i></a> ';
                }
            };
            echo '<h2><a'._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title().get_the_subtitle(false)._get_delimiter().get_bloginfo('name').'">'.get_the_title().get_the_subtitle().'</a></h2>';
        echo '</header>';echo '<p class="note'.get_wow_4().'">'._get_excerpt().'</p>';

        echo '<p class="meta">';

        if( _hui('post_plugin_date') ){
            echo '<time><i class="fa fa-clock-o"></i>'.get_the_time('Y-m-d').'</time>';
        }

        if( _hui('post_plugin_author') ){
            $author = get_the_author();
            if( _hui('author_link') ){
                $author = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.$author.'</a>';
            }
            echo '<span class="author">'._get_the_avatar(get_the_author_meta('ID'), get_the_author_meta('email')), $author.'</span>';
        }

        if( _hui('post_plugin_view') ){
            echo '<span class="pv"><i class="fa fa-eye"></i>'._get_post_views().'</span>';
        }
        
        if ( comments_open() && _hui('post_plugin_comm') ) {
            echo '<a class="pc" href="'.get_comments_link().'"><i class="fa fa-comments-o"></i>评论('.get_comments_number('0', '1', '%').')</a>';
        }
		echo'<span class="time"><i class="fa fa-clock-o"></i>'.get_the_time('Y-m-d').'</span>';
        echo '</p>';
		if( _hui('home_sticky_s') && is_sticky() ){
                echo '<div class="zd"><i class="fa fa-zhidin"></i></div>';
            }
			echo '<p class="like">';
        if( _hui('post_plugin_like') ){
            echo hui_get_post_like($class='post-like btn btn-primary');
        }

        echo '</p>';
        
        if( _hui('post_link_excerpt_s') ) _moloader('mo_post_link');

    echo '</div></article>';

endwhile; 


wp_reset_query();