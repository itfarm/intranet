<?php
	$root_dir="/intranet/";
	$tasksModule = $root_dir . "modules/tasks/";
	$eventsModule = $root_dir . "modules/events/";
	
	//	Database Server Configurations
	$db_host="localhost";
	$db_user="root";
	$db_password="root";
	$db_name="taskdata";
	
	// Database related functions
	function db_connection($db_host,$db_user,$db_password) {
		$dbcnx = mysql_connect($db_host,$db_user,$db_password);
		if (!$dbcnx)
		{
			$message = "<p>Database Server not found ".mysql_error()."</p>";
			exit($message);
		}
		else {
			return $dbcnx;
		}
	};
	function db_select($db_name,$dbcnx) {
		$db_select = mysql_select_db($db_name,$dbcnx);
		if( !$db_select ) {
			$message="<p>Database not found ".mysql_error()."</p>";
			exit($message);
		}
		else {
			return $db_select;
		}
	}

	
	//	Page URLs
	$verificationPage= $root_dir . "cfg/verification.php";
	$loginPage= $root_dir . "index.php";
	$dashboardPage= $tasksModule . "main.php?page=dashboard";
	$eventsPage = $root_dir . "modules/core/admin/events/index.php?menuid=MM3";
	$newsPage = $root_dir . "modules/core/admin/news/index.php?menuid=MM12";
	$galleryPage = $root_dir . "modules/core/admin/gallery/admin/index.php?menuid=MM8";
	$projectPage = $root_dir . "modules/core/admin/projects/index.php?menuid=MM19";
	$trainingPage = $root_dir . "modules/core/admin/training/index.php?menuid=MM11";
	$faqPage = $root_dir ."modules/core/admin/faq/index.php?menuid=MM15";

	function main_menu($current_module) {
		global 	$tasksModule, $dashboardPage, $eventsModule, $eventsPage;
		global  $newsPage, $galleryPage, $projectPage, $trainingPage, $faqPage;
		//	Submenu URLs and their names
		$main_url[0][0] = "Tasks";	$main_url[0][1] = $dashboardPage;
		$main_url[1][0] = "Events"; 	$main_url[1][1] = $eventsPage;
		$main_url[2][0] = "News";	$main_url[2][1] = $newsPage;
		$main_url[3][0] = "Gallery";		$main_url[3][1] = $galleryPage;
		$main_url[4][0] = "Projects";		$main_url[4][1] = $projectPage;
		$main_url[5][0] = "Training";		$main_url[5][1] = $trainingPage;
		$main_url[6][0] = "Remainders";		$main_url[6][1] = $root_dir . "";
		$main_url[7][0] = "Chat";			$main_url[7][1] = $root_dir . "";
		$main_url[8][0] = "Polls";			$main_url[8][1] = $root_dir . "";
		$main_url[9][0] = "FAQ";			$main_url[9][1] = $faqPage;
		
		echo '	<ul id="main">';
					// Generate submenu links
					for($incr = 0; $incr <10; $incr++ ) {
						// Mark the current class
						if( $current_module == $main_url[$incr][0] ) {
							$class = "current_page";
						}
						else {
							$class = "";
						}
						// Display the submenu links
						echo '<li class="' .$class . '"><a href="' . $main_url[$incr][1] . '">' . $main_url[$incr][0] . '</a></li>';
					};
		echo '		</ul>';
	};

?>
