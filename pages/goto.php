<?php
    /*
    Template Name: 外链跳转“go”)
    */ 
if(strlen($_SERVER['REQUEST_URI']) > 384 ||  
    strpos($_SERVER['REQUEST_URI'], "eval(") ||  
    strpos($_SERVER['REQUEST_URI'], "base64")) {  
        @header("HTTP/1.1 414 Request-URI Too Long");  
        @header("Status: 414 Request-URI Too Long");  
        @header("Connection: Close");  
        @exit;  
}   
$str=$_GET['url'];
 $t_url=base64_decode($str);
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i',$t_url,$matches);  
    if($matches){  
        $url=$t_url;  
        $title='提示：您即将访问未知链接';  
    } else {  
        preg_match('/\./i',$t_url,$matche);  
        if($matche){  
            $url='http://'.$t_url;  
            $title='提示：您即将访问未知链接';  
        } else {  
            $url = 'http://'.$_SERVER['HTTP_HOST'];  
            $title='参数错误，正在返回首页...';  
        }  
    }  

?>  
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="5;url='<?php echo $url;?>';">
<title><?php echo $title;?></title>
<div id="circle"></div>
<div id="circletext"></div>
<div id="circle1"></div>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="1;url='<?php echo $url;?>';">
<title><?php echo $title;?></title>
<style>
<style type="text/css">
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}body{background:#3498db;}#loader-container{width:188px;height:188px;color:white;margin:0 auto;position:absolute;top:50%;left:50%;margin-right:-50%;transform:translate(-50%,-50%);border:5px solid #3498db;border-radius:50%;-webkit-animation:borderScale 1s infinite ease-in-out;animation:borderScale 1s infinite ease-in-out;}#loadingText{font-family:'Raleway',sans-serif;font-size:1.4em;position:absolute;top:50%;left:50%;margin-right:-50%;transform:translate(-50%,-50%);}@-webkit-keyframes borderScale{0%{border:5px solid white;}50%{border:25px solid #3498db;}100%{border:5px solid white;}}@keyframes borderScale{0%{border:5px solid white;}50%{border:25px solid #3498db;}100%{border:5px solid white;}}
</style>
</style></head>
<body>
<div id="loader-container"><p id="loadingText">页面加载中...</p></div>
</body>
</html>