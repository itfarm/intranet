<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#
##################################################################################
*/
require_once('root.php');
$skinFolder='default';
$page="feedback";
require_once($root_path.'skins/'.$skinFolder.'/head.php');
$LBSection=$LBFeedback;
$crumbs[0]['name'] = $LBHome;
$crumbs[0]['url'] = $root_path.'index.php';
$crumbs[1]['name'] = $LBContacts;
$crumbs[1]['url'] = $root_path.'modules/pages/contacts/index.php?menuid='.$menuid;
$crumbs[2]['name'] = $LBFeedback;
$crumbs[2]['url'] = $root_path.'modules/pages/contacts/feedback.php?menuid='.$menuid.'&submenuid='.$submenuid;
?><style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style1 {font-family: "Times New Roman", Times, serif}
-->
</style>


<div id="content">
	<?=$LBBreadScrumb.'&nbsp;:&nbsp;'?>
    <?php 
	     $cnum = count($crumbs);
		 for($i = 0; $i < $cnum; $i++)
		 {
		 	echo '&nbsp>><a href="'.$crumbs[$i]['url'].'">'.$crumbs[$i]['name'].'</a>';
		 }
				   
	?> 
</div>

<div id="content"><? //=$LBPageTitle.$LBSection?></div>

<div id="content">
<div>
&nbsp;
</div>
 <?       if (isset($_POST['send']) && $_POST['send']=='Submit'){
	
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$my_email = $_POST['my_email'];
		$comment = $_POST['comment'];
		$email_sent_to = 'info@wdmi.ac.tz';
		$subject = "Feedback from  ".$LBSiteTitle." - " . $_POST['subject'];
		$todayis = date("l, F j, Y, g:i a") ;

		$notes = stripcslashes($notes);

		$message = " $todayis [EST] \n
		Message: $comment \n
		From: $firstname $lastname ($my_email)\n
		";

		$from = "From: $my_email\r\n";

		mail($email_sent_to, $subject, $message, $from);
?>
		<div class="content">
			Thanks for your feedback.We will respond to your feedback as soon as possible.
		</div>
<?
	} else {
?>




 <?=$LBSiteTitle?> would like to receive your feedback and we will respond as soon as possible.
<br><br>
<form action="#" method="post" name="comments">

	<table border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td class="content"><font size="2">First name</font> </td>	
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="Text" class="vform" name="firstname" value="<?=$firstname?>" size="40" /></td>
      </tr>
      <tr>
        <td class="content"><font size="2">Surname *</font></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="Text" class="vform" name="lastname" value="<?=$lastname?>" size="40" /></td>
      </tr>
      <tr>
        <td class="content"><font size="2">Email *</font></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="Text" class="vform" name="my_email" value="<?=$my_email?>" size="40" /></td>
      </tr>
      <tr>
        <td class="content"><font size="2">Subject *</font></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="Text" class="vform" name="subject" value="<?=$subject?>" size="40" /></td>
      </tr>
      <tr valign="top">
        <td class="content"><font size="2">Feedback *</font></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><textarea name="comment" class="vform" cols="40" rows="10"><?=$comment?></textarea></td>

      </tr>
      <tr valign="top">
        <td>&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="submit" class="button" name="send" value="Submit" onClick="return validateForm()"></td>
      </tr>
    </table>
  </form>
  <p>Field * must be filled</p>

<Script Language = "Javascript">
 
 function validateForm(){
		var my = document.comments
		
		if ((my.lastname.value=="")|| (my.lastname.value==null)){
			alert('Please enter your Last name!');
			my.lastname.focus();
			return false;
		}
		if ((my.my_email.value=="")||(my.my_email.value==null)){
			alert('Please enter your Email Address!');
			my.my_email.focus();
			return false;
		}
		if (echeck(my.my_email.value)==false){
			my.my_email.value=""
			my.my_email.focus()
			return false
		}
		if ((my.subject.value=="")|| (my.subject.value==null)){
			alert('Please enter the subject!');
			my.subject.focus();
			return false;
		}
		if ((my.comment.value=="")|| (my.comment.value==null)){
			alert('Please enter your Enquiries!');
			my.comment.focus();
			return false;
		}
		return true;
	}

	function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail Address")
		   return false
		}
		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail Address")
		   return false
		}
		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail Address")
		    return false
		}
		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail Address")
		    return false
		 }
		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail Address")
		    return false
		 }
		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail Address")
		    return false
		 }
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail Address")
		    return false
		 }
 		 return true					
	}

</script>

<?
	}
?>
			  </p>
                                                          </div>

<?  
require_once($root_path.'skins/'.$skinFolder.'/tail.php');
?>
