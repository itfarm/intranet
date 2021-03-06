<?php
	@include_once('../../cfg/config.php');
	$upload_dir=$http_dir . $root_dir . "docs/";
	$docs_dir=$root_dir ."docs/";
	$root_dir="/intranet/modules/tasks/";
	//	Page URLs
	$dashboardPage= $root_dir . "main.php?page=dashboard";
	$profilePage = $root_dir . "main.php?page=profile";
	$settingsPage = $root_dir . "main.php?page=settings";
	$audittrailPage = $root_dir ."main.php?page=audittrail";
	$clearLogPage = $root_dir . "main.php?page=clearlog";
	$adminpage = $root_dir . "main.php?page=admin";
	$staffroasterPage = $root_dir . "main.php?page=staffroaster";

	// Re-used page contents functions
	function submenu($current) {
		//	Submenu URLs and their names
		$url[0][0] = "Tasks";	$url[0][1] = $root_dir . "main.php?page=dashboard";
		$url[1][0] = "profile"; 	$url[1][1] = $root_dir . "main.php?page=profile";
		$url[2][0] = "settings";	$url[2][1] = $root_dir . "main.php?page=settings";
		$url[3][0] = "admin";		$url[3][1] = $root_dir . "main.php?page=admin";
		$url[4][0] = "staff roaster";		$url[4][1] = $root_dir . "main.php?page=staffroaster";
		$url[5][0] = "audit trail";		$url[5][1] = $root_dir . "main.php?page=audittrail";

		echo '	<div id="submenu">
					<ul id="main">';
					// Generate submenu links
					for($incr = 0; $incr <=5; $incr++ ) {
						// Mark the current class
						// Bug fix for color highlighting.
						if( $current == "staffroaster" ) $current = "staff roaster";
						if( $current == "dashboard" ) $current = "Tasks";
						if( $current == "audittrail" ) $current = "audit trail";
						if( $current == $url[$incr][0] ) {
							$class = "current_page_item";
						}
						else {
							$class = "";
						}
						// Display the submenu links
						// except settings.
						if( $url[$incr][0] != "settings" && $url[$incr][0] != "audit trail" && $url[$incr][0] != "admin") {
							echo '<li class="' .$class . '"><a href="' . $url[$incr][1] . '">' . $url[$incr][0] . '</a></li>';
						}
						elseif( auth_checkgroup('User Admin') == 1 ) {
							//For the case of settings url.
							echo '<li class="' .$class . '"><a href="' . $url[$incr][1] . '">' . $url[$incr][0] . '</a></li>';
						}
					};
		echo '		</ul>
				</div>';
	};

	function contents($page,$tag) {
		global $profilePage,$dashboardPage, $settingsPage, $adminpage,$audittrailPage,$clearLogPage, $staffroasterPage, $root_dir;
		global $db_host, $db_user, $db_password, $db_name;
		$dbcnx = db_connection($db_host,$db_user,$db_password);
		$db_select = db_select($db_name,$dbcnx);
		if( $page =="settings") {
			if(empty($tag) || 
				(	$tag !== "task_classification" &&
					$tag !="priority_classification" &&
					 $tag !="workload_classification" && 
					 $tag !="referral_classification" &&
					 $tag !="task_closure_classification" &&
					 $tag !="document_classification" &&
					 $tag !="file" &&
					 $tag !="file_type" &&
					 $tag !="subject_area" &&
					 $tag !="entity_type"
				)
			) {
				$tag = "task_classification";
			}
			include_once("settings/settings.php");
		};
		if( $page =="admin" ) {
			if( $tag == "managemembers" || empty($tag) ) {
				include("admin/managemembers.php");
			}
			elseif( $tag == "managesections") {
				include("admin/managesections.php");
			}
			elseif( $tag == "editgroupsbyuser" ) {
				include("admin/editgroupsbyuser.php");
			}
			elseif( $tag == "editgroupsbygroup" ) {
				include("admin/editgroupsbygroup.php");
			}
			elseif( $tag == "editbyassignee") {
				include("admin/editbyassignee.php");
			}
			elseif( $tag == "editbyassigner") {
				include("admin/editbyassigner.php");
			}
		}
		if( $page =="dashboard" || empty($page) ) {
			if( $tag == "viewtasks" || empty($tag) ) {
				include_once("dashboard/viewtasks.php");
			}
			elseif( $tag == "createtask" ) {
				include_once("dashboard/createtask.php");
			}
			elseif( $tag == "processtask" ) {
				include_once("dashboard/processtask.php");
			}
			elseif( $tag == "viewdocs" ) {
				include_once("dashboard/viewdocuments.php");
			}
			elseif( $tag == "uploaddocs" ) {
				include_once("dashboard/uploaddocuments.php");
			};
		}
		if($page == "audittrail") {
			include("audittrail/audittrail.php");
		}
		if($page == "staffroaster") {
			if( $tag == "viewstaffs" || empty($tag) ) {
				include_once("dashboard/viewstaffs.php");
			}
			elseif( $tag == "viewteams" ) {
				include_once("dashboard/viewteams.php");
			}
			elseif( $tag == "viewgroups" ) {
				include_once("dashboard/viewgroups.php");
			}
			elseif( $tag == "viewroles" ) {
				include_once("dashboard/viewroles.php");
			};
		}
		if($page == "clearlog") {
			include("audittrail/clearlog.php");
		};
		if( $page == "profile" ) {
			if( $tag == "autobiography" || empty($tag) ) {
				include_once("profile/autobiography.php");
			}
			elseif( $tag == "managegroups" ) {
				include_once("profile/authgroups.php");
			}
			elseif( $tag == "changepassword" ) {
				include_once("profile/changepassword.php");
			}
			if( $tag == "manageusers" ) {
				include_once("profile/authusers.php");
			}
			elseif( $tag == "location" ) {
				include_once("profile/location.php");
			};
		}
	}
	function sidebar($page, $tag) {
		global $dashboardPage, $profilePage, $settingsPage,$audittrailPage,$clearLogPage,$staffroasterPage, $adminpage;
		if( $page == "dashboard" || empty($page)) {
			echo '
					<ul>
						<li>
							<h2>Tasks</h2>
							<ul>
								<li><a href="'. $dashboardPage .'&tag=viewtasks">View Tasks</a></li>
								<li><a href="'. $dashboardPage .'&tag=createtask">Create Tasks</a></li>
							</ul>
						</li>
						<li>
							<h2>Documents</h2>
							<ul>
								<li><a href="'. $dashboardPage. '&tag=viewdocs">View Documents</a></li>
								<li><a href="'. $dashboardPage .'&tag=uploaddocs">Upload Documents</a></li>
							</ul>
						</li>
					</ul>
			';
		}
		elseif( $page == "profile" ) {
			echo '
					<ul>
						<li>
							<h2>Personal</h2>
							<ul>
								<li><a href="'. $profilePage .'&tag=autobiography">Autobiography</a></li>
								<li><a href="'. $profilePage .'&tag=location">Current Location</a></li>
								<li><a href="'. $profilePage .'&tag=changepassword">Change password</a></li>
							</ul>
						</li>';
			if( auth_checkgroup('User Admin') == 1 ) {
			echo		'<li>
							<h2>Manage</h2>
							<ul>
								<li><a href="'. $profilePage .'&tag=manageusers">User Profiles</a></li>
								<li><a href="'. $profilePage.'&tag=managegroups">Groups</a></li>
							</ul>
						</li>';
			};
			echo		'</ul>
			';
		}
		elseif( $page == "admin" ) {
			//	Edit by groups page is too huge.
			if( $tag !="editgroupsbyuser") {
			echo '
						<ul>
							<li>
								<h2>Manage</h2>
								<ul>
									<li><a href="'. $adminpage .'&tag=managemembers">Members</a></li>
									<li><a href="'. $adminpage .'&tag=managesections">Sections</a></li>
								</ul>
							</li>
						</ul>
				';
				}
		}
		elseif( $page == "settings") {
			echo '
						<ul>
							<li>
								<h2>Tasks</h2>
								<ul>
									<li><a href="'. $settingsPage .'&tag=task_classification">Classes of tasks</a></li>
									<li><a href="'. $settingsPage .'&tag=priority_classification">Priorities of tasks</a></li>
									<li><a href="'. $settingsPage .'&tag=workload_classification">Workloads ranges</a></li>
									<li><a href="'. $settingsPage .'&tag=referral_classification">Referrals for tasks</a></li>
									<li><a href="'. $settingsPage .'&tag=task_closure_classification">Closure of tasks</a></li>
								</ul>
							</li>
							<li>
								<h2>Documents</h2>
								<ul>
									<li><a href="'. $settingsPage .'&tag=document_classification">Classes</a></li>
									<li><a href="'. $settingsPage .'&tag=file">Files</a></li>
									<li><a href="'. $settingsPage .'&tag=file_type">Confidence</a></li>
									<li><a href="'. $settingsPage .'&tag=subject_area">Subject Coverage</a></li>
								</ul>
							</li>
							<li>
								<h2>Entities</h2>
								<ul>
									<li><a href="'. $settingsPage .'&tag=entity_type">Entity Types</a></li>
								</ul>
							</li>
						</ul>
			';
		}
		elseif( $page == "staffroaster" ) {
			echo '	<ul>
						<li>
							<h2>Staffs</h2>
							<ul>
								<li><a href="'. $staffroasterPage .'&tag=viewstaffs">View Staffs</a></li>
								<li><a href="'. $staffroasterPage .'&tag=viewteams">View Teams</a></li>
								<li><a href="'. $staffroasterPage .'&tag=viewgroups">View Groups</a></li>
								<li><a href="'. $staffroasterPage .'&tag=viewroles">Roles in groups</a></li>
							</ul>
						</li>
					</ul>
			
			';
		};
	};


	function get_userid($username,$password) {
		global $db_host, $db_user, $db_password,$db_name;
		$dbcnx = db_connection($db_host,$db_user,$db_password);
		$db_select = db_select($db_name,$dbcnx);
		$userid_string = "SELECT * FROM authuser WHERE uname = '$username' AND passwd = MD5('$password')";
		$query_userid = mysql_query($userid_string) or die( mysql_error() );
		if($query_userid) $row = mysql_fetch_row($query_userid);
		return $row[0];
	};
	
	function get_task_list($username,$password,$relationship) {
		global $db_host, $db_user, $db_password,$db_name;
		if($relationship == "ever_created_by_user") {
			$userid = get_userid($username,$password);
			$tasks_ever_created_by_user_string = "SELECT tbl_tasks.task_id FROM tbl_tasks
								WHERE tbl_tasks.created_by='".$userid."'
								AND task_closure_classification_id is null
								OR task_closure_classification_id <> 'Voi'";
								
			$dbcnx = db_connection($db_host,$db_user,$db_password);
			$db_select = db_select($db_name,$dbcnx);
			$query_tasks_ever_created_by_user = mysql_query($tasks_ever_created_by_user_string) or die( mysql_error() );
			return $query_tasks_ever_created_by_user;
		}
	}

?>
