<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {

	// Change this to use your theme slug
	return 'vieu';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);


	$multicheck_nums = array(
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	// $options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	$options_linkcats = array();
	$options_linkcats_obj = get_terms('link_category');
	foreach ( $options_linkcats_obj as $tag ) {
		$options_linkcats[$tag->term_id] = $tag->name;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/static/img/';
	$qrcode =  get_template_directory_uri() . '/static/img/qrcode.png';
	$adsdesc =  __('可添加任意广告联盟代码或自定义代码', 'haoui');

	$options = array();

	// ======================================================================================================================
	$options[] = array(
		'name' => __('基本', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Logo', 'haoui'),
		'id' => 'logo_src',
		'std' => $imagepath . 'logo.png',
		'desc' => '建议尺寸200x50',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('字体logo', 'haoui'),
		'id' => 'logo_style',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui').__('（开启后图片logo会失效，字体logo修改教程请查看群文件）', 'haoui'));
	$options[] = array(
		'name' => __('网站ico', 'haoui'),
		'id' => 'ico_src',
		'std' => $imagepath . 'favicon.ico',
		'desc' => '建议尺寸48x48',
		'type' => 'upload');	
	$options[] = array(
		'name' => __('布局', 'haoui'),
		'id' => 'layout',
		'std' => "2",
		'type' => "radio",
		'desc' => __("2种布局供选择，点击选择你喜欢的布局方式，保存后前端展示会有所改变。", 'haoui'),
		'options' => array(
			'2' => __('有侧边栏', 'haoui'),
			'1' => __('无侧边栏', 'haoui')
		));
	$options[] = array(
		'name' => __('全局小米兰亭字体', 'haoui'),
		'id' => 'all_fonts',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__('（开启后全局文字将会有一定变化，请查看前台效果）', 'haoui'));
		
	$options[] = array(
		'name' => __("主题风格", 'haoui'),
		'desc' => __("14种颜色供选择，点击选择你喜欢的颜色，保存后前端展示会有所改变。", 'haoui'),
		'id' => "theme_skin",
		'std' => "45B6F7",
		'type' => "colorradio",
		'options' => array(
			'45B6F7' => 100,
			'FF5E52' => 1,
			'2CDB87' => 2,
			'00D6AC' => 3,
			'16C0F8' => 4,
			'EA84FF' => 5,
			'FDAC5F' => 6,
			'FD77B2' => 7,
			'76BDFF' => 8,
			'C38CFF' => 9,
			'FF926F' => 10,
			'8AC78F' => 11,
			'C7C183' => 12,
			'555555' => 13
		)
	);

	$options[] = array(
		'id' => 'theme_skin_custom',
		'std' => "",
		'desc' => __('不喜欢上面提供的颜色，你好可以在这里自定义设置，如果不用自定义颜色清空即可（默认不用自定义）', 'haoui'),
		'type' => "color");

	

	$options[] = array(
		'name' => __('网页最大宽度', 'haoui'),
		'id' => 'site_width',
		'std' => 1200,
		'class' => 'mini',
		'desc' => __('默认：1200，单位：px（像素）', 'haoui'),
		'type' => 'text');

		
	
		
		
		
	$options[] = array(
		'name' => __('底部友情链接', 'haoui'),
		'id' => 'flinks_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__('（开启后会在页面底部增加一个链接模块）', 'haoui'));

	$options[] = array(
		'id' => 'flinks_home_s',
		'type' => "checkbox",
		'std' => false,
		'class' => 'op-multicheck',
		'desc' => __('只在首页开启', 'haoui'));

	$options[] = array(
		'id' => 'flinks_m_s',
		'type' => "checkbox",
		'std' => false,
		'class' => 'op-multicheck',
		'desc' => __('在手机端显示，不勾选则不在手机端显示', 'haoui'));
    $options[] = array(
		'id' => 'gd_links',
		'std' => '/links',
		'class' => 'op-multicheck mini',
		'desc' => __('侧边栏更多友链地址'),
		'type' => 'text');
	$options[] = array(
		'id' => 'flinks_cat',
		'options' => $options_linkcats,
		'class' => 'op-multicheck mini',
		'desc' => __('选择一个底部友情链接的链接分类', 'haoui'),
		'type' => 'select');


	$options[] = array(
		'name' => __('Gravatar 头像获取', 'haoui'),
		'id' => 'gravatar_url',
		'std' => "ssl",
		'type' => "radio",
		'options' => array(
			'no' => __('原有方式', 'haoui'),
			'ssl' => __('从Gravatar官方ssl获取', 'haoui'),
			'duoshuo' => __('从多说服务器获取', 'haoui')
		));

	$options[] = array(
		'name' => __('JS文件托管（可大幅提速JS加载）', 'haoui'),
		'id' => 'js_outlink',
		'std' => "no",
		'type' => "radio",
		'options' => array(
			'no' => __('不托管', 'haoui'),
			'baidu' => __('百度', 'haoui'),
			'360' => __('360（新接口，推荐）', 'haoui'),
			'he' => __('框架来源站点（分别引入jquery和bootstrap官方站点JS文件）', 'haoui')
		));

	$options[] = array(
		'name' => __('网站整体变灰', 'haoui'),
		'id' => 'site_gray',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__('（支持IE、Chrome，基本上覆盖了大部分用户，不会降低访问速度）', 'haoui'));

	$options[] = array(
		'name' => __('分类url去除category字样', 'haoui'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__('（主题已内置no-category插件功能，请不要安装插件；<b>开启后请去设置-固定连接中点击保存即可）</b>', 'haoui'));


	$options[] = array(
		'name' => __('网站底部信息', 'haoui'),
		'id' => 'footer_seo',
		'std' => '<a href="'.site_url('/sitemap').'">'.__('网站地图', 'haoui').'</a>'."\n",
		'desc' => __('备案号可写于此，网站地图可自行新建sitemap页面自动生成', 'haoui'),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('手机端导航', 'haoui'),
		'id' => 'm_navbar',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));

	$options[] = array(
		'name' => __('百度自定义站内搜索', 'haoui'),
		'id' => 'search_baidu',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));

	$options[] = array(
		'id' => 'search_baidu_code',
		'std' => '',
		'desc' => __('此处存放百度自定义站内搜索代码，请自行去 http://zn.baidu.com/ 设置并获取', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');


	$options[] = array(
		'name' => __('新窗口打开文章', 'haoui'),
		'id' => 'target_blank',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));



	$options[] = array(
		'name' => __('分页无限加载页数', 'haoui'),
		'id' => 'ajaxpager',
		'std' => 0,
		'class' => 'mini',
		'desc' => __('为0时表示不开启该功能', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('列表模式', 'haoui'),
		'id' => 'list_type',
		'std' => "thumb",
		'type' => "radio",
		'options' => array(
			'thumb' => __('图文模式（缩略图尺寸：220*150px，默认已自动裁剪）', 'haoui'),
			'text' => __('文字模式 ', 'haoui'),
			'thumb_if_has' => __('图文模式，无特色图时自动转换为文字模式 ', 'haoui'),
		));

	$options[] = array(
		'name' => '底部QQ咨询',
		'id' => 'fqq_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（开启后会在网站底部右下角增加一个QQ咨询按钮。QQ通讯组件可以到 shang.qq.com 进行相关设置）');

	$options[] = array(
		'id' => 'fqq_id',
		'desc' => 'QQ号码',
		'std' => '1452938190',
		'type' => 'text');

	$options[] = array(
		'id' => 'fqq_tip',
		'desc' => '按钮提示文字。默认：QQ咨询',
		'std' => 'QQ咨询',
		'type' => 'text');


	$options[] = array(
		'name' => __('SEO', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('全站连接符', 'haoui'),
		'id' => 'connector',
		'desc' => __('一经选择，切勿更改，对SEO不友好，一般为“-”或“_”', 'haoui'),
		'std' => _hui('connector') ? _hui('connector') : '-',
		'type' => 'text',
		'class' => 'mini');

	$options[] = array(
		'name' => 'SEO标题(title)',
		'id' => 'hometitle',
		'std' => '',
		'desc' => '完全自定义的首页标题让搜索引擎更喜欢，该设置为空则自动采用后台-设置-常规中的“站点标题+副标题”的形式',
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页关键字(keywords)', 'haoui'),
		'id' => 'keywords',
		'std' => '一个网站, 一个牛x的网站',
		'desc' => __('关键字有利于SEO优化，建议个数在5-10之间，用英文逗号隔开', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页描述(description)', 'haoui'),
		'id' => 'description',
		'std' => __('本站是一个高端大气上档次的网站', 'haoui'),
		'desc' => __('描述有利于SEO优化，建议字数在30-70之间', 'haoui'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章和页面SEO设置', 'haoui'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('文章评论内链接添加nofollow跳转', 'haoui'),
		'id' => 'nofollow_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('文章内外链go跳转', 'haoui'),
		'id' => 'go_tiaozhuan_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启【去页面新建页面，选择模板 <b><i>外链跳转</b></i>  固定链接设为 <b>http://你的域名/go</b> 】', 'haoui'));

		// ============首页布局==========================================================================================================
	$options[] = array(
		'name' => __('首页布局', 'haoui'),
		'type' => 'heading');
	$options[] = array(
     'desc' => '下方操作涉及分类ID和文章ID，不知道怎么查看ID的请访问 www.baidu.com');


		 $options[] = array(
		'name' => __( '首页显示模式', 'theme-textdomain' ),
		'desc' => __( '设置首页显示风格.', 'theme-textdomain' ),
		'id' => 'index-s',
		'std' => 'index-blog',
		'type' => 'radio',
		'options' => array('index-blog' => __( '博客模式', 'theme-textdomain' ),'index-card' => __( '卡片模式', 'theme-textdomain' ),'index-cms' => __( 'CMS模式', 'theme-textdomain' ),)
	);

	$options[] = array(
		'name' => __('非CMS 首页不显示该分类下文章', 'haoui'),
		'id' => 'notinhome',
		'options' => $options_categories,
		'type' => 'multicheck');

	$options[] = array(
		'name' => __('非CMS 首页不显示以下ID的文章', 'haoui'),
		'id' => 'notinhome_post',
		'std' => "123456\n654321",
		'desc' => __('每行填写一个文章ID', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('CMS模式下最新文章', 'haoui'),
		'id' => 'index_cms_new',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启（开启博客模式和卡片模式请关闭）', 'haoui'));
	$options[] = array(
	   'class' => 'op-multicheck',
		'desc' => '显示数量请前往[设置>阅读>博客页面至多显示]，排除分类勾选上方的设置');
		
		
	$options[] = array(
		'name' => __( 'CMS首页排除的分类', 'theme-textdomain' ),
		'desc' => __( '这个为CMS显示模块的排除，如要排除分类，那么下方模板样式对应要排除的分类ID不要勾上模板；排除的分类ID将不会显示在首页，中间用英文逗号隔开例如:1,2,3', 'theme-textdomain' ),
		'id' => 'cmsundisplaycats',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __( 'CMS自定义分类排序', 'theme-textdomain' ),
		'desc' => __( '自定义首页CMS分类排序，依次填写分类ID，中间用英文逗号隔开例如:1,2,3', 'theme-textdomain' ),
		'id' => 'example_text',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);

  if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS并列双栏模板', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，该模板为分类并列模板，推荐偶数个分类勾选该模板，并在分类输出排序中使其相邻，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories',
			'type' => 'multicheck',
			'options' => $options_categories
		);
	}
	if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS1,顶部焦点图', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories_1',
			'type' => 'multicheck',
			'options' => $options_categories
		);
	}
	if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS2,左侧焦点图', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories_2',
			'type' => 'multicheck',
			'options' => $options_categories
		);
			$options[] = array(
		'desc' => __('CMS2底部广告', 'haoui'),
		'id' => 'bar_2_asb',
		'std' => '',
		'class' => 'op-multicheck',
		'type' => 'textarea');
	}
	
	if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS3,右侧焦点图', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories_3',
			'type' => 'multicheck',
			'options' => $options_categories
		);
			$options[] = array(
		'desc' => __('CMS3底部广告', 'haoui'),
		'id' => 'bar_3_asb',
		'std' => '',
		'class' => 'op-multicheck',
		'type' => 'textarea');
	}

	if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS4,三列三行，首行为焦点图', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories_4',
			'type' => 'multicheck',
			'options' => $options_categories
		);
	}

	if ( $options_categories ) {  
		$options[] = array(
			'name' => __( '首页CMS5,图文对称模板', 'theme-textdomain' ),
			'desc' => __( '要使用该模板，请勾选对应分类，同一分类不要勾选多个模板', 'theme-textdomain' ),
			'id' => 'example_checkbox_categories_5',
			'type' => 'multicheck',
			'options' => $options_categories
		);
	}		

    $options[] = array(
		'name' => __('关闭前台登录', 'haoui'),
		'id' => 'ligin_off',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('关闭'));

	$options[] = array(
		'name' => __('首页随机文章/热门文章', 'haoui'),
		'id' => 'index_page_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui').__('（开启后会在公告下新增一个模块，若是开启“经典模式”则只显示热门文章且手机不显示）', 'haoui'));
	$options[] = array(
		'id' => 'latest_visit_st',
		'class' => 'op-multicheck',
		'std' => '1',
		'type' => 'radio',
		'options' => array('1' => __( '默认样式', '1' ),'2' => __( '焦点图样式', '2' ),'3' => __( '不显示前标', '3' ),));

	$options[] = array(
		'desc' => __('随机文章⬇⬇⬇⬇⬇'));
	$options[] = array(
		'id' => 'index_suiji_h3',
		'type' => "text",
		'std' => '随机推荐',
		'desc' => __('随机推荐标题'),
		'class' => 'op-multicheck mini');
	$options[] = array(
		'id' => 'index_suiji_item',
		'type' => "text",
		'std' => '4',
		'desc' => __('显示数量', 'haoui').__('（此为随机文章数量）', 'haoui'),
		'class' => 'op-multicheck mini');
	$options[] = array(
		'id' => 'index_suiji_text',
		'type' => "text",
		'std' => '荐',
		'desc' => __('随机推荐文字', 'haoui').__('（将显示在每条推荐的前面，建议一个字，支持fonts图标）', 'haoui'),
		'class' => 'op-multicheck mini');
	$options[] = array(
		'desc' => __('热门文章⬇⬇⬇⬇⬇'));
	$options[] = array(
		'id' => 'index_rem_h3',
		'type' => "text",
		'std' => '30天热门',
		'desc' => __('热门推荐标题'),
		'class' => 'op-multicheck mini');
	$options[] = array(
		'id' => 'index_rem_item',
		'type' => "text",
		'std' => '4',
		'desc' => __('显示数量', 'haoui').__('（此为随机文章数量）', 'haoui'),
		'class' => 'op-multicheck mini');
	$options[] = array(
		'id' => 'index_rem_date',
		'type' => "text",
		'std' => '30',
		'desc' => __('时间/单位/天', 'haoui').__('（显示多长时间内评论最多的文章）', 'haoui'),
		'class' => 'op-multicheck mini');
			$options[] = array(
		'name' => __('首页工具箱', 'haoui'),
		'id' => 'index_tool_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('手机端默认不显示', 'haoui'),
		'id' => 'index_tool',
		'class' => 'op-multicheck',
		'std' => '<div class="themes-module">
	<div class="container">
	<ul>
            <li>
			<a href="https://viapi.cn" target="_blank">
                <i class="fa fa-code"></i>
                <strong>免费开放API</strong>
                <p>贯穿国内外常用网络API接口集合，免费在线调用享受极致开发体验</p>
				</a>
            </li>
            <li>
			<a href="http://mz.cclmz.cn" target="_blank">
                <i class="fa fa-thumbs-o-up"></i>
                <strong>免费秒赞挂机平台</strong>
                <p>及时响应、持久稳定，四年间从未间断，稳定四年以来一直免费开放</p>
				</a>
            </li>
            <li>
			<a href="http://fm.viapi.cn" target="_blank">
                <i class="fa fa-music"></i>
                <strong>FM网页音乐调用</strong>
                <p>免费提供网页悬浮播放器在线调用及付费音乐在线免费试听下载</p>
				</a>
            </li>
            <li>
			<a href="http://qr.viapi.cn" target="_blank">
                <i class="fa fa-qrcode"></i>
                <strong>三合一收款码</strong>
                <p>免费在线合并支付宝、微信、QQ钱包收款二维码，实现更加便捷收款</p>
				</a>
            </li>
        </ul>

	</div>
</div>',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页最新发布显示置顶文章', 'haoui'),
		'id' => 'home_sticky_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));
		$options[] = array(
		'id' => 'home_sticky_n',
		'options' => $multicheck_nums,
		'desc' => __('置顶文章显示数目', 'haoui'),
		'class' => 'op-multicheck mini',
		'type' => 'select');
	
	$options[] = array(
		'name' => __('不同时段温馨提醒', 'haoui'),
		'id' => 'notices_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'id' => 'notices_title',
		'std' => '温馨提示',
		'desc' => __('提醒标题'),
		'class' => 'op-multicheck',
		'type' => 'text');
	$options[] = array(
		'desc' => __('不同时段的提示语，每一句提示语表示不同时段，用 “ | ” 符号分割，不能出现空格，共16句，其中上午9点到晚上23点提示语为两小时并用一句，其他时间一小时一句，对应语句的时间顺序 0-1-2-3-4-5-6-7-8-（9点到10点）-(11点到12点)-(13点到17点)-(18点到19点)-(20点到21点)-(22点到23)', 'haoui'),
		'id' => 'notices_content',
		'class' => 'op-multicheck',
		'std' => '现在已经过凌晨了，身体是无价的资本喔，小伙伴早点休息吧！|凌晨1点多了，工作是永远都做不完的，小伙伴别熬坏身子！|亲爱的小伙伴该休息了，身体可是革命的本钱啊！|夜深了，熬夜很容易导致身体内分泌失调，长痘痘的！|四点过了额(⊙o⊙)…，你明天不学习工作吗？？？|你知道吗，此时是国内网络速度最快的时候！|清晨好，这么早就来网站啦，谢谢小伙伴的关注哦，昨晚做的梦好吗？|新的一天又开始了，祝你过得快乐！|小伙伴早上好哦，一天之际在于晨，又是美好的一天！|上午好！今天你看上去好精神哦！|小伙伴啊！该吃午饭啦！有什么好吃的？您有中午休息的好习惯吗？|下午好！外面的天气好吗？记得朵朵白云曾捎来朋友殷殷的祝福。|太阳落山了！快看看夕阳吧！如果外面下雨，就不必了 ^_^ |晚上好，小伙伴今天的心情怎么样？去留言板诉说一下吧！|忙碌了一天，累了吧？去看看最新的新闻资讯醒醒脑吧！|这么晚了，小伙伴还在上网？早点洗洗睡吧，睡前记得洗洗脸喔！明天一天都会萌萌哒！',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('后台登录密码保护', 'haoui'),
		'id' => 'login_security',
		'type' => 'checkbox',
		'std' => false,
		'desc' => __('开启', 'haoui'));
    $options[] = array(
	    'desc' => __('示列：修改后你的登录地址为：<b>/wp-login.php?密码域=密码</b>  如我设置的密码域为 vieu 密码为 2018 则后台登录地址为<b>：/wp-login.php?vieu=2018</b> 如非通过此链接访问默认跳转到指定网站'),
		'class' => 'op-multicheck');
	$options[] = array(
		'id' => 'login_security_title',
		'std' => '',
		'desc' => __('密码域'),
		'class' => 'op-multicheck mini',
		'type' => 'text');
	$options[] = array(
		'id' => 'login_security_pass',
		'std' => '',
		'desc' => __('密码'),
		'class' => 'op-multicheck mini',
		'type' => 'text');
	$options[] = array(
		'id' => 'login_security_url',
		'std' => '',
		'desc' => __('错误跳转链接'),
		'class' => 'op-multicheck',
		'type' => 'text');
   $options[] = array(
		'name' => __('自动使用文章第一张图作为缩略图', 'haoui'),
		'id' => 'thumb_postfirstimg_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui').'，特别注意：如果文章已经设置特色图像或外链缩略图输入，此功能将无效。');

	$options[] = array(
		'id' => 'thumb_postfirstimg_lastname',
		'std' => '',
		'desc' => __('自动缩略图后缀将自动加入文章第一张图的地址后缀之前。比如：文章中的第一张图地址是“aaa/bbb.jpg”，此处填写的字符是“-220x150”，那么缩略图的实际地址就变成了“aaa/bbb-220x150.jpg”。默认为空。', 'haoui'),
		'class' => 'op-multicheck',
		'type' => 'text');

	$options[] = array(
		'name' => __('外链缩略图输入', 'haoui'),
		'id' => 'thumblink_s',
		'type' => "checkbox",
		'std' => false,
		'class' => 'op-multicheck',
		'desc' => __('开启', 'haoui').' 开启后会在后台编辑文章时出现外链缩略图地址输入框，填写一个图片地址即可在文章列表中显示。注意：如果文章添加了特色图像，列表中显示的缩略图优先选择该特色图像。');
	
	$options[] = array(
		'name' => __('WOW加载特效', 'haoui'),
		'id' => 'the_wow_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('显示页面', 'haoui'),
		'id' => 'the_wow_comt1',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('首页', 'haoui'));
	$options[] = array(
		'id' => 'the_wow_comt2',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('文章页', 'haoui'));
	$options[] = array(
		'id' => 'the_wow_comt3',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('侧边栏', 'haoui'));
   $options[] = array(
		'id' => 'the_wow_comt4',
		'type' => "checkbox",
		'std' => false,
		'class' => 'op-multicheck',
		'desc' => __('内容抖动', 'haoui'));		
	$options[] = array(
	'name' => __('样式', 'haoui'),
		'id' => 'the_wow_style',
		'std' => "fadeInUp",
		'type' => "radio",
		'options' => array(
			'fadeInUp' => __('默认', 'haoui'),
			'zoomIn' => __('弹出', 'haoui'),
			'pulse' => __('跳动', 'haoui'),
			'swing' => __('晃动', 'haoui'),
			'bounceIn' => __('跳出', 'haoui'),
			'bounceInUp' => __('下拉', 'haoui'),
			'flipInX' => __('上下翻转', 'haoui'),
			'flipInY' => __('左右翻转', 'haoui')
		));

		
		
/*
	$options[] = array(
		'name' => __('评论数只显示人为评论数量', 'haoui'),
		'id' => 'comment_number_remove_trackback',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__('（部分文章有trackback导致评论数的增加，这个可以过滤掉） ', 'haoui'));
*/


	// =======================自定义背景===============================================================================================
	
	$options[] = array(
		'name' => __('自定义背景', 'haoui'),
		'type' => 'heading');

$options[]=array(
'name'=>__('开启自定义网站背景','haoui'),
'id'=>'bg_checker',
'desc'=>__('勾选之后请设置下面的值','haoui'),
'type'=>'checkbox'
);
$options[]=array(
'name'=>__('必应每日背景','haoui'),
'id'=>'bg_bing',
'std'=>false,
'desc'=>__('勾选之后将每日自动更换背景，下方设置为无效','haoui'),
'type'=>'checkbox'
);
$options[] = array(
'name'=>__('自定义背景个颜色','haoui'),
'id' => 'wp_bg_color',
'std' => "",
'desc' => __('选中文字颜色，请选择一种颜色，自行配合颜色', 'haoui'),
'type' => "color");
$options[] = array(
'name'=>__('自定背景图片','haoui'),
'id' => 'wp_bg_img',
'std' => "",
'desc' => __('自行上传一张图片作为背景图片，优先级低于上面的，也就是一旦设置了颜色，此选项失效', 'haoui'),
'type' => "upload");
	$options[] = array(
		'name' => __('布局', 'haoui'),
		'id' => 'wp_bg_style',
		'std' => "no-repeat",
		'type' => 'select',
		'options' => array(
			'no-repeat' => __('不重复显示', 'haoui'),
			'repeat' => __('重复显示', 'haoui'),
		));
			$options[] = array(
		'name' => __('背景滚动', 'haoui'),
		'id' => 'wp_bg_gd',
		'std' => "fixed",
		'type' => 'select',
		'options' => array(
			'fixed' => __('不滚动', 'haoui'),
			'scroll' => __('滚动', 'haoui'),
		));
			$options[] = array(
		'name' => __('是否填满屏幕', 'haoui'),
		'id' => 'wp_bg_size',
		'std' => "",
		'type' => 'select',
		'options' => array(
		
			'' => __('原始', 'haoui'),	
			'background-size:100%;' => __('填满', 'haoui'),
		));
$options[]=array(
'name'=>__('===================================================================================','haoui'),
);		
$options[]=array(
'name'=>__('开启自定义登陆页面背景','haoui'),
'id'=>'login_bg_checker',
'desc'=>__('勾选之后请设置下面的值','haoui'),
'type'=>'checkbox'
);
$options[] = array(
'name'=>__('自定义背景个颜色','haoui'),
'id' => 'login_bg_color',
'std' => "",
'desc' => __('选中文字颜色，请选择一种颜色，自行配合颜色', 'haoui'),
'type' => "color");
$options[] = array(
'name'=>__('自定背景图片','haoui'),
'id' => 'login_bg_img',
'std' => "",
'desc' => __('自行上传一张图片作为背景图片，优先级低于上面的，也就是一旦设置了颜色，此选项失效', 'haoui'),
'type' => "upload");
$options[]=array(
'name'=>__('开启自定义登陆页logo','haoui'),
'id'=>'login_logo',
'desc'=>__('勾选之后请设置下面的值','haoui'),
'type'=>'checkbox'
);

$options[] = array(
'id' => 'login_logo_img',
'std' => "",
'desc' => __('logo地址，图片尺寸为120*120', 'haoui'),
'type' => "upload");

$options[] = array(
		'id' => 'login_logo_url',
		'std' => '',
		'desc' => __('自定义logo跳转链接，留空为首页', 'haoui'),
		'type' => 'text');
	// ======================================================================================================================
	$options[] = array(
		'name' => __('文章页', 'haoui'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('标签', 'haoui'),
		'id' => 'single_tags',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('面包屑导航', 'haoui').' / '.__('用“正文”替代标题', 'haoui'),
		'id' => 'breadcrumbs_single_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('文章简语', 'haoui'),
		'id' => 'simlang_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启（一句话概括文章主要内容）', 'haoui'));
	$options[] = array(
		'name' => __('文章摘要', 'haoui'),
		'id' => 'breadcrumbs_zhaiyao_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启（可以在文章编辑页面上方显示，编辑文章时添加自定义摘要）', 'haoui'));
	$options[] = array(
		'name' => __('图片弹窗预览', 'haoui'),
		'id' => 'lightbox_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('弹窗付图片注明', 'haoui'),
		'id' => 'lightbox_caption_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'name' => __('分享功能（手机端不显示）', 'haoui'),
		'id' => 'share_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));

	$options[] = array(
		'name' => '点赞',
		'id' => 'post_like_s',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");
		
	$options[] = array(
		'name' => '侧边栏收缩',
		'id' => 'bianlan_on_s',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");
	$options[] = array(
		'name' => __('分享海报', 'haoui'),
		'id' => 'bigger-share_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启（请先前往 “页面” 新建 ”分享海报“ 页面，并将固定连接设为 “toimage” 。注意二维码api与左边栏的二维码api是一样的，开启前请确认API可用有效）', 'haoui'));
	$options[] = array(
		'id' => 'bigger-share-sub',
		'desc' => '海报宣传语',
        'class' => 'op-multicheck',
		'std' => __('专注于网络资源搜集共享与发布！', 'haoui'),
		'type' => 'text');	
	$options[] = array(
		'id' => 'bigger-share-logo',
		'desc' => '海报logo（尺寸：200*50）',
		'class' => 'op-multicheck',
		'std' => $imagepath . 'logo.png',
		'type' => 'upload');				
	$options[] = array(
		'name' => __('海报公章认证', 'haoui'),
		'id' => 'bigger_gz_s',
		'type' => "checkbox",
		'class' => 'op-multicheck',
		'std' => false,
		'desc' => __('开启', 'haoui'));
	$options[] = array(
		'id' => 'bigger_gz_huzi',
		'desc' => '海报公章扇形弧字（不得超过6个字）',
        'class' => 'op-multicheck mini',
		'std' => '优质资源分享',
		'type' => 'text');	
	$options[] = array(
		'id' => 'bigger_gz_text',
		'desc' => '海报公章横字（不得超过4个字）',
        'class' => 'op-multicheck mini',
		'std' => '唯爱网络',
		'type' => 'text');	
		
		
	$options[] = array(
		'name' => __('文章声明', 'haoui'),
		'id' => 'shengming',
		'std' => '<em>特别声明：</em>文章多为网络转载，资源使用一般不提供任何帮助，特殊资源除外，如有侵权请联系！',
		'desc' => __('代码（在文章最上方显示）', 'haoui'),
		'type' => 'textarea');
		
		
$options[] = array(
	    'name' => __('文章左边栏是否开启', 'haoui'),
		'id' => 'left_sd_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'left_post_authordesc_s',
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('文章作者介绍', 'haoui'),
		'type' => 'checkbox');


	$options[] = array(
		'id' => 'left_qrcode_s',
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('文章二维码', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('自定左边栏义广告', 'haoui'),
		'id' => 'left_asb_s',
		'std' => '',
		'desc' => __('代码', 'haoui'),
		'type' => 'textarea');
			
	$options[] = array(
		'name' => '打赏',
		'id' => 'post_rewards_s',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");

	$options[] = array(
		'name' => '打赏：显示文字',
		'id' => 'post_rewards_text',
		'std' => '打赏',
		'class' => 'op-multicheck',
		'type' => 'text');

	$options[] = array(
		'name' => '打赏：弹出层标题',
		'id' => 'post_rewards_title',
		'class' => 'op-multicheck',
		'std' => '觉得文章有用就打赏一下文章作者',
		'type' => 'text');

	$options[] = array(
		'name' => '打赏：支付宝收款二维码',
		'id' => 'post_rewards_alipay',
		'desc' => '',
		'std' => $qrcode,
		'class' => 'op-multicheck',
		'type' => 'upload');

	$options[] = array(
		'name' => '打赏：微信收款二维码',
		'id' => 'post_rewards_wechat',
		'desc' => '',
		'class' => 'op-multicheck',
		'std' => $qrcode,
		'type' => 'upload');

	$options[] = array(
		'name' => __('文章小部件开启', 'haoui'),
		'id' => 'post_plugin_view',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('阅读量（无需安装插件）', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_comm',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('列表评论数', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_like',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('列表点赞', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_date_m',
		'type' => "checkbox",
		'std' => false,
		'class' => 'op-multicheck',
		'desc' => __('手机端列表时间 ', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_author',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('列表作者名', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_cat',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('列表分类链接', 'haoui'));

	$options[] = array(
		'id' => 'post_plugin_cat_m',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('手机端列表分类链接', 'haoui'));


	$options[] = array(
		'name' => __('文章缩略图异步加载', 'haoui'),
		'id' => 'thumbnail_src',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));

	$options[] = array(
		'name' => __('文章上一页下一页', 'haoui'),
		'id' => 'post_prevnext_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));


	$options[] = array(
		'name' => __('相关文章', 'haoui'),
		'id' => 'post_related_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	
	$options[] = array(
		'id' => 'related_m',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('手机端不显示', 'haoui'));
	
	$options[] = array(
		'id' => 'post_related_style',
		'std' => "relates-thumb",
		'type' => "radio",
		'class' => 'op-multicheck',
		'options' => array(
			'relates-thumb' => __('图文模式', 'haoui'),
			'relates-text' => __('文字模式', 'haoui')
		));
		
	$options[] = array(
		'desc' => __('相关文章标题', 'haoui'),
		'id' => 'related_title',
		'class' => 'op-multicheck mini',
		'std' => __('相关推荐', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'desc' => __('相关文章显示数量', 'haoui'),
		'id' => 'post_related_n',
		'std' => 4,
		'class' => 'op-multicheck mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('文章来源', 'haoui'),
		'id' => 'post_from_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));
	
	$options[] = array(
		'id' => 'post_from_h1',
		'std' => __('来源：', 'haoui'),
		'class' => 'op-multicheck',
		'desc' => __('来源显示字样', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'id' => 'post_from_link_s',
		'type' => "checkbox",
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('来源加链接', 'haoui'));

	$options[] = array(
		'name' => __('内容段落缩进', 'haoui'),
		'id' => 'post_p_indent_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'haoui').__(' 开启后只对前台文章展示有效，对后台编辑器中的格式无效', 'haoui'));

	$options[] = array(
		'name' => __('自定义背景', 'haoui'),
		'id' => 'singele-background',
		'type' => "textarea",
		'class' => 'op-multicheck',
		'std' => $imagepath . 'vieu.jpg',
		'desc' => __('一行一张图片地址，多张图片为随机轮播可输入单张，要求尺寸1920*450', 'haoui'));

	$options[] = array(
		'name' => __('文章页尾版权提示', 'haoui'),
		'id' => 'post_copyright_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui'));

	$options[] = array(
		'name' => __('文章页尾版权提示前缀', 'haoui'),
		'id' => 'post_copyright',
		'std' => __('未经允许不得转载：', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('自动添加关键字和描述', 'haoui'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui').__('（开启后所有页面将自动使用主题配置的关键字和描述，具体规则可以自行查看页面源码得知）', 'haoui'));
		
		


 
	// ======================================================================================================================
	$options[] = array(
		'name' => __('独立下载页', 'haoui'),
		'type' => 'heading' );
    $options[] = array(
	    'name' => __('========文章下载页配置========', 'haoui'));
	$options[] = array(
		'name' => '在线演示功能',
		'desc' => '使用前去页面新建页面，选择模板 <b><i>在线演示</b></i>  固定链接设为 <b>http://你的域名/demo</b> ');	
	$options[] = array(
	    'name' => __('新窗口下载', 'haoui'),
		'id' => 'down_blank_s',
		'std' => false,
		'desc' => __('开启（开启后跳转新窗口下载，关闭为弹窗下载。开启前请前往 <b><i>页面-新建页面-选择在线下载模板</b></i> 且固定链接设为 <b><i>http://你的域名/down</b></i> ）', 'haoui'),
		'type' => 'checkbox');
   $options[] = array(
		'name' => __('背景（建议尺寸800x280）', 'haoui'),
		'id' => 'down_bg_src',
		'std' => $imagepath . 'down_bg.png',
		'type' => 'upload');	
	$options[] = array(
		'name' => __('自定义下载说明', 'haoui'),
		'id' => 'down_sm',
		'std' => '本站大部分下载资源收集于网络，只做学习和交流使用，版权归原作者所有，若为付费资源，请在下载后24小时之内自觉删除，若作商业用途，请到原网站购买，由于未及时购买和付费发生的侵权行为，与本站无关。本站发布的内容若侵犯到您的权益，请联系本站删除，我们将及时处理！',
		'desc' => __('代码', 'haoui'),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('自定义广告', 'haoui'),
		'id' => 'down_asb1',
		'std' => '',
		'desc' => __('代码', 'haoui'),
		'type' => 'textarea');
	 $options[] = array(
	    'name' => __('========下载详情页配置========', 'haoui'));
		
    $options[] = array(
		'name' => __('右侧提示图（建议尺寸250x250）', 'haoui'),
		'id' => 'down_tishi_src',
		'std' => $imagepath . 'download.png',
		'type' => 'upload');	
	$options[] = array(
		'name' => __('详情页广告', 'haoui'),
		'id' => 'down_asb2',
		'std' => '',
		'desc' => __('代码', 'haoui'),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('详情页下载说明', 'haoui'),
		'id' => 'down_xqsm',
		'std' => ' <p>1、本站提供的压缩包若无特别说明，解压密码均为<em>www.vizyw.com</em>。</p>
        <p>2、下载后文件若为压缩包格式，请安装7Z软件或者其它压缩软件进行解压。</p>
		<p>3、文件比较大的时候，建议使用下载工具进行下载，浏览器下载有时候会自动中断，导致下载错误。</p>
		<p>4、资源可能会由于内容问题被和谐，导致下载链接不可用，遇到此问题，请到文章页面进行反馈，我们会及时进行更新的。</p>
		<p>5、其他下载问题请自行搜索教程，这里不一一讲解。</p>',
		'desc' => __('代码', 'haoui'),
		'type' => 'textarea');		

	
	
    // ======================================================================================================================
	/*$options[] = array(
		'name' => __('新浪图床', 'haoui'),
		'type' => 'heading' );
	
	$options[] = array(
	    'name' => __('是否开启新浪图床上传媒体', 'haoui'),
		'id' => 'sinaimg_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
		$options[] = array(
	    'name' => __('微博账号', 'haoui'),
		'id' => 'sinaimg_weibo',
		'std' => '',
		'class' => 'mini',
		'desc' => __('账号', 'haoui'),
		'type' => 'text');
		
		$options[] = array(
		'id' => 'sinaimg_pass',
		'std' => '',
		'class' => 'op-multicheck mini',
		'desc' => __('密码', 'haoui'),
		'type' => 'text');
	$options[] = array(
		'desc' => __('什么是新浪图床？这个功能是把你网站的图片媒体文件上传到新浪然后提取图片直链调用到你自己的文章内使用，有利于提高网站媒体的加载速度，所有图片将存储在你自己的微博账号之下。'));
	$options[] = array(
		'desc' => __('开启前请先新建 <b><i>新浪图传</i></b> 页面，并将固定连接设为 <b><i>sinaimg</i></b> 然后填写账号密码（注意所有的数据都是保存在你自己的数据库，本站并不获取任何用户信息）'));
*/
	// ======================================================================================================================


	// ======================================================================================================================
	$options[] = array(
		'name' => __('会员中心', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'user_page_s',
		'std' => true,
		'desc' => __('开启会员中心', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('选择会员中心页面', 'haoui'),
		'id' => 'user_page',
		'desc' => '如果没有合适的页面作为会员中心，你需要去新建一个页面再来选择',
		'options' => $options_pages,
		'type' => 'select');

	$options[] = array(
		'name' => __('选择找回密码页面', 'haoui'),
		'id' => 'user_rp',
		'desc' => '如果没有合适的页面作为找回密码页面，你需要去新建一个页面再来选择',
		'options' => $options_pages,
		'type' => 'select');
	$options[] = array(
		'name' => __('用户中心背景', 'haoui'),
		'id' => 'user_banner_bg',
		'std' => $imagepath . 'banner.jpg',
		'desc' => __('尺寸1920*300', 'haoui'),
		'type' => 'upload');
	$options[] = array(
		'name' => __('允许用户发布文章', 'haoui'),
		'id' => 'tougao_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('有新投稿邮件通知', 'haoui'),
		'id' => 'tougao_mail_send',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'desc' => __('投稿通知接收邮箱', 'haoui'),
		'id' => 'tougao_mail_to',
		'type' => 'text');
	$options[] = array(
		'name' => __('禁止昵称关键字', 'haoui'),
		'desc' => __('一行一个关键字，用户昵称将不能使用或包含这些关键字，对编辑以下职位有效', 'haoui'),
		'id' => 'user_nickname_out',
		'std' => "赌博\n博彩\n彩票\n性爱\n色情\n做爱\n爱爱\n淫秽\n傻b\n妈的\n妈b\nadmin\ntest",
		'type' => 'textarea');








	// ======================================================================================================================
	$options[] = array(
		'name' => __('网站公告', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'minicat_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'minicat_home_s',
		'std' => true,
		'desc' => __('在首页显示公告分类最新文章', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('首页模块前缀', 'haoui'),
		'id' => 'minicat_home_title',
		'desc' => '默认为：网站公告',
		'std' => '网站公告',
		'type' => 'text');

	$options[] = array(
		'name' => __('选择分类设置为公告', 'haoui'),
		'desc' => __('选择一个使用公告展示模版，分类下文章将全文输出到公告类列表', 'haoui'),
		'id' => 'minicat',
		'options' => $options_categories,
		'type' => 'select');




	// ======================================================================================================================
	$options[] = array(
		'name' => __('首页焦点图', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'id' => 'focusslide_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('说明：默认为企业风格，全屏显示幻灯片（建议尺寸1900*500）。经典模式在3.5系列有些更改，一张非全屏banner（建议尺寸900*500）', 'haoui'));
	$options[] = array(
		'name' => __('样式', 'haoui'),
		'id' => 'banner_style',
		'std' => "3",
		'type' => "radio",
		'options' => array(
		    '3' => __('展示', 'haoui'),
			'2' => __('企业', 'haoui'),
			'1' => __('经典', 'haoui')
		));
	$options[] = array(
		'name' => __('排序', 'haoui'),
		'id' => 'focusslide_sort',
		'desc' => '默认：1 2 3 4 5',
		'std' => '1 2 3 4 5',
		'type' => 'text');

	for ($i=1; $i <= 5; $i++) { 
	
	$options[] = array(
		'desc' => '---------------------------------------');	
	$options[] = array(
		'name' => __('图', 'haoui').$i,
		'id' => 'focusslide_src_'.$i,
		'desc' => __('背景图片，尺寸：', 'haoui').'1900*400或900*500',
		'std' => $imagepath . 'vieu.jpg',
		'type' => 'upload');	
	$options[] = array(
	    'class' => 'op-multicheck',
		'id' => 'focusslide_src_zhanshi_'.$i,
		'desc' => __('展示图片'.$i.'（只在开启展示模式启用），尺寸：500*280 透明背景 .png,.gif', 'haoui'),
		'std' => $imagepath . 'zhanshi.png',
		'type' => 'upload');
		$options[] = array(
		
		'desc' => __('展示图位置'));
	$options[] = array(
	'class' => 'op-multicheck',
		'id' => 'focusslide_zsstyle_'.$i,
		'std' => "1",
		'type' => "radio",
		'options' => array(
			'1' => __('右侧', 'haoui'),
			'2' => __('左侧', 'haoui')
		));	
	$options[] = array(
		'id' => 'focusslide_title_'.$i,
		'desc' => '标题',
		'std' => 'Vieu主题',
		'type' => 'text');
		
	$options[] = array(
		'id' => 'focusslide_text_'.$i,
		'desc' => '内容',
		'std' => '<h3>Vieu主题基于WordPress程序，响应式布局支持电脑、平板和手机的完美展示</h3>',
		'class' => 'op-multicheck',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'focusslide_button_'.$i,
		'desc' => '按钮1',
		'std' => '了解详情',
		'class' => 'op-multicheck',
		'type' => 'text');	
    $multicheck_nums = array(
        'primary' => '原始',
        'default' => '默认',
        'info' => '淡蓝',
        'warning' => '橙色',
        'danger' => '红色',
		'success' => '绿色'
        );
    $options[] = array(
        'id' => 'focusslide_color_'.$i,
		'desc' => '按钮样式',
		'class' => 'op-multicheck',
        'options' => $multicheck_nums,
        'type' => 'select');

	$options[] = array(
		// 'name' => __('链接到', 'haoui'),
		'id' => 'focusslide_href_'.$i,
		'desc' => __('链接', 'haoui'),
		'class' => 'op-multicheck',
		'std' => 'http://www.vizyw.com/3132.html',
		'type' => 'text');

	$options[] = array(
		'id' => 'focusslide_blank_'.$i,
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('新窗口打开', 'haoui'),
		'type' => 'checkbox');
	
	$options[] = array(
		'id' => 'focusslide_button_two_'.$i,
		'desc' => '按钮2',
		'std' => '了解详情',
		'type' => 'text');	
    $options[] = array(
        'id' => 'focusslide_color_two_'.$i,
		'desc' => '按钮样式',
		'class' => 'op-multicheck',
        'options' => $multicheck_nums,
        'type' => 'select');

	$options[] = array(
		// 'name' => __('链接到', 'haoui'),
		'id' => 'focusslide_href_two_'.$i,
		'desc' => __('链接', 'haoui'),
		'class' => 'op-multicheck',
		'std' => 'http://www.vizyw.com/3132.html',
		'type' => 'text');

	$options[] = array(
		'id' => 'focusslide_blank_two_'.$i,
		'std' => true,
		'class' => 'op-multicheck',
		'desc' => __('新窗口打开', 'haoui'),
		'type' => 'checkbox');

	}


	// ======================================================================================================================
	$options[] = array(
		'name' => __('侧栏随动', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('首页', 'haoui'),
		'id' => 'sideroll_index_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_index',
		'std' => '1 2',
		'class' => 'mini',
		'desc' => __('设置随动模块，多个模块之间用空格隔开即可！默认：“1 2”，表示第1和第2个模块，建议最多3个模块 ', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('分类/标签/搜索页', 'haoui'),
		'id' => 'sideroll_list_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_list',
		'std' => '1 2',
		'class' => 'mini',
		'desc' => __('设置随动模块，多个模块之间用空格隔开即可！默认：“1 2”，表示第1和第2个模块，建议最多3个模块 ', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('文章页', 'haoui'),
		'id' => 'sideroll_post_s',
		'std' => true,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_post',
		'std' => '1 2',
		'class' => 'mini',
		'desc' => __('设置随动模块，多个模块之间用空格隔开即可！默认：“1 2”，表示第1和第2个模块，建议最多3个模块 ', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('手机端显示', 'haoui'),
		'id' => 'sideroll_m_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');


	// ======================================================================================================================
	$options[] = array(
		'name' => __('独立页面', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('读者墙', 'haoui'),
		'id' => 'readwall_limit_time',
		'std' => 200,
		'class' => 'mini',
		'desc' => __('限制在多少月内，单位：月', 'haoui'),
		'type' => 'text');


		
		
	$options[] = array(
		'id' => 'readwall_limit_number',
		'std' => 200,
		'class' => 'mini',
		'desc' => __('显示个数', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('页面左侧菜单设置', 'haoui'),
		'id' => 'page_menu',
		'options' => $options_pages,
		'type' => 'multicheck');

	$options[] = array(
		'name' => __('友情链接分类选择', 'haoui'),
		'id' => 'page_links_cat',
		'options' => $options_linkcats,
		'type' => 'multicheck');

	$options[] = array(
		'name' => __('网址导航标题下描述', 'haoui'),
		'id' => 'navpage_desc',
		'std' => '这里显示的是网址导航的一句话描述...',
		'type' => 'text');

	$options[] = array(
		'name' => __('选择链接分类到网址导航', 'haoui'),
		'id' => 'navpage_cats',
		'options' => $options_linkcats,
		'type' => 'multicheck');

	// ======================================================================================================================
	$options[] = array(
		'name' => __('字符', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('首页最新发布标题', 'haoui'),
		'id' => 'index_list_title',
		'std' => __('最新发布', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('首页最新发布标题右侧', 'haoui'),
		'id' => 'index_list_title_r',
		'std' => '<a href="链接地址">显示文字</a><a href="链接地址">显示文字</a><a href="链接地址">显示文字</a><a href="链接地址">显示文字</a>',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('文章发布邮件通知', 'haoui'),
		'id' => 'post_email_s',
		'std' => false,
		'desc' => '发布文章时向所有用户发送邮件（不建议开启，对服务器要求极高）',
		'type' => 'checkbox');
	$options[] = array(
		'name' => __('文章隐藏内容提示', 'haoui'),
		'id' => 'collapse_title',
		'std' => __('阅读全文', 'haoui'),
		'type' => 'text');
		
	$options[] = array(
		'name' => __('评论标题', 'haoui'),
		'id' => 'comment_title',
		'std' => __('评论', 'haoui'),
		'class' => 'op-multicheck',
		'type' => 'text');

	$options[] = array(
		'name' => __('评论框默认字符', 'haoui'),
		'id' => 'comment_text',
		'std' => __('你的评论可以一针见血', 'haoui'),
		'class' => 'op-multicheck',
		'type' => 'text');

	$options[] = array(
		'name' => __('评论提交按钮字符', 'haoui'),
		'id' => 'comment_submit_text',
		'std' => __('提交评论', 'haoui'),
		'class' => 'op-multicheck',
		'type' => 'text');
		
		$options[] = array(
		'name' => __('评论间隔时间', 'haoui'),
		'id' => 'comment_time',
		'std' => __('60', 'haoui'),
		'class' => 'op-multicheck mini',
		'desc' => '单位/秒',
		'type' => 'text');
		$options[] = array(
		'name' => __('必应接口开启随机壁纸', 'haoui'),
		'id' => 'bing_rand_s',
		'std' => false,
		'desc' => '必应接口调用函数 &lt;?php echo bing_img() ?&gt;',
		'type' => 'checkbox');
	$options[] = array(
		'name' => __('文章内全网VIP视频解析', 'haoui'),
		'id' => 'vieu_video_s',
		'std' => true,
		'desc' => '开启（视频解析接口支持全网VIP影视，文章内使用格式 <b><i> [video]视频播放地址[/video] </i></b> 【如腾讯视频的就是腾讯视频的视频播放地址。如https://v.qq.com/x/page/c0376z3bdo6.html】）',
		'type' => 'checkbox');
	$options[] = array(
		'name' => __('视频解析接口', 'haoui'),
		'id' => 'videoapi_url',
		'class' => 'op-multicheck',
		'std' => 'http://www.viapi.cn/tv/jiexi.php?url=',
		'type' => 'text');
	$options[] = array(
		'name' => __('公众号加密', 'haoui'),
		'desc' => '调用格式 <b><i> [gzhhide key="密码"]加密内容[/gzhhide] </i></b> ');
	$options[] = array(
		'id' => 'gzhhide_title',
		'desc' => '隐藏提示',
		'class' => 'op-multicheck',
		'std' => '抱歉！隐藏内容，请输入密码后可见！',
		'type' => 'text');
	$options[] = array(
		'desc' => __('详细提示内容'),
		'id' => 'gzhhide_box',
		'class' => 'op-multicheck',
		'std' => '请打开微信扫描右边的二维码回复数字2018获取密码，也可以微信直接搜索“唯爱网络”关注微信公众号获取密码。',
		'type' => 'textarea');	
	$options[] = array(
		'id' => 'gzhhide_code',
		'class' => 'op-multicheck',
		'std' => $imagepath . 'qrcode.png',
		'desc' => __('微信公众号二维码，建议图片尺寸：', 'haoui').'200x200px',
		'type' => 'upload');

		
	// ======================================================================================================================
	$options[] = array(
		'name' => __('社交', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('此处填写内容移置文章页左边栏', 'haoui'));

	$options[] = array(
		'name' => __('微博', 'haoui'),
		'id' => 'weibo',
		'std' => 'http://www.vizyw.com',
		'type' => 'text');

	$options[] = array(
		'name' => __('腾讯QQ', 'haoui'),
		'id' => 'qq',
		'std' => '1452938190',
		'type' => 'text');

	$options[] = array(
		'name' => __('微信帐号', 'haoui'),
		'id' => 'wechat',
		'std' => '唯爱网络',
		'type' => 'text');
	$options[] = array(
		'id' => 'wechat_qr',
		'std' => $imagepath . 'qrcode.png',
		'desc' => __('微信二维码，建议图片尺寸：', 'haoui').'200x200px',
		'type' => 'upload');

	// ======================================================================================================================
	$options[] = array(
		'name' => __('广告位', 'haoui'),
		'type' => 'heading' );  
	$options[] = array(
		'name' => __('全局右下角弹窗', 'haoui'),
		'id' => 'wintip_srollbar_s',
		'std' => false,
		'desc' => ' 显示',
		'type' => 'checkbox');	
	$options[] = array(
		'id' => 'wintip_m',
		'std' => false,
		'desc' => '手机端不显示',
		'type' => 'checkbox');	
/*	$options[] = array(
		'desc' => '时间/单位分钟',
		'id' => 'wintip_time',
		'std' => '10',
		'class' => 'mini',
		'type' => 'text');*/
	$options[] = array(
		'desc' => '名称',
		'id' => 'wintip_h2',
		'std' => '这绝对不是广告！',
		'type' => 'text');
	$options[] = array(
		'desc' => '标题',
		'id' => 'wintip_title',
		'std' => 'Vieu4.0主题',
		'type' => 'text');	
	$options[] = array(
		'desc' => '按钮文字',
		'id' => 'wintip_button',
		'std' => '了解一下',
		'type' => 'text');	
	$options[] = array(
		'desc' => '跳转链接',
		'id' => 'wintip_url',
		'std' => 'http://www.vizyw.com/3132.html',
		'type' => 'text');	
	$options[] = array(
		'id' => 'wintip_blank',
		'std' => false,
		'desc' => '新窗口打开',
		'type' => 'checkbox');	
	$options[] = array(
		'id' => 'wintip_img',
		'std' => $imagepath . 'wintip.png',
		'desc' => '广告图宽度为170px',
		'type' => 'upload');	
	$options[] = array(
		'desc' => __('内容'),
		'id' => 'wintip_asb',
		'std' => '专业打造轻量级个人企业风格博客主题！专注于前端开发，全站响应式布局自适应模板。',
		'type' => 'textarea');	
		
	$options[] = array(
		'name' => __('文章页正文结尾文字广告', 'haoui'),
		'id' => 'ads_post_footer_s',
		'std' => false,
		'desc' => ' 显示',
		'type' => 'checkbox');
	$options[] = array(
		'desc' => '前标题',
		'id' => 'ads_post_footer_pretitle',
		'std' => '唯爱网络',
		'type' => 'text');
	$options[] = array(
		'desc' => '标题',
		'id' => 'ads_post_footer_title',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'desc' => '链接',
		'id' => 'ads_post_footer_link',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'id' => 'ads_post_footer_link_blank',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'haoui') .' ('. __('新窗口打开链接', 'haoui').')');


	$options[] = array(
		'name' => __('首页文章列表上', 'haoui'),
		'id' => 'ads_index_01_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_index_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_index_01_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页分页下', 'haoui'),
		'id' => 'ads_index_02_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_index_02',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_index_02_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章页正文上', 'haoui'),
		'id' => 'ads_post_01_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_01_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章页正文下', 'haoui'),
		'id' => 'ads_post_02_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_02',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_02_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章页评论上', 'haoui'),
		'id' => 'ads_post_03_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_03',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_03_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分类页列表上', 'haoui'),
		'id' => 'ads_cat_01_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_cat_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_cat_01_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('标签页列表上', 'haoui'),
		'id' => 'ads_tag_01_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_tag_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_tag_01_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('搜索页列表上', 'haoui'),
		'id' => 'ads_search_01_s',
		'std' => false,
		'desc' => __('开启', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手机端', 'haoui').' '.$adsdesc,
		'id' => 'ads_search_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_search_01_m',
		'std' => '',
		'desc' => __('手机端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');



	// ======================================================================================================================
	$options[] = array(
		'name' => __('自定义代码', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('自定义网站底部内容', 'haoui'),
		'desc' => __('该块显示在网站底部版权上方，可已定义放一些链接或者图片之类的内容。', 'haoui'),
		'id' => 'fcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定义CSS样式', 'haoui'),
		'desc' => __('位于</head>之前，直接写样式代码，不用添加&lt;style&gt;标签', 'haoui'),
		'id' => 'csscode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定义头部代码', 'haoui'),
		'desc' => __('位于</head>之前，这部分代码是在主要内容显示之前加载，通常是CSS样式、自定义的<meta>标签、全站头部JS等需要提前加载的代码', 'haoui'),
		'id' => 'headcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定义底部代码', 'haoui'),
		'desc' => __('位于&lt;/body&gt;之前，这部分代码是在主要内容加载完毕加载，通常是JS代码', 'haoui'),
		'id' => 'footcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('网站统计代码', 'haoui'),
		'desc' => __('位于底部，用于添加第三方流量数据统计代码，如：Google analytics、百度统计、CNZZ、51la，国内站点推荐使用百度统计，国外站点推荐使用Google analytics', 'haoui'),
		'id' => 'trackcode',
		'std' => '',
		'type' => 'textarea');







	$options[] = array(
		'name' => __('百度熊掌号', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('百度熊掌号', 'haoui'),
		'id' => 'xzh_on',
		'std' => false,
		'desc' => ' 开启',
		'type' => 'checkbox');

	$options[] = array(
		'name' => '百度熊掌号 Appid',
		'id' => 'xzh_appid',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => '百度熊掌号 推送密钥 token',
		'id' => 'xzh_post_token',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('粉丝关注', 'haoui'),
		'id' => 'xzh_render_head',
		'std' => false,
		'desc' => ' 吸顶bar',
		'type' => 'checkbox');

	$options[] = array(
		'class' => 'op-multicheck',
		'id' => 'xzh_render_body',
		'std' => true,
		'desc' => ' 文章段落间bar',
		'type' => 'checkbox');

	$options[] = array(
		'class' => 'op-multicheck',
		'id' => 'xzh_render_tail',
		'std' => true,
		'desc' => ' 底部bar',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('添加JSON_LD数据', 'haoui'),
		'id' => 'xzh_jsonld_single',
		'std' => true,
		'desc' => ' 文章页',
		'type' => 'checkbox');

	$options[] = array(
		'class' => 'op-multicheck',
		'id' => 'xzh_jsonld_page',
		'std' => false,
		'desc' => ' 页面',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('添加JSON_LD数据 - 不添加图片', 'haoui'),
		'id' => 'xzh_jsonld_img',
		'std' => false,
		'desc' => ' 开启',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('新增文章实时推送', 'haoui'),
		'id' => 'xzh_post_on',
		'std' => false,
		'desc' => ' 开启 （使用此功能，你还需要开启本页中的 百度熊掌号 和 Appid以及token的设置）',
		'type' => 'checkbox');

	
	


	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */
/*
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Default Text Editor', 'options_framework_theme'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

*/

	return $options;
}