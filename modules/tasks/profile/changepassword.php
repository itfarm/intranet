<?php 
	@include_once('../config.php');
	# include the header
	global $szSection, $szSubSection, $szTitle, $szRootPath, $intDisplayLanguage;
	$szSection = 'Personal Tools';
	$szSubSection = 'Change Password';
	$szTitle = 'Change Password';
	@include('auth.php');
	
	$user = new pmo_auth();
	
	if ($_POST['change'] && $_POST['change']=="Change Password"){
		$arrUserInfo = $user->changepwd($_POST);
	}
	

?>
<form name="changepwd" method="post" action="<?php echo $profilePage ?>&tag=changepassword">
<input type="hidden" name="id" value="<?=$_SESSION['id']?>">
<input type="hidden" name="username" value="<?=$_SESSION['username']?>">
<table class="adminTable" width="100%" border="0" cellspacing="1" cellpadding="4" align="center">
        <tr> 
          <td colspan="2" class="adminHeader">Change Password</td>
        </tr>
		
   <!--	 message		-->
  <? if (isset($arrUserInfo['message'])){?>
  <tr valign="middle"> 
          <td class="adminRow2 smalltext header3" colspan="2" valign=top align="center"><?=$arrUserInfo['message']?></td>
  </tr>
  <? } ?>
    <!-- 	username	-->
  
  <tr valign="middle"> 
          <td class="important" valign=top>Username</td>
          <td class="important"><?=$_SESSION['username']?><br></td>
        </tr>

  
  <!-- 	oldpassword	-->
  
  <tr valign="middle"> 
          <td class="important" valign=top>Old Password*</td>
          <td class="adminRow2 smalltext"><input class=vform type="password" name="oldpasswd" size="20" maxlength="30" value="<?=$oldpasswd?>"><br></td>
        </tr>
  
  <!--	newpassword		-->
  
  <tr valign="middle"> 
          <td class="important" valign=top>New Password*</td>
          <td class="adminRow1 smalltext"><input class=vform type="password" name="newpasswd" size="20" maxlength="30" value="<?=$newpasswd?>"><br></td>
        </tr>
		
 <!--	newpassword		-->
  
  <tr valign="middle"> 
          <td class="important" valign=top>Confirm New Password*</td>
          <td class="adminRow2 smalltext"><input class=vform type="password" name="confirmpwd" size="20" maxlength="30" value="<?=$confirmpwd?>"><br></td>
        </tr>
		
  <!--	change button		-->
  
  <tr valign="middle">
          <td class="authTableFooter" colspan="2"><input type="submit" name="change" value="Change Password" class="button" onClick="return checkChangepwdForm()"><br></td>
        </tr>

	</table>
</form>
