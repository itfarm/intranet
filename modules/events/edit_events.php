<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$page="edit_events";
$adminMain="Events";
require_once($root_path.'modules/core/admin/skin/head.php');
$LBSection=$LBEventsAdmin;
$crumbs[0]['name'] = $LBAdminHome;
$crumbs[0]['url'] = $root_path.'modules/core/admin/index.php';
$crumbs[1]['name'] = $LBEventsAdmin;
$crumbs[1]['url'] = $root_path.'modules/core/admin/events/index.php?menuid='.$menuid;
    
    if (isset($_POST['submitBtn'])) {
	     $eventID     = $_POST['id'] ;
         $eventTitle     = $_POST['eventTitle'] ;
         $eventSummary  = $_POST['eventSummary'] ;
         $eventBody = $_POST['eventBody'];
		 $eventLocation  = $_POST['eventLocation'];
         $categoryID = $_POST['categoryID'] ;
         $langCode = $_POST['langCode'];
		 $archieve  = $_POST['archieve'];
         $dtCreated    = $_POST['dtCreated'];
		 $startDt  =$_POST['startDt'];
		 $endDt    =$_POST['endDt'];
         //adding entry
		 $sql=$christCMS->update_event_single($eventID,$eventTitle,$eventSummary,$eventBody,$eventLocation,$categoryID,$langCode,$startDt,$endDt,$dtUpdated,$archive);
		 $christDB->f_ExecuteSql($sql);
		 $arrErrorUp=$christDB->f_GetSqlError();
		 if(!empty($arrErrorUp['message'])){
		   echo $arrErrorUp['message'].$LBUpdateError.$arrErrorUp['code'];
		 }
    }else{
		$eventID=$_GET['eventID'];
		$categoryID=$_GET['categoryID'];
		$sqlgetn=$christCMS->get_event_single($eventID,$categoryID,$langCode,$archive);
		$resultn = $christDB->f_ExecuteSql($sqlgetn);
		$recordcount = $christDB->f_GetSelectedRows();
		$arrEvent = $christDB->f_GetRecord($resultn);
		$arrError=$christDB->f_GetSqlError();
	
	}
  // echo $menuid;

?>



<div class="sectionLabel">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
			//var_dump($arrLangRow = $christDB->f_GetRecord($resultAll));	   
	?> 
</div>
<div>&nbsp;</div>
<div><?=$LBPageTitle.'&nbsp;:&nbsp;'.$LBSection?></div>
<div>&nbsp;</div>
<div class="line"></div>
<div>&nbsp;</div>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?menuid=<?=$menuid?>" method="post" name="events" id="events">
		  <input type="Hidden" name="menuid" id="menuid" value="<?=$menuid?>" >
		  <input type="Hidden" name="id" id="id" value="<?=$arrEvent['id']?>" >
            <table align="center"cellspacing="1" cellpadding="5" border="0" width="70%" >
              <tr><td><?=$LBcontTitle?>:</td><td><input name="eventTitle" id="eventTitle" type="text" size="30" maxlength="50"value="<?=$arrEvent['eventTitle']?>"  class="select" /></td></tr>
              <tr><td valign="top"><?=$LBSummary?>:</td><td><textarea name="eventSummary" id="eventSummary" cols="50" rows="15"><?=$arrEvent['eventSummary']?></textarea></td></tr>
			  <tr><td valign="top"><?=$LBBody?>:</td><td><textarea name="eventBody" id="eventBody" cols="50" rows="15"><?=$arrEvent['eventBody']?></textarea></td></tr>
			  <tr><td valign="top"><?=$LBLocation?>:</td><td><textarea name="eventLocation" id="eventLocation" cols="50" rows="15"><?=$arrEvent['eventLocation']?></textarea></td></tr>
              <tr><td><?=$LBCategory?>:</td><td>   
								   <select name="categoryID" id="categoryID" style="width:100px;"class="select">
								   <option value=""></option>
								   <?php 
								   $sqlcat=$christCMS->get_cat_items($langCode);
								   $resultcat = $christDB->f_ExecuteSql($sqlcat);
								   $recordcountcat = $christDB->f_GetSelectedRows();
								   while ($arrCatRow = $christDB->f_GetRecord($resultcat)) { ?>
								    <option value="<?=$arrCatRow['categoryID']?>"<?if($arrCatRow['categoryID']==$arrEvent['categoryID']){echo 'selected';}?>><?=$arrCatRow['catTitle']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
			  <tr><td><?=$LBLanguage?>:</td><td>   
								   <select name="langCode" id="langCode" class="select">
								   <option value=""></option>
								   <?php 
								   $sqlAll=$christCMS->get_language_all();
								   $resultAll = $christDB->f_ExecuteSql($sqlAll);
								   $recordcountAll = $christDB->f_GetSelectedRows();
								   while ($arrLangRow = $christDB->f_GetRecord($resultAll)) { ?>
								    <option value="<?=$arrLangRow['langCode']?>" <?if($arrLangRow['langCode']==$arrEvent['langCode']){echo 'selected';}?>><?=$arrLangRow['langCaption']?></option>
								   <?php } ?>
								   </select>                      
                                    </td>
              </tr>
			  <tr><td><?=$LBArchieve?></td><td>
						                       <select name="archieve" id="archieve" class="select">
											   <option value="No"<?if($arrEvent['newsArchieve']=='No'){echo 'selected';}?>><?=$LBNo?></option>
											   <option value="Yes"<?if($arrEvent['newsArchieve']=='Yes'){echo 'selected';}?>><?=$LBYes?></option>
											   </select> 
			                                </td>
			  </tr>
			  <tr><td><?=$LBStartDt?>:</td><td><input name="startDt" id="startDt" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('events.startDt');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>

			  </td></tr>
			  <tr><td><?=$LBEndDt?>:</td><td><input name="endDt" id="endDt" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('events.endDt');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>

			  </td></tr>
              <tr><td><?=$LBcontDate?>:</td><td><input name="dtCreated" id="dtCreated" type="text" size="30"style="width:100px;" class="select" />
                       <!-- ggPosX and ggPosY not set, so popup will autolocate to the right of the graphic -->
	                   <a href="javascript:show_calendar('events.dtCreated');" onMouseOver="window.status='Date Picker'; overlib('<?=$LBdtText?>'); return true;" onMouseOut="window.status=''; nd(); return true;">
					   <img src="<?=$root_path?>images/icons/pickdt.png" width=16 height=16 border=0></a>

			  </td></tr>
              
              <tr><td colspan="2" align="center"><input  type="submit" name="submitBtn" value="<?=$LBeditEvent?>" class="button" /></td></tr>
            </table>  
          </form>
  </div>
     
 
<?
require_once($root_path.'modules/core/admin/skin/tail.php');
?>