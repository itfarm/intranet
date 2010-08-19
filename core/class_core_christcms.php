<?
/*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#class christCMS is the core class with all queries
##################################################################################
*/


class christCMS{
    #########################################################################################
	#***************************guestbook fuctions*******************************************
	#########################################################################################
	/*
	**function to fetch list of guest from database
	*/
	function get_guest_list(){
		$sql = "SELECT * FROM tbl_christcms_guestbook ORDER BY insertdate DESC";
		return  $sql;
	}
	/*
	**function to add guest into database
	*/
    function add_guest($name,$comment,$location,$website,$email,$actDate){
		$sql = "INSERT INTO tbl_christcms_guestbook (name,text,insertdate,location,web,email) VALUES (";
		$sql .= "'".$name."','".$comment."','".$actDate."','".$location."','".$website."','".$email."')";
		return  $sql;
    }
	#########################################################################################
	#***************************language fuctions********************************************
	#########################################################################################
    /*
	**function to get language file
	*/
	    function get_language_single($langCode){
		$sql = "SELECT * FROM tbl_christcms_setuplang WHERE langCode='$langCode'";
		return  $sql;
    }
	 /*
	**function to get list of available language files
	*/
	    function get_language_all(){
		$sql = "SELECT * FROM tbl_christcms_setuplang";
		return  $sql;
    }
	#########################################################################################
	#***************************menu fuctions************************************************
	#########################################################################################
	 /*
	**function to get main menu item
	*/
	    function get_main_menu($langCode){
		$sql = "SELECT * FROM tbl_christcms_mainmenu WHERE mstatus='visible' AND langCode='$langCode'";
		return  $sql;
    }
	 /*
	**function to get sub menu item for specific menu
	*/
	    function get_sub_menu($langCode,$menuid){
		$sql = "SELECT * FROM tbl_christcms_submenu WHERE smstatus='visible' AND langCode='$langCode' AND menuid='$menuid' ORDER BY id";
		return  $sql;
    }
	 /*
	**function to get sub menu item for information for
	*/
	    function get_infofor_menu($langCode){
		$sql = "SELECT * FROM tbl_christcms_submenu WHERE smstatus='visible' AND langCode='$langCode' AND smsection='Front'  ORDER BY id";
		return  $sql;
    }
	 /*
	**function to get sub menu item for information about
	*/
	    function get_infoabout_menu($langCode){
		$sql = "SELECT * FROM tbl_christcms_submenu WHERE smstatus='visible' AND langCode='$langCode' AND smsection='Left'  ORDER BY id";
		return  $sql;
    }
	/*
	**function to get main menu item single
	*/
	    function get_main_menu_single($id,$langCode){
		$sql = "SELECT * FROM tbl_christcms_mainmenu WHERE mstatus='visible' AND langCode='$langCode' AND id='$id'";
		return  $sql;
    }
	 /*
	**function to get sub menu item single
	*/
	    function get_sub_menu_single($id,$langCode){
		$sql = "SELECT * FROM tbl_christcms_submenu WHERE smstatus='visible' AND langCode='$langCode' AND id='$id'";
		return  $sql;
    }
	
			 /*
	**function to get admin main menu item
	*/
	    function get_admin_main_menu($langCode){
		$sql = "SELECT * FROM tbl_christcms_adminmenu WHERE mstatus='visible' AND langCode='$langCode'";
		return  $sql;
    }
	 /*
	**function to get admin sub menu item for specific menu
	*/
	    function get_admin_sub_menu($langCode,$menuid){
		$sql = "SELECT * FROM tbl_christcms_adminsub WHERE mstatus='visible' AND langCode='$langCode' AND menuid='$menuid' ORDER BY submenu";
		return  $sql;
    }
	/*
	**function to get admin main menu item single
	*/
	    function get_admin_main_menu_single($id,$langCode){
		$sql = "SELECT * FROM tbl_christcms_adminmenu WHERE mstatus='visible' AND langCode='$langCode' AND id='$id'";
		return  $sql;
    }
	 /*
	**function to get admin sub menu item single
	*/
	    function get__admin_sub_menu_single($id,$langCode){
		$sql = "SELECT * FROM tbl_christcms_adminsub WHERE mstatus='visible' AND langCode='$langCode' AND id='$id'";
		return  $sql;
    }
	#########################################################################################
	#***************************page fuctions************************************************
	#########################################################################################
	
	 /*
	**function to add page
	*/
	 function add_page($pageID,$pageTitle,$pageContent,$langCode,$dtCreated,$pageStatus){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($pageStatus==''){
		    $pageStatus='visible';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_pages(pageID,pageTitle,pageContent,langCode,dtUpdated,pageStatus)
		         VALUES('$pageID','$pageTitle','$pageContent','$langCode','$dtCreated','$pageStatus')";
		 return  $sql;
     }
     
     ################
 function add_project_category($categoryID,$category,$description,$langCode){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_cont_category(id,category,description,langCode)
		         VALUES('$categoryID','$category','$description','$langCode')";
		 return  $sql;
     }
     
function add_project_status($statusID,$status,$description,$langCode){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_cont_status(id,status,description,langCode)
		         VALUES('$statusID','$status','$description','$langCode')";
		 return  $sql;
     }
     ###########
	 /*
	**function to get all pages
	*/
	    function get_all_pages(){
		$sql = "SELECT * FROM tbl_christcms_pages";
		return  $sql;
    }
    
function get_all_category(){
		$sql = "SELECT * FROM tbl_christcms_cont_category";
		return  $sql;
    }
    
function get_all_status(){
		$sql = "SELECT * FROM tbl_christcms_cont_status";
		return  $sql;
    }
	 /*
	**function to  single page
	*/
	    function get_page_single($pageID,$langCode){
		$sql = "SELECT * FROM tbl_christcms_pages WHERE pageStatus='visible' AND langCode='$langCode' AND pageID='$pageID'";
		return  $sql;
     }
	
	/*
	**function to  single page to display
	*/
	    function get_page_display($menuid,$langCode){
		   $sql = "SELECT * FROM tbl_christcms_pages,tbl_christcms_menupage_mapping
		           WHERE tbl_christcms_pages.pageStatus='visible' 
				   AND tbl_christcms_pages.langCode='$langCode' 
				   AND tbl_christcms_pages.pageID=tbl_christcms_menupage_mapping.pageID
				   AND tbl_christcms_menupage_mapping.menuid='$menuid'";
		return  $sql;
     }
	 /*
	**function to delete page
	*/
	    function delete_page_single($pageID,$langCode){
		$sql = "DELETE FROM tbl_christcms_pages WHERE  langCode='$langCode' AND pageID='$pageID'";
		return  $sql;
    }
	 /*
	**function to update page
	*/
	    function update_page_single($pageID,$pageTitle,$pageContent,$langCode,$dtCreated,$pageStatus){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($pageStatus==''){
		    $pageStatus='visible';
		 }
		$sql = "UPDATE tbl_christcms_pages 
		        SET pageTitle='$pageTitle',
					pageContent='$pageContent',
					langCode='$langCode',
					dtUpdated='$dtCreated',
					pageStatus='$pageStatus'
		        WHERE pageID='$pageID'";
		return  $sql;
    }
	#########################################################################################
	#***************************news fuctions************************************************
	#########################################################################################
	
	 /*
	**function to news page
	*/
	 function add_news($newsTitle,$newsSummary,$newsBody,$categoryID,$langCode,$dtCreated,$archive,$newsGroup){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($archive==''){
		    $archive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		 if($newsGroup==''){
		    $newsGroup='N';
		 }
		 $sql = "INSERT INTO tbl_christcms_news(newsTitle,newsSummary,newsBody,categoryID,langCode,dtCreated,newsArchive,newsGroup)
		         VALUES('$newsTitle','$newsSummary','$newsBody','$categoryID','$langCode','$dtCreated','$archive','$newsGroup')";
		 return  $sql;
     }
     
     
function add_project($categoryID,$projectTitle,$projectSummary,$projectObjective,$langCode,$dtStarted,$dtEnded,$archive,$projectResult,$status){
		 if ($dtStarted==''){
		    $dtStarted=date('Y-m-d');
		 }
		
		 if($archive==''){
		    $archive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		 
		 $sql = "INSERT INTO tbl_christcms_project(categoryID,projectTitle,projectSummary,projectObjective,langCode,dtStarted,dtEnded,projectArchive,projectResult,status)
		         VALUES('$categoryID','$projectTitle','$projectSummary','$projectObjective','$langCode','$dtStarted','$dtEnded','$archive','$projectResult','$status')";
		 return  $sql;
     }
     
function add_partner($partnerName,$partnerMission,$partnerVision,$langCode,$partnerEmail,$partnerContact,$partnerWebsite){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		 
		 $sql = "INSERT INTO tbl_christcms_partner(partnerName,partnerMission,partnerVision,langCode,email,contact,website)
		         VALUES('$partnerName','$partnerMission','$partnerVision','$langCode','$partnerEmail','$partnerContact','$partnerWebsite')";
		 return  $sql;
     }
	 /*
	**function to get all news
	*/
	    function get_news_items($categoryID,$langCode,$archive,$limitNews){
			if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_news 
			        WHERE langCode='$langCode' AND
						  newsArchive='$archive'";
					if($categoryID!=''){
			           $sql=$sql." AND categoryID='$categoryID'";
			         }
					if($limitNews!=''){
					    $sql=$sql."LIMIT 0,$limitNews";
					 }
		return  $sql;
    }
    
function get_partner_items($partnerID,$langCode,$sqllimit){
			
			$sql = "SELECT * FROM tbl_christcms_partner 
			        WHERE langCode='$langCode' ";
					if($partnerID!=''){
			           $sql=$sql." AND id='$partnerID'";
			         }
					if($sqllimit!=''){
					    $sql=$sql.$sqllimit;
					 }
		return  $sql;
    }
    
function get_cont_category_items($categoryID,$langCode,$sqllimit){
			
			$sql = "SELECT * FROM tbl_christcms_cont_category 
			        WHERE langCode='$langCode' ";
					if($categoryID!=''){
			           $sql=$sql." AND id='$categoryID'";
			         }
					if($sqllimit!=''){
					    $sql=$sql.$sqllimit;
					 }
		return  $sql;
    }
    
function get_cont_status_items($statusID,$langCode,$sqllimit){
			
			$sql = "SELECT * FROM tbl_christcms_cont_status 
			        WHERE langCode='$langCode' ";
					if($statusID!=''){
			           $sql=$sql." AND id='$statusID'";
			         }
					if($sqllimit!=''){
					    $sql=$sql.$sqllimit;
					 }
		return  $sql;
    }
    
    
    
function get_project_items($projectID,$categoryID,$langCode,$archive,$statusID,$sqllimit){
			if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_project 
			        WHERE langCode='$langCode' AND
						  projectArchive='$archive'";
					if($statusID!=''){
			           $sql=$sql." AND status='$statusID'";
			         }
					if($projectID!=''){
			           $sql=$sql." AND id='$projectID'";
			         }
					if($categoryID!=''){
			           $sql=$sql." AND categoryID='$categoryID'";
			         }
			         $sql=$sql." ORDER BY status ";
					if($sqllimit!=''){
					    $sql=$sql.$sqllimit;
					 }
		return  $sql;
    }
	 /*
	**function to  single news
	*/
	    function get_news_single($newsID,$categoryID,$langCode,$archive){
            if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_news 
			        WHERE langCode='$langCode' AND
						  newsArchive='$archive' AND
						  id='$newsID'";
					if($categoryID!=''){
			           $sql=$sql." AND categoryID='$categoryID'";
			         }
		return  $sql;
     }
     
     function get_partner_single($partnerID,$langCode){
            
			$sql = "SELECT * FROM tbl_christcms_partner
			        WHERE langCode='$langCode' AND id='$partnerID'";
						  
					
		return  $sql;
     }
     
     
     function get_cont_category_single($categoryID,$langCode){
            
			$sql = "SELECT * FROM tbl_christcms_cont_category
			        WHERE langCode='$langCode' AND id='$categoryID'";
						  
					
		return  $sql;
     }
     
function get_cont_status_single($statusID,$langCode){
            
			$sql = "SELECT * FROM tbl_christcms_cont_status
			        WHERE langCode='$langCode' AND id='$statusID'";
						  
					
		return  $sql;
     }
     
     
     
function get_project_single($projectID,$langCode,$archive){
            if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_project 
			        WHERE langCode='$langCode' AND
						  projectArchive='$archive' AND
						  id='$projectID'";
					
		return  $sql;
     }
	 
	  /*
	**function to  highlights
	*/
	    function get_highlights($langCode,$limitHighlights){
            
			$sql = "SELECT * FROM tbl_christcms_news 
			        WHERE newsGroup='H' OR newsGroup='HN'
					LIMIT 0,$limitHighlights";
					
		return  $sql;
     }
	 /*
	**function to delete news
	*/
	    function delete_news_single($newsID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_news  WHERE  langCode='$langCode' AND id='$newsID'";
		return  $sql;
    }
    
 function delete_cont_category_single($categoryID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_cont_category  WHERE  langCode='$langCode' AND id='$categoryID'";
		return  $sql;
    }
    
 function delete_cont_status_single($statusID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_cont_status  WHERE  langCode='$langCode' AND id='$statusID'";
		return  $sql;
    }
    
    
function delete_partner_single($partnerID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_partner  WHERE  langCode='$langCode' AND id='$partnerID'";
		return  $sql;
    }
    
function delete_project_single($projectID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_project  WHERE  langCode='$langCode' AND id='$projectID'";
		return  $sql;
    }
	 /*
	**function to update page
	*/
	    function update_news_single($newsID,$newsTitle,$newsSummary,$newsBody,$categoryID,$langCode,$dtUpdated,$archive,$newsGroup){
		 if ($dtUpdated==''){
		    $dtUpdated=date('Y-m-d');
		 }
		 if($archive==''){
		    $archive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		  if($newsGroup==''){
		    $newsGroup='N';
		 }
		$sql = "UPDATE tbl_christcms_news 
		        SET newsTitle='$newsTitle',
					newsSummary='$newsSummary',
					newsBody='$newsBody',
					categoryID='$categoryID',
					langCode='$langCode',
					dtCreated='$dtUpdated',
					newsArchive='$archive',
					newsGroup='$newsGroup'
		        WHERE id='$newsID'";
		return  $sql;
    }
    
    
    
function update_partner_single($partnerID,$partnerName,$partnerMission,$partnerVision,$langCode,$partnerEmail,$partnerContact,$partnerWebsite){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		  
		$sql = "UPDATE tbl_christcms_partner 
		        SET partnerName='$partnerName',
					partnerMission='$partnerMission',
					partnerVision='$partnerVision',					
					langCode='$langCode',
					email='$partnerEmail',
					contact='$partnerContact',
					website='$partnerWebsite'
		        WHERE id='$partnerID'";
		return  $sql;
    }
    
function update_cont_category_single($categoryID,$category,$langCode,$description){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		  
		$sql = "UPDATE tbl_christcms_cont_category
		        SET category='$category',								
					langCode='$langCode',					
					description='$description'
		        WHERE id='$categoryID'";
		return  $sql;
    }
    
function update_cont_status_single($statusID,$status,$langCode,$description){
		 
		 if($langCode==''){
		    $langCode='en';
		 }
		  
		$sql = "UPDATE tbl_christcms_cont_status
		        SET status='$status',								
					langCode='$langCode',					
					description='$description'
		        WHERE id='$statusID'";
		return  $sql;
    }
    
function update_project_single($projectID,$categoryID,$projectTitle,$projectSummary,$projectObjective,$langCode,$dtStarted,$dtEnded,$projectArchive,$projectResult,$status){
		 if ($dtStarted==''){
		    $dtStarted=date('Y-m-d');
		 }
		 if($projectArchive==''){
		    $projectArchive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		  
		$sql = "UPDATE tbl_christcms_project 
		        SET projectTitle='$projectTitle',
		        	categoryID='$categoryID',
					projectSummary='$projectSummary',
					projectObjective='$projectObjective',					
					langCode='$langCode',
					dtStarted='$dtStarted',
					dtEnded='$dtEnded',
					projectArchive='$projectArchive',
					status='$status',
					projectResult='$projectResult'
		        WHERE id='$projectID'";
		return  $sql;
    }
	
	#########################################################################################
	#***************************events fuctions**********************************************
	#########################################################################################
	 /*
	**function to event page
	*/
	 function add_event($eventTitle,$eventSummary,$eventBody,$eventLocation,$categoryID,$langCode,$startDt,$endDt,$dtCreated,$archive,$status){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($archive==''){
		    $archive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_events(eventTitle,eventSummary,eventBody,eventLocation,categoryID,langCode,startDt,endDt,dtCreated,eventArchive,status)
		         VALUES('$eventTitle','$eventSummary','$eventBody','$eventLocation','$categoryID','$langCode','$startDt','$endDt','$dtCreated','$archive','$status')";
		 return  $sql;
     }
	 /*
	**function to get all events
	*/
	    function get_event_items($categoryID,$langCode,$archive,$status,$sqllimit){
			if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_events 
			        WHERE langCode='$langCode' AND
						  eventArchive='$archive'";
	    			if($status!=''){
			           $sql=$sql." AND status='$status'";
			         }
					if($categoryID!=''){
			           $sql=$sql." AND categoryID='$categoryID'";
			         }
			         $sql=$sql." ORDER BY status ";
					if($sqllimit!=''){
					    $sql=$sql."LIMIT 0,".$sqllimit;
					 }
		return  $sql;
    }
    

	 /*
	**function to  single event
	*/
	    function get_event_single($eventID,$categoryID,$langCode,$archive){
            if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_events
			        WHERE langCode='$langCode' AND
						  eventArchive='$archive'AND
						  id='$eventID'";
					if($categoryID!=''){
			           $sql=$sql." AND categoryID='$categoryID'";
			         }
		return  $sql;
     }
     

	 /*
	**function to delete event
	*/
	function delete_event_single($eventID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_events  WHERE  langCode='$langCode' AND id='$eventID'";
		return  $sql;
    }
	 /*
	**function to update event
	*/
	    function update_event_single($eventID,$eventTitle,$eventSummary,$eventBody,$eventLocation,$categoryID,$langCode,$startDt,$endDt,$dtUpdated,$archive,$status){
		 if ($dtUpdated==''){
		    $dtUpdated=date('Y-m-d');
		 }
		 if($archive==''){
		    $archive='No';
		 }
		 if($langCode==''){
		    $langCode='en';
		 }
		$sql = "UPDATE tbl_christcms_events 
		        SET eventTitle='$eventTitle',
					eventSummary='$eventSummary',
					eventBody='$eventBody',
					eventLocation='$eventLocation',
					categoryID='$categoryID',
					langCode='$langCode',
					startDt='$startDt',
					endDt='$endDt',
					status='$status',
					dtCreated='$dtUpdated',
					eventArchive='$archive'
		        WHERE id='$eventID'";
		return  $sql;
    }
 #########################################################################################
	#***************************  trainings fuctions*****************************************
	#########################################################################################
	 /*
	**function to add
	*/
	 function add_training($tTitle,$tDescription,$langCode,$dtCreated,$archive){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		
		 $sql = "INSERT INTO tbl_christcms_trainings(tTitle,tDescription,langCode,dtCreated,tArchive)
		         VALUES('$tTitle','$tDescription','$langCode','$dtCreated','$archive')";
		 return  $sql;
     }
	 /*
	**function to get all items
	*/
	    function get_training_items($langCode,$archive,$limitEvent){
			if($archive==''){
			    $archive='No';
			 }if($langCode==''){
			    $langCode='en';
			 }
			$sql = "SELECT * FROM tbl_christcms_trainings 
			        WHERE langCode='$langCode' AND
						  tArchive='$archive'";
					if($limitEvent!=''){
					    $sql=$sql."LIMIT 0,".$limitEvent;
					 }
		return  $sql;
    }
	 /*
	**function to  single item
	*/
	    function get_training_single($tID,$langCode,$archive){
            if($archive==''){
			    $archive='No';
			 }
			$sql = "SELECT * FROM tbl_christcms_trainings
			        WHERE langCode='$langCode' AND
						  tArchive='$archive'AND
						  id='$tID'";
				
		return  $sql;
     }
	 /*
	**function to delete 
	*/
	    function delete_training_single($tID,$langCode){
                        if($langCode==''){
			    $langCode='en';
			 }
		$sql = "DELETE FROM  tbl_christcms_trainings  WHERE  langCode='$langCode' AND id='$tID'";
		return  $sql;
    }
	 /*
	**function to update event
	*/
	    function update_training_single($tID,$tTitle,$tDescription,$langCode,$dtUpdated,$archive){
		 if ($dtUpdated==''){
		    $dtUpdated=date('Y-m-d');
		 }if($langCode==''){
			    $langCode='en';
			 }
		
		$sql = "UPDATE tbl_christcms_trainings 
		        SET tTitle='$tTitle',
					tDescription='$tDescription',
					langCode='$langCode',
					dtCreated='$dtUpdated',
					tArchive='$archive'
		        WHERE id='$tID'";
		return  $sql;
    }
	#########################################################################################
	#***************************category fuctions********************************************
	#########################################################################################
	/*
	**function to add category
	*/
	 function add_category($catTitle,$catDescription,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_category(catTitle,catDescription,langCode)
		         VALUES('$catTitle','$catDescription','$langCode')";
		 return  $sql;
     }
	 /*
	**function to get all category
	*/
	    function get_cat_items($langCode){
			$sql = "SELECT * FROM tbl_christcms_category
			        WHERE langCode='$langCode'";
		return  $sql;
    }
	 /*
	**function to  single category
	*/
	    function get_cat_single($categoryID,$langCode){
			$sql = "SELECT * FROM tbl_christcms_category
			        WHERE langCode='$langCode' 
					AND categoryID='$categoryID'";
		return  $sql;
     }
	 /*
	**function to delete category
	*/
	    function delete_cat_single($categoryID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_category  WHERE  langCode='$langCode' AND categoryID='$categoryID'";
		return  $sql;
    }
	 /*
	**function to update category
	*/
	    function update_cat_single($categoryID,$catTitle,$catDescription,$langCode){
		$sql = "UPDATE tbl_christcms_category
		        SET catTitle='$catTitle',
					catDescription='$catDescription',
					langCode='$langCode'
		        WHERE categoryID='$categoryID'";
		return  $sql;
    }
	
	
	#########################################################################################
	#***************************FAQ fuctions*************************************************
	#########################################################################################
	
	 /*
	**function to faq
	*/
	 function add_faq($question,$answer,$catID,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_faq(question,answer,catID,langCode)
		         VALUES('$question','$answer','$catID','$langCode')";
		 return  $sql;
     }
	 /*
	**function to get all faq
	*/
	    function get_faq_items($catID,$langCode,$limitFAQ){
			$sql = "SELECT * FROM tbl_christcms_faq 
			        WHERE langCode='$langCode'";
					if($categoryID!=''){
			           $sql=$sql." AND catID='$catID'";
			         }
					if($limitFAQ!=''){
					    $sql=$sql."LIMIT 0,$limitFAQ";
					 }
		return  $sql;
    }
	 /*
	**function to  single faq
	*/
	    function get_faq_single($faqID,$catID,$langCode){
			$sql = "SELECT * FROM tbl_christcms_faq 
			        WHERE langCode='$langCode' AND
						  faqID='$faqID'";
					if($categoryID!=''){
			           $sql=$sql." AND catID='$catID'";
			         }
		return  $sql;
     }
	 /*
	**function to delete faq
	*/
	    function delete_faq_single($faqID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_faq  WHERE  langCode='$langCode' AND faqID='$faqID'";
		return  $sql;
    }
	 /*
	**function to update faq
	*/
	    function update_faq_single($faqID,$question,$answer,$catID,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		$sql = "UPDATE tbl_christcms_faq 
		        SET question='$question',
					answer='$answer',
					langCode='$langCode'
		        WHERE faqID='$faqID'";
		return  $sql;
    }
	
	
	#########################################################################################
	#***************************user group fuctions******************************************
	#########################################################################################
	/*
	**function to add user group
	*/
	 function add_usergroup($groupTitle,$groupDescription,$groupStatus,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_usergroup(groupTitle,groupDescription,groupStatus,langCode)
		         VALUES('$groupTitle','$groupDescription','$groupStatus','$langCode')";
		 return  $sql;
     }
	 /*
	**function to get all user groups
	*/
	    function get_usergroup_items($langCode){
			$sql = "SELECT * FROM tbl_christcms_usergroup
			        WHERE langCode='$langCode'";
		return  $sql;
    }
	 /*
	**function to  single user group
	*/
	    function get_usergroup_single($groupID,$langCode){
			$sql = "SELECT * FROM tbl_christcms_usergroup
			        WHERE langCode='$langCode' 
					AND groupID='$groupID'";
		return  $sql;
     }
	 /*
	**function to delete user group
	*/
	    function delete_usergroup_single($groupID,$langCode){
		$sql = "DELETE FROM  tbl_christcms_usergroup WHERE  langCode='$langCode' AND groupID='$groupID'";
		return  $sql;
    }
	 /*
	**function to update user group
	*/
	    function update_usergroup_single($groupID,$groupTitle,$groupDescription,$groupStatus,$langCode){
		$sql = "UPDATE tbl_christcms_usergroup
		        SET groupTitle='$groupTitle',
					groupDescription='$groupDescription',
					groupStatus='$groupStatus',
					langCode='$langCode'
		        WHERE groupID='$groupID'";
		return  $sql;
    }
	
	
	#########################################################################################
	#***************************user fuctions************************************************
	#########################################################################################
	 /*
	**function to add user
	*/
	 function add_user($userID,$userName,$password,$FName,$LName,$OName,$Tel,$Mobile,$RoomNo,$userStatus,$dtCreated,$lastLogin){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($lastLogin==''){
		    $lastLogin=date('Y-m-d');
		 }
		 if($userStatus==''){
		    $userStatus='Active';
		 }
		 $passwordEncrypt=MD5($password);
		 $sql = "INSERT INTO tbl_christcms_user(userID,userName,password,FName,LName,OName,Tel,Mobile,RoomNo,userStatus,dtCreated,lastLogin)
		         VALUES('$userID','$userName','$passwordEncrypt','$FName','$LName','$OName','$Tel','$Mobile','$RoomNo','$userStatus','$dtCreated','$lastLogin')";
		 return  $sql;
     }
	
	 /*
	**function to get users
	*/
	    function get_users(){
			
			$sql = "SELECT * FROM tbl_christcms_user";
		return  $sql;
    }
	 /*
	**function to  single user
	*/
	    function get_user_single($userID,$userStatus){
		    if($userStatus==''){
		    $userStatus='Active';
		    }
			$sql = "SELECT * FROM tbl_christcms_user
			        WHERE userID='$userID' AND
						  userStatus='$userStatus'";
					
		return  $sql;
     }
	 /*
	**function to  check user
	*/
	    function get_user_check($userName,$password){
		    $passwordEncrypt=MD5($password);
			$sql = "SELECT * FROM tbl_christcms_user
			        WHERE userName='$userName' AND
						  password='$passwordEncrypt'AND 
						  userStatus='Active'";
					
		return  $sql;
     }
	 /*
	**function to  check user
	*/
	    function get_user_check_exist($userName){
			$sql = "SELECT * FROM tbl_christcms_user
			        WHERE userName='$userName'";
					
		return  $sql;
     }
	 /*
	**function to delete user
	*/
	    function delete_user_single($userID){
		$sql = "DELETE FROM  tbl_christcms_user  WHERE  userID='$userID'";
		return  $sql;
    }
	 /*
	**function to update user
	*/
	    function update_user_single($userID,$FName,$LName,$OName,$Tel,$Mobile,$RoomNo,$userStatus,$dtCreated,$lastLogin){
		 if ($dtCreated==''){
		    $dtCreated=date('Y-m-d');
		 }
		 if($lastLogin==''){
		    $lastLogin=date('Y-m-d');
		 }
		 if($userStatus==''){
		    $userStatus='Active';
		 }
		 //$passwordEncrypt=MD5($password);
		 $sql = "UPDATE tbl_christcms_user 
		         SET 
					FName='$FName',
					LName='$LName',
					OName='$OName',
					Tel='$Tel',
					Mobile='$Mobile',
					RoomNo='$RoomNo',
					userStatus='$userStatus',
					dtCreated='$dtCreated',
					lastLogin='$lastLogin'
		        WHERE userID='$userID'";
		return  $sql;
    }
	
		 /*
	**function to change user password
	*/
	    function chane_user_passwd($userID,$userName,$password){
		 $passwordEncrypt=MD5($password);
		 $sql = "UPDATE  tbl_christcms_user 
			     SET     password='$passwordEncrypt'
		         WHERE   userID='$userID' AND
				         userName='$userName'";
		return  $sql;
    }
	/*
	**function to  get user group permision
	*/
	    function get_user_permision($userID,$groupID){
			$sql = "SELECT * FROM tbl_christcms_user_group
			        WHERE userID='$userID'AND
					      groupID='$groupID' ";
					
		return  $sql;
     }
	 /*
	**function to   add user group permision
	*/
	    function add_user_permision($userID,$groupID,$intPermision){
			$sql = "INSERT INTO  tbl_christcms_user_group(userID,groupID,intPermision)
			        VALUES('$userID','$groupID','$intPermision') ";
					
		return  $sql;
     }
	
	/*
	**function to delete user group permision
	*/
	    function delete_user_permision($userID){
			$sql = "DELETE FROM  tbl_christcms_user_group
			        WHERE userID='$userID'";
					
		return  $sql;
     }
	 
	  #########################################################################################
	#***************************staff fuctions************************************************
	#########################################################################################
	
	 /*
	**function to add staff details
	*/
	 function add_staff($StaffID,$StaffName,$StaffTitle,$Description,$PhotoName,$PhotoType,$PhotoSize,$PhotoPath){
		 
		 $sql = "INSERT INTO tbl_christcms_staff(StaffID,StaffName,StaffTitle,Description,PhotoName,PhotoType,PhotoSize,PhotoPath)
		         VALUES('$StaffID','$StaffName','$StaffTitle','$Description','$PhotoName','$PhotoType','$PhotoSize','$PhotoPath')";
		 return  $sql;
     }
	 /*
	**function to get all staff
	*/
	    function get_all_staff(){
		$sql = "SELECT * FROM tbl_christcms_staff";
		return  $sql;
    }
	 /*
	**function to  single staff
	*/
	    function get_staff_single($StaffID){
		$sql = "SELECT * FROM tbl_christcms_staff WHERE  StaffID='$StaffID'";
		return  $sql;
     }
	
	 /*
	**function to delete staff
	*/
	    function delete_staff_single($StaffID){
		$sql = "DELETE FROM tbl_christcms_staff WHERE  StaffID='$StaffID'";
		return  $sql;
    }
	 /*
	**function to update staff
	*/
	    function update_staff_single($StaffID,$StaffName,$StaffTitle,$Description,$PhotoName,$PhotoType,$PhotoSize,$PhotoPath){
		
		
		$sql = "UPDATE tbl_christcms_staff 
		        SET StaffName='$StaffName',
					StaffTitle='$StaffTitle',
					Description='$Description'
		            ";
		if($PhotoName!=''){
			$sql=$sql.",
						PhotoName='$PhotoName',
						PhotoType='$PhotoType',
						PhotoSize='$PhotoSize',
						PhotoPath='$PhotoPath'";
		}
		$sql=$sql."WHERE StaffID='$StaffID'";
		return  $sql;
    }
     
	 
       #########################################################################################
	#**************************member fuctions************************************************
	#########################################################################################
	
	 /*
	**function to add  details
	*/
	 function add_member($mID,$mName,$mTitle,$Description,$PhotoName,$PhotoType,$PhotoSize,$PhotoPath){
		 
		 $sql = "INSERT INTO tbl_christcms_member(mID,mName,mTitle,Description,PhotoName,PhotoType,PhotoSize,PhotoPath)
		         VALUES('$mID','$mName','$mTitle','$Description','$PhotoName','$PhotoType','$PhotoSize','$PhotoPath')";
		 return  $sql;
     }
	 /*
	**function to get all 
	*/
	    function get_all_member($sqllimit){
                
		$sql = "SELECT * FROM tbl_christcms_member";
                if($sql!=""){
                     $sql=$sql.$sqllimit;
                 }
		return  $sql;
    }
	 /*
	**function to  single 
	*/
	    function get_member_single($mID){
		$sql = "SELECT * FROM tbl_christcms_member WHERE  mID='$mID'";
		return  $sql;
     }
	
	 /*
	**function to delete 
	*/
	    function delete_member_single($mID){
		$sql = "DELETE FROM tbl_christcms_member WHERE  mID='$mID'";
		return  $sql;
    }
	 /*
	**function to update 
	*/
	    function update_member_single($mID,$mName,$mTitle,$Description,$PhotoName,$PhotoType,$PhotoSize,$PhotoPath){
		
		
		$sql = "UPDATE tbl_christcms_member
		        SET mName='$mName',
					mTitle='$mTitle',
					Description='$Description'
		            ";
		if($PhotoName!=''){
			$sql=$sql.",
						PhotoName='$PhotoName',
						PhotoType='$PhotoType',
						PhotoSize='$PhotoSize',
						PhotoPath='$PhotoPath'";
		}
		$sql=$sql."WHERE mID='$mID'";
		return  $sql;
    }
     
	 
	 
	 #########################################################################################
	#***************************links fuctions************************************************
	#########################################################################################
	
	 /*
	**function to add link
	*/
	 function add_link($CatID,$Name,$Description,$Url,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		 $sql = "INSERT INTO tbl_christcms_links(CatID,Name,Description,Url,langCode)
		         VALUES('$CatID','$Name','$Description','$Url','$langCode')";
		 return  $sql;
     }
	 /*
	**function to get all links
	*/ //function get_all_links($langCode,$limit)
	    function get_all_links($langCode){
		$sql = "SELECT * FROM tbl_christcms_links WHERE langCode='$langCode'";
                 if($limit!=''){
					    $sql=$sql."LIMIT 0,$limit";
					 }
		return  $sql;
    }
	 /*
	**function to  single links
	*/
	    function get_link_single($LinkID,$CatID,$langCode){
		$sql = "SELECT * FROM tbl_christcms_links WHERE langCode='$langCode' AND LinkID='$LinkID' AND CatID='$CatID'";
		return  $sql;
     }
	 /*
	**function to delete link
	*/
	    function delete_link_single($LinkID,$langCode){
		$sql = "DELETE FROM tbl_christcms_links WHERE  langCode='$langCode' AND LinkID='$LinkID'";
		return  $sql;
    }
	 /*
	**function to update link
	*/
	    function update_link_single($LinkID,$CatID,$Name,$Description,$Url,$langCode){
		 if($langCode==''){
		    $langCode='en';
		 }
		$sql = "UPDATE tbl_christcms_links 
		        SET CatID='$CatID',
					Name='$Name',
					Description='$Description',
					Url='$Url',
					langCode='$langCode'
		        WHERE LinkID='$LinkID'";
		return  $sql;
    }
    
	#########################################################################################
	#***************************prayer fuctions**********************************************
	#########################################################################################
	
	
    #########################################################################################
	#***************************testemonies fuctions*****************************************
	#########################################################################################
	
	
	#########################################################################################
	#***************************contributions fuctions***************************************
	#########################################################################################
	
	
	
	#########################################################################################
	#***************************config fuctions**********************************************
	#########################################################################################
	
	
	
    #########################################################################################
	#***************************gallery fuctions*********************************************
	#########################################################################################
	
	
	
	#########################################################################################
	#***************************language fuctions********************************************
	#########################################################################################
	
	
	
	#########################################################################################
	#***************************library fuctions*********************************************
	#########################################################################################
	
	
	
    #########################################################################################
	#***************************statisticts fuctions*****************************************
	#########################################################################################
	
	
	
	
	#########################################################################################
	#***************************QA fuctions**************************************************
	#########################################################################################
	
	
	
	#########################################################################################
	#***************************teachings fuctions*******************************************
	#########################################################################################
	
	
	
    #########################################################################################
	#***************************testemonies fuctions*****************************************
	#########################################################################################
	
	
	
	
	
	
}
?>
