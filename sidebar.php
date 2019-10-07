<?php if( _hui('layout') == '1' ) return; 
echo'<div class="wzsid sidebar"'; if(is_single()){echo'style="margin-top:0px;"';} echo'>';?>
<?php 
	_moloader('mo_notice', false);
	
	if (function_exists('dynamic_sidebar')){
		dynamic_sidebar('gheader'); 

		if (is_home()){
			dynamic_sidebar('home'); 
		}
		elseif (is_category()){
			dynamic_sidebar('cat'); 
		}
		else if (is_tag() ){
			dynamic_sidebar('tag'); 
		}
		else if (is_search()){
			dynamic_sidebar('search'); 
		}
		else if (is_single()){
			dynamic_sidebar('single'); 
		}

		dynamic_sidebar('gfooter');
	} 
?>
</div>