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
		if(_hui($id.'_button_'.$value) && _hui($id.'_href_'.$value)){	
		$button_one = '<a'.( _hui($id.'_blank_'.$value) ? ' target="_blank"' : '' ).' href="'._hui($id.'_href_'.$value).'" class="btn btn-'._hui($id.'_color_'.$value).'">'._hui($id.'_button_'.$value).'</a>';}
		else{$button_one ='';}
		if(_hui($id.'_button_two_'.$value) && _hui($id.'_href_two_'.$value)){
		$button_two = '<a'.( _hui($id.'_blank_two_'.$value) ? ' target="_blank"' : '' ).' href="'._hui($id.'_href_two_'.$value).'" class="btn btn-'._hui($id.'_color_two_'.$value).'">'._hui($id.'_button_two_'.$value).'</a>';}
		else{$button_two ='';}
		if( _hui($id.'_src_'.$value) && _hui($id.'_href_'.$value) && _hui($id.'_title_'.$value) ){
		if(_hui($id.'_zsstyle_'.$value)){
			$zs_style =  _hui($id.'_zsstyle_'.$value);
			if($zs_style==1){
			$zsst=' intleft wow fadeInLeft animated';
			$zsimg=' imgleft wow fadeInRight animated';}
			elseif($zs_style==2){
			$zsst=' intright wow fadeInRight animated';
			$zsimg=' imgright wow fadeInLeft animated';}
		}
            $indicators .= '<li data-target="#'.$id.'" data-slide-to="'.$i.'"'.(!$i?' class="active"':'').'></li>';
            $inner .= '<div class="item'.(!$i?' active':'').'"  style="background-image: url('._hui($id.'_src_'.$value).');">
			<div class="cd-main-content">
			<div class="cd-product-intro'.$zsst.'">
			<h2>'._hui($id.'_title_'.$value).'</h2>
			'._hui($id.'_text_'.$value).'
			<div class="button">
			'.$button_one.'
			'.$button_two.'
			</div>
			</div>
			<div class="cd-image-container'.$zsimg.'">
			<div class="img" style="background-image: url('._hui($id.'_src_zhanshi_'.$value).');"></div>
			</div>
			</div>
			</div>';
            $i++;
        }
    }
	echo '<div id="'.$id.'" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators">'.$indicators.'</ol><div class="carousel-inner" role="listbox">'.$inner.'</div><a class="left carousel-control" href="#'.$id.'" role="button" data-slide="prev"><i class="fa fa-angle-double-left"></i></a><a class="right carousel-control" href="#'.$id.'" role="button" data-slide="next"><i class="fa fa-angle-double-right"></i></a></div>';
}
