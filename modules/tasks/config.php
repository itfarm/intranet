<?php
	$DOC_ROOT = "/intranet/modules/tasks/";
	$url["dashboard"] = $DOC_ROOT . "/intranet/modules/tasks/index.php?page=dashboard";
	$url["profile"] = $DOC_ROOT . "modules/tasks/index.php?page=profile";
	$url["admin"] = $DOC_ROOT . "modules/tasks/index.php?page=admin";
	$url["settings"] = $DOC_ROOT . "modules/tasks/index.php?page=settings";
	function submenu($current) {
		if( $current == "dashboard" ) {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard" class="current">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history">Login History</a></li>
					</ul>
				</div>
			';
		}
		elseif( $current == "profile" ) {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile" class="current">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history">Login History</a></li>
					</ul>
				</div>
			';
		}
		elseif( $current == "settings" ) {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings" class="current">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history">Login History</a></li>
					</ul>
				</div>
			';
		}
		elseif ( $current == "admin" ) {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin" class="current">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history">Login History</a></li>
					</ul>
				</div>
			';
		}
		elseif ( $current == "history" ) {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history" class="current">Login History</a></li>
					</ul>
				</div>
			';
		}
		else {
			echo '
				<div id="submenu">
					<ul>
						<li><a href="/intranet/modules/tasks/index.php?page=dashboard" class="current">Dashboard</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=profile">Profile</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=settings">Settings</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=admin">Admin</a></li>
						<li><a href="/intranet/modules/tasks/index.php?page=history">Login History</a></li>
					</ul>
				</div>
			';
		}
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
