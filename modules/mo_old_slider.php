<?php
/**
 * [mo_slider description]
 * @param  string $id   [description]
 * @return html         [description]
 */
function mo_slider( $id='slider' ){
	$indicators = '';
	$inner = '';

	$sort = _hui($id.'_sort') ? _hui($id.'_sort') : '1 2 3 4 5';
    $sort = array_unique(explode(' ', trim($sort)));
    $i = 0;
    foreach ($sort as $key => $value) {
        if( _hui($id.'_src_'.$value) && _hui($id.'_href_'.$value) && _hui($id.'_title_'.$value) ){
            $indicators .= '<li data-target="#'.$id.'" data-slide-to="'.$i.'"'.(!$i?' class="active"':'').'></li>';
            $inner .= '<div class="item'.(!$i?' active':'').'"  style="background-image: url('._hui($id.'_src_'.$value).');">
				<div class="swiper-post">
                        <h3>'._hui($id.'_title_'.$value).'</h3>
                        <p class="description">
                         '._hui($id.'_text_'.$value).'
                    </div>
			</div>';
            $i++;
        }
    }
	echo '<section class="container"><div class="content-wrap"><div class="oldtbcontent"><a'.( _hui($id.'_blank_'.$value) ? ' target="_blank"' : '' ).' href="'._hui($id.'_href_'.$value).'"><div id="'.$id.'" class="oldbanner carousel slide" data-ride="carousel"><ol class="carousel-indicators">'.$indicators.'</ol><div class="carousel-inner" role="listbox">'.$inner.'</div><a class="left carousel-control" href="#'.$id.'" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a><a class="right carousel-control" href="#'.$id.'" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a></div></a></div></div>';
?>
<div class="oldtbsidebar">
<section class="sticky-box">
<h2><?php echo _hui('index_rem_h3'); ?></h2>
<ul>
<?php if(function_exists('jingdian_comm_posts')) echo jingdian_comm_posts( _hui('index_rem_date'),5); ?>
	  </ul>
    </section>
	</div></section>
	<?php } ?>