<?php 
/*
* use for index
*/
?>
<?php
	$args=array(  
		'orderby' => 'id',  
		'order' => 'ASC',
		'exclude' => _hui('cmsundisplaycats')
	);
	
	$customcats = _hui('example_text'); 
	if(!empty($customcats)){
		$catids = explode(',',$customcats);
		foreach($catids as $catid){
			$categories[] = get_category($catid);
		}
	}else{$categories = get_categories($args);}
	$i=0;$m=0;
	foreach ($categories as $cat) {
		$catid = $cat->cat_ID;
		$catname = $cat->cat_name;
		query_posts(array('cat'=>$catid,'post__not_in'=>get_option('sticky_posts'),'posts_per_page'=>-1));
		$catlink = get_category_link($catid);
		$i++;
		$tp = _get_cms_cat_template($catid,1);
?>
<?php if($i<=6&&$tp!='catlist_bar_0'){ ?>
<?php if($m!=0)echo '</div>'; ?>
<div class="catlist-<?php echo $catid;?> cat-container clearfix">
        <h2 class="home-heading clearfix">
            <span class="heading-text<?php echo get_wow_1(); ?>"><?php echo $catname;?></span><a href="<?php echo $catlink;?>">更多 <i class="fa fa-plus-circle"></i> </a>
        </h2>
        <div class="cms-cat cms-cat-s<?php echo substr($tp,-1);?>">
        <?php get_template_part('modules/cms/'.$tp,esc_attr( $catid ));?>	
        </div>                            
</div>	
<?php $m=0; }else{ $m++;?>
<?php if($m==1) { ?>
<div class="catlist clr cat-container clearfix">
<?php } ?>
<div class="catlist-<?php echo $catid;?> cat-col-1_2">
    <div class="cat-container clearfix">
        <h2 class="home-heading clearfix">
          <span class="heading-text<?php echo get_wow_1(); ?>"><?php echo $catname;?></span><a href="<?php echo $catlink;?>">更多 <i class="fa fa-plus-circle"></i></a>
        </h2>
        <div class="cms-cat cms-cat-s<?php echo substr($tp,-1);?>">
        <?php get_template_part('modules/cms/catlist_bar_0',esc_attr( $catid ));?>	
        </div>  
    </div>		
</div>
<?php }?>	
<?php }?>
<?php if($m!=0)echo '</div>'; ?>
<?php wp_reset_query(); ?>