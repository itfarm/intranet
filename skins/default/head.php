<?
session_start();
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
//define page for language selection
$page="index";
//load site path
require_once('root.php');
//language selector script
require_once($root_path.'js/lang_ajax.php');
//load important scripts
require_once($root_path.'cfg/config_db.php');
require_once($root_path.'cfg/christCMSconfig.php');
require_once($root_path.'core/class_core_christcms.php');



$christCMS=new christCMS;
//fetching all language list available
$sqlAll=$christCMS->get_language_all();
$resultAll = $christDB->f_ExecuteSql($sqlAll);
$recordcountAll = $christDB->f_GetSelectedRows();
$LBLanguage="Language";
$LBDate="Date";
?>
<span id="pageWindow">



<?
//fetching default language 
//var_dump($_GET);
$lgCode=$_GET['langCode'];
$menuid=$_GET['menuid'];
$submenuid=$_GET['submenuid'];
if($lgCode==''){
 //set default if no language selected
 $langCode='en';
}else{
 $langCode=$lgCode;
}

$langPath=$root_path.$cfgLanguagePath.$langCode.$cfgLanguageFile;
//including language file
require_once($langPath);
$skinFolder='default';

?>



 
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title><?=$LBSiteTitle.'-'.$LBHome?></title>
	
    <link href="<?=$root_path.'skins/'.$skinFolder.$cfgStyleFilePath?>" rel="stylesheet" type="text/css" />

 
<script language="JavaScript" src="<?=$root_path?>js/slidepics.js">//onload="runSlideShow()"</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


 

<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" id="container">
  <tr>
    <td width="960" align="left" valign="top" id="header"><!--header --><table width="960" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" rowspan="3" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/logo.jpg" width="200" height="150" /></td>
    <td width="730" align="left" valign="middle" class="topNavigation"><table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="380" align="left" valign="middle" background="<?=$root_path?>skins/default/images/top_navigation.jpg"><font color="#FFFFFF">
     
        <div><?=$LBLoginAs?>:&nbsp;&nbsp;<?=$_SESSION['userName']?>&nbsp;|&nbsp;<a href="<?=$root_path?>modules/core/security/changepasswd.php"><?=$LBChangePasswd?></a>
	&nbsp;|&nbsp;
	<a href="<?=$root_path?>modules/core/security/quit.php"><?=$LBLogout?>
        </div></td>
        <td width="10" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/top_navigation_curve.jpg" width="10" height="40" /></td>
      </tr>
    </table></td>
    <td width="30" rowspan="3" align="left" valign="top"  >&nbsp;</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="bannerImageCell" ><img src="<?=$root_path?>skins/default/images/banner_graph.jpg" width="510" height="80" /><img src="<?=$root_path?>skins/default/images/picture_01.jpg" alt="" width="220" height="80" /></td>
    </tr>
  <tr>
    <td align="left" valign="middle" class="navigation"><!--navigation --><?php 
   include($root_path.'skins/default/menu/menu_top_tab.php');
   ?></td>
    </tr>
</table>
</td>
  </tr>
  
  <tr>
    <td width="960" align="left" valign="top" ><table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="190" align="left" valign="top" id="sidebar_left"><!--sidebar left --><table width="190" border="0" cellpadding="0" cellspacing="0" background="<?=$root_path?>skins/default/images/news_bckgrd.gif">
  <tr>
    <td colspan="3" align="left" valign="top"></td>
  </tr>
  <tr>
    <td width="20" align="left" valign="top">&nbsp;</td>
    <td width="160" align="center" valign="top"><br />
      <br />
      <br />
      <script type="text/javascript">
var fadeimages=new Array()
//SET IMAGE PATHS. Extend or contract array as needed
fadeimages[0]=["<?=$root_path?>skins/default/images1/prod2.gif", "", ""] //plain image syntax
fadeimages[1]=[" <?=$root_path?>skins/default/images1/prod3.gif", "index.php?v=services#management_software", ""] //image with link syntax
fadeimages[2]=["<?=$root_path?>skins/default/images1/prod1.gif", "", ""] //image with link and target syntax
fadeimages[3]=["<?=$root_path?>skins/default/images1/prod4.gif", "", ""] //image with link and target syntax


 
var fadeimages2=new Array() //2nd array set example. Remove or add more sets as needed.
//SET IMAGE PATHS. Extend or contract array as needed
fadeimages2[0]=["photo1.jpg", "", ""] //plain image syntax
fadeimages2[1]=["photo2.jpg", "http://www.cssdrive.com", ""] //image with link syntax
fadeimages2[2]=["photo3.jpg", "http://www.javascriptkit.com", "_new"] //image with link and target syntax
 
var fadebgcolor="black"

////NO need to edit beyond here/////////////
 
var fadearray=new Array() //array to cache fadeshow instances
var fadeclear=new Array() //array to cache corresponding clearinterval pointers
 
var dom=(document.getElementById) //modern dom browsers
var iebrowser=document.all
 
function fadeshow(theimages, fadewidth, fadeheight, borderwidth, delay, pause, displayorder){
this.pausecheck=pause
this.mouseovercheck=0
this.delay=delay
this.degree=10 //initial opacity degree (10%)
this.curimageindex=0
this.nextimageindex=1
fadearray[fadearray.length]=this
this.slideshowid=fadearray.length-1
this.canvasbase="canvas"+this.slideshowid
this.curcanvas=this.canvasbase+"_0"
if (typeof displayorder!="undefined")
theimages.sort(function() {return 0.5 - Math.random();}) //thanks to Mike (aka Mwinter) :)
this.theimages=theimages
this.imageborder=parseInt(borderwidth)
this.postimages=new Array() //preload images
for (p=0;p<theimages.length;p++){
this.postimages[p]=new Image()
this.postimages[p].src=theimages[p][0]
}
 
var fadewidth=fadewidth+this.imageborder*2
var fadeheight=fadeheight+this.imageborder*2
 
if (iebrowser&&dom||dom) //if IE5+ or modern browsers (ie: Firefox)
document.write('<div id="master'+this.slideshowid+'" style="position:relative;width:'+fadewidth+'px;height:'+fadeheight+'px;overflow:hidden;"><div id="'+this.canvasbase+'_0" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);opacity:0.1;-moz-opacity:0.1;-khtml-opacity:0.1;background-color:'+fadebgcolor+'"></div><div id="'+this.canvasbase+'_1" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);opacity:0.1;-moz-opacity:0.1;-khtml-opacity:0.1;background-color:'+fadebgcolor+'"></div></div>')
else
document.write('<div><img name="defaultslide'+this.slideshowid+'" src="'+this.postimages[0].src+'"></div>')
 
if (iebrowser&&dom||dom) //if IE5+ or modern browsers such as Firefox
this.startit()
else{
this.curimageindex++
setInterval("fadearray["+this.slideshowid+"].rotateimage()", this.delay)
}
}

function fadepic(obj){
if (obj.degree<100){
obj.degree+=10
if (obj.tempobj.filters&&obj.tempobj.filters[0]){
if (typeof obj.tempobj.filters[0].opacity=="number") //if IE6+
obj.tempobj.filters[0].opacity=obj.degree
else //else if IE5.5-
obj.tempobj.style.filter="alpha(opacity="+obj.degree+")"
}
else if (obj.tempobj.style.MozOpacity)
obj.tempobj.style.MozOpacity=obj.degree/101
else if (obj.tempobj.style.KhtmlOpacity)
obj.tempobj.style.KhtmlOpacity=obj.degree/100
else if (obj.tempobj.style.opacity&&!obj.tempobj.filters)
obj.tempobj.style.opacity=obj.degree/101
}
else{
clearInterval(fadeclear[obj.slideshowid])
obj.nextcanvas=(obj.curcanvas==obj.canvasbase+"_0")? obj.canvasbase+"_0" : obj.canvasbase+"_1"
obj.tempobj=iebrowser? iebrowser[obj.nextcanvas] : document.getElementById(obj.nextcanvas)
obj.populateslide(obj.tempobj, obj.nextimageindex)
obj.nextimageindex=(obj.nextimageindex<obj.postimages.length-1)? obj.nextimageindex+1 : 0
setTimeout("fadearray["+obj.slideshowid+"].rotateimage()", obj.delay)
}
}
 
fadeshow.prototype.populateslide=function(picobj, picindex){
var slideHTML=""
if (this.theimages[picindex][1]!="") //if associated link exists for image
slideHTML='<a href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'">'
slideHTML+='<img src="'+this.postimages[picindex].src+'" border="'+this.imageborder+'px">'
if (this.theimages[picindex][1]!="") //if associated link exists for image
slideHTML+='</a>'
picobj.innerHTML=slideHTML
}
 
 
fadeshow.prototype.rotateimage=function(){
if (this.pausecheck==1) //if pause onMouseover enabled, cache object
var cacheobj=this
if (this.mouseovercheck==1)
setTimeout(function(){cacheobj.rotateimage()}, 100)
else if (iebrowser&&dom||dom){
this.resetit()
var crossobj=this.tempobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
crossobj.style.zIndex++
fadeclear[this.slideshowid]=setInterval("fadepic(fadearray["+this.slideshowid+"])",50)
this.curcanvas=(this.curcanvas==this.canvasbase+"_0")? this.canvasbase+"_1" : this.canvasbase+"_0"
}
else{
var ns4imgobj=document.images['defaultslide'+this.slideshowid]
ns4imgobj.src=this.postimages[this.curimageindex].src
}
this.curimageindex=(this.curimageindex<this.postimages.length-1)? this.curimageindex+1 : 0
}
 
fadeshow.prototype.resetit=function(){
this.degree=10
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
if (crossobj.filters&&crossobj.filters[0]){
if (typeof crossobj.filters[0].opacity=="number") //if IE6+
crossobj.filters(0).opacity=this.degree
else //else if IE5.5-
crossobj.style.filter="alpha(opacity="+this.degree+")"
}
else if (crossobj.style.MozOpacity)
crossobj.style.MozOpacity=this.degree/101
else if (crossobj.style.KhtmlOpacity)
crossobj.style.KhtmlOpacity=this.degree/100
else if (crossobj.style.opacity&&!crossobj.filters)
crossobj.style.opacity=this.degree/101
}
 
 
fadeshow.prototype.startit=function(){
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
this.populateslide(crossobj, this.curimageindex)
if (this.pausecheck==1){ //IF SLIDESHOW SHOULD PAUSE ONMOUSEOVER
var cacheobj=this
var crossobjcontainer=iebrowser? iebrowser["master"+this.slideshowid] : document.getElementById("master"+this.slideshowid)
crossobjcontainer.onmouseover=function(){cacheobj.mouseovercheck=1}
crossobjcontainer.onmouseout=function(){cacheobj.mouseovercheck=0}
}
this.rotateimage()
}
</script>
<script language="javascript" type="text/javascript">

//new fadeshow(IMAGES_ARRAY_NAME, slideshow_width, slideshow_height, borderwidth, delay, pause (0=no, 1=yes), optionalRandomOrder)

new fadeshow(fadeimages, 90, 112, 0, 3000, 1, "R");

</script>
<br /><br />
<script language="javascript" type="text/javascript">

new fadeshow(fadeimages, 90, 112, 0, 3000, 1, "R");

</script>
<br />
<br /> </td>
    <td width="10" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><img src="<?=$root_path?>skins/default/images/news_footer.jpg" width="190" height="10" /></td>
    </tr>
</table>
</td>
        <td width="" align="left" valign="top" id="content" >			

<!-- ########## header ends ######## -->
