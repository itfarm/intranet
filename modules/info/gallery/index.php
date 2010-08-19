<?php
require_once('root.php');
$skinFolder='default';
$page="index";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBAlbum;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'/index.php';
$crumbs[1]['name'] = $LBAlbum;
$crumbs[1]['url'] = $root_path.'modules/core/admin/gallery/index.php?menuid='.$menuid;
include($root_path.'modules/core/admin/gallery/config.inc.php');
include($root_path.'modules/core/admin/gallery/lib/gallery_functions.php');
?>

<?=$LBPhotoGallery ?>

   
</div>


	<link rel="stylesheet" type="text/css" href="style1.css" />

<div id="content">
     <!-- mycode start here     -->
                      <div id="outer">
    <div id="wrapper">
      <div id="">
        <div id="">
          <div id="logo">
      
           
          </div>
          <div id="nav">
             
            </ul>
            <div class="clear"> </div>
          </div>
        <div id="gallery">
  <div id="imagearea">
    <div id="image">
      <a href="javascript:slideShow.nav(-1)" class="imgnav " id="previmg"></a>
      <a href="javascript:slideShow.nav(1)" class="imgnav " id="nextimg"></a>
    </div>
  </div>
  <div id="thumbwrapper">
    <div id="thumbarea">
      <ul id="thumbs">
        <li value="1"><img src="thumbs/1.jpg" width="179" height="100" alt="" /></li>
        <li value="2"><img src="thumbs/2.jpg" width="179" height="100" alt="" /></li>
        <li value="3"><img src="thumbs/3.jpg" width="179" height="100" alt="" /></li>
        <li value="4"><img src="thumbs/4.jpg" width="179" height="100" alt="" /></li>
        <li value="5"><img src="thumbs/5.jpg" width="179" height="100" alt="" /></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
var imgid = 'image';
var imgdir = 'fullsize';
var imgext = '.jpg';
var thumbid = 'thumbs';
var auto = true;
var autodelay = 5;
</script>
<script type="text/javascript" src="slide.js"></script>
		<table align="center" width="100%"><tr style=" color:#FFF"><td>&nbsp;</td>
          <td style="font-size:9px">&nbsp;</td>
          <td style="font-size:9px">&nbsp;</td>
          </tr>
          </table>
        </div>
         
        </div>
      </div>
    </div>
  </div>
  
  <div id="copyright">
  
  </div>


</div>


 
				
<?php 
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
