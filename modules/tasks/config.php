<?php
	$DOC_ROOT = "/intranet/modules/tasks/";
	$current_page=1;
	$root_dir="/intranet/modules/tasks/";
		
	function submenu($current) {
		//	Submenu URLs and their names
		$url[0][0] = "dashboard";	$url[0][1] = $root_dir . "index.php?page=dashboard";
		$url[1][0] = "profile"; 	$url[1][1] = $root_dir . "index.php?page=profile";
		$url[2][0] = "settings";	$url[2][1] = $root_dir . "index.php?page=settings";
		$url[3][0] = "admin";		$url[3][1] = $root_dir . "index.php?page=admin";
		$url[4][0] = "history";		$url[4][1] = $root_dir . "index.php?page=history";

		echo '	<div id="submenu">
					<ul>';
					// Generate submenu links
					for($incr = 0; $incr <5; $incr++ ) {
						// Mark the current class
						if( $current == $url[$incr][0] ) {
							$class = "current";
						}
						else {
							$class = "";
						}
						// Display the submenu links
						echo '<li><a href="' . $url[$incr][1] . '" class="' .$class . '">' . $url[$incr][0] . '</a></li>';
					};
		echo '		</ul>
				</div>';
	};
	function sidebar($tag) {
		if( $tag == "dashboard") {
			echo '
				<div id="sidebar">
					<ul>
						<li>
							<h2>Tasks</h2>
							<ul>
								<li><a href="">View Tasks</a></li>
								<li><a href="">Create Tasks</a></li>
							</ul>
						</li>
						<li>
							<h2>Documents</h2>
							<ul>
								<li><a href="">View Documents</a></li>
								<li><a href="">Upload Documents</a></li>
							</ul>
						</li>
						<li>
							<h2>Staffs</h2>
							<ul>
								<li><a href="">View Staffs</a></li>
								<li><a href="">View Groups</a></li>
								<li><a href="">Roles in groups</a></li>
							</ul>
						</li>
					</ul>
				</div>
			';
		}
		elseif( $tag == "profile") {
			echo '
				<div id="sidebar">
					<ul>
						<li>
							<h2>Manage</h2>
							<ul>
								<li><a href="">User Profiles</a></li>
								<li><a href="">Groups</a></li>
							</ul>
						</li>
						<li>
							<h2>Personal</h2>
							<ul>
								<li><a href="">Change password</a></li>
								<li><a href="">Autobiography</a></li>
								<li><a href="">Current Location</a></li>
							</ul>
						</li>
					</ul>
				</div>
			';
		}
		elseif( $tag == "admin" ) {
			echo '
				<div id="sidebar">
						<ul>
							<li>
								<h2>Manage</h2>
								<ul>
									<li><a href="">Members</a></li>
									<li><a href="">Section</a></li>
								</ul>
							</li>
						</ul>
				</div>
				';
		}
		elseif( $tag == "settings") {
			echo '
				<div id="sidebar">
						<ul>
							<li>
								<h2>Tasks</h2>
								<ul>
									<li><a href="">Classes of tasks</a></li>
									<li><a href="">Priorities of tasks</a></li>
									<li><a href="">Workloads ranges</a></li>
									<li><a href="">Referrals for tasks</a></li>
								</ul>
							</li>
							<li>
								<h2>Documents</h2>
								<ul>
									<li><a href="">Classes</a></li>
									<li><a href="">Files</a></li>
									<li><a href="">Confidence</a></li>
									<li><a href="">Subject Coverage</a></li>
								</ul>
							</li>
							<li>
								<h2>Entities</h2>
								<ul>
									<li><a href="">Entity Types</a></li>
								</ul>
							</li>
						</ul>
				</div>
			';
		}
		else {
			echo '
				<div id="sidebar">

				</div>
			';
		};
	};
?>
