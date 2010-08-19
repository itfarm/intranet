<?php
	@include_once('config.php');
	@include_once('config_imported/connect.inc.php');
	@include_once('config_imported/coresql.inc.php');
	@include_once('config_imported/functionsdate.inc.php');
	@include_once('config_imported/functionsgeneral.inc.php');
	@include_once('config_imported/functions.inc.php');
	// initialize host and database
    @include_once('config_imported/settings.inc.php');
	//@include_once('audittrail/utc_functions.php');
	

	if (isset($_GET['intUserID'])){
		$intUserID = $_GET['intUserID'];
	} else {
		unset($intUserID);
	}

?>

<table cellspacing="1" cellpadding="4" border="0" width=100%>
</table>

<script language="JavaScript">
	function confirm_delete(szURL){
		if (confirm('Are you sure you wish to delete this log entry?')){
			window.location.href = szURL;
		}
	}
	function confirm_clear(szURL){
		if (confirm('Are you sure you wish to clear the Log file?')){
			window.location.href = szURL;
		}
	}
</script>
<div class="scrolldown">
<table cellspacing="0" cellpadding="4" border="0" width=100% class="adminTable">
<tr>
	<td class="adminHeader">Full Name</td>
	<td class="adminHeader">Email</td>
	<td class="adminHeader">Status</td>
	<td class="adminHeader">Last Login</td>
</tr>
<?php 

	//Get All Users
	$arrUsers = utc_get_users(0,'id','');
	if (is_array($arrUsers)){
			$j=0;
		// loop around results
		foreach ($arrUsers as $arrUser) {
				if ($j%2){$rowclass = 'adminRow1';}else{$rowclass = 'adminRow2';}
				?>
				<tr class="<?=$rowclass?>">
					<td class="adminContent" valign=top><a href="<?php echo $audittrailPage?>&intUserID=<?=$arrUser['id']?>"><b><?=$arrUser['name']?>&nbsp;<?=$arrUser['surname']?></b></a>					</td>
					<td class="adminContent" valign=top><a href="mailto:<?=$arrUser['email']?>"><?=$arrUser['email']?></a></td>
					<td class="adminContent" valign=top><?=$arrUser['status']?></td>
					<td class="adminContent" valign=top><?=$arrUser['lastlogin']?></td>
				</tr>
				<tr class="adminRow1">
					<td class="adminContent" valign=top colspan="4">
						<?
							if ($intUserID==$arrUser['id']){
								$szWhereClause = " intUserID=$intUserID";
								$arrUserLogs = utc_get_user_logs(0,'intTimeStamp',$szWhereClause);
						?>
								<table cellpadding="4" cellspacing="0" border="0" style="border:1px solid #888888" width="100%">
									<tr bgcolor="#f2d05f">
										<td class="smalltext">IP Address</td>
										<td class="smalltext">Document ID</td>
										<td class="smalltext">Item ID</td>
										<td class="smalltext">Action</td>
										<td class="smalltext">Time Stamp</td>
									</tr>
						<?
								if (is_array($arrUserLogs)){
									foreach ($arrUserLogs as $arrUserLog){

							?>
										<tr>
											<td class="smalltext" valign=top><?=$arrUserLog['szIPAddress']?></td>
											<td class="smalltext" valign=top align="center"><?=$arrUserLog['intDocumentID']?></td>
											<? if ($arrUserLog['intItemID']==0){?>
											<td class="smalltext" valign=top align="center"><?=$arrUserLog['intItemID']?></td>
											<? } else { ?>
											<td class="smalltext" valign=top align="center"><a href="<?=$szRootURL?>/modules/news/admin/edit_item.php?intItemID=<?=$arrUserLog['intItemID']?>&intTypeID=<?=$arrUserLog['intTypeID']?>&intVariationID=<?=$arrUserLog['intVariationID']?>"><?=$arrUserLog['intItemID']?></a></td>
											<? } ?>
											<td class="smalltext" valign=top><?=$arrUserLog['szAction']?></td>
											<td class="smalltext" valign=top><?=$arrUserLog['intTimeStamp']?></td>
										</tr>
							<?
									} 
								} else {
						?>
									<tr>
										<td class="smalltext" valign="top" align="center" colspan="5">There is no log entries at present</td>
									</tr>
						<?
								}
						?>
								</table>
						<?
								}
						?>
					</td>
				</tr>
			<?
			$j++;
			}
		}
			?>
</table>
</div>
<?php 
	# include the footer
	include($szFooterPath);
?>
