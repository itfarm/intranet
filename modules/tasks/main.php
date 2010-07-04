<?php
	@include('config.php');
	$page = $_GET['page'];
	$tag =  $_GET['tag'];
	@session_start();
	if(!isset($_SESSION['username']))
	{
		@header("location:$loginPage?");
	}
	else {
		// Start of session
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Copyright IT Farm
Author: John Francis Mukulu <john.f.mukulu@gmail.com>
Website: http://bongolinux.webs.com/
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PMO New Intranet system</title>
<meta name="keywords" content="" />
<meta name="Adhesive" content="" />
<link rel="stylesheet" type="text/css" href="/intranet/modules/tasks/stylesheets/main.css" media="screen" />
</head>
<body>
<div id="wrapper">
	<!-- start header -->
	<div id="header">
		<div id="logo">
			<h1><a href=""><span>Intranet</span></a></h1>
			<p><?php echo $_SESSION['username'] ?> | <a href="<?php echo $logoutPage ?>" style="color:yellow;">Logout</a></p>
		</div>
		<div id="menu">
			<ul id="main">
				<li class="current_page"><a href="">Tasks</a></li>
				<li><a href="">Events</a></li>
				<li><a href="">News</a></li>
				<li><a href="">Gallery</a></li>
				<li><a href="">Projects</a></li>
				<li><a href="">Remainders</a></li>
				<li><a href="">Training</a></li>
				<li><a href="">Chat</a></li>
				<li><a href="">Polls</a></li>
			</ul>
		</div>
	</div>
	<!-- end header -->
	
	<!-- submenu -->
	<?php submenu($page) ?>
	<!-- end subemnu -->

	<!-- start page -->
	<div id="page">

		<!-- start sidebar-left -->
<!--
		<div id="sidebar-left" class="sidebar">
			<ul>
				<li>
					<form id="searchform" method="get" action="">
						<div>
							<h2>Site Search</h2>
							<input ty=pe="text" name="s" id="search-input" size="15" value="" />
							<br />
							<input type="submit" value="Search" id="search-button" />
						</div>
					</form>
				</li>
				<li>
					<h2>Calendar</h2>
					<div id="calendar_wrap">
						<table summary="Calendar">
							<caption>
							October 2009
							</caption>
							<thead>
								<tr>
									<th abbr="Monday" scope="col" title="Monday">M</th>
									<th abbr="Tuesday" scope="col" title="Tuesday">T</th>
									<th abbr="Wednesday" scope="col" title="Wednesday">W</th>
									<th abbr="Thursday" scope="col" title="Thursday">T</th>
									<th abbr="Friday" scope="col" title="Friday">F</th>
									<th abbr="Saturday" scope="col" title="Saturday">S</th>
									<th abbr="Sunday" scope="col" title="Sunday">S</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td abbr="September" colspan="3" id="prev"><a href="" title="View posts for September 2009">&laquo; Sep</a></td>
									<td class="pad">&nbsp;</td>
									<td colspan="3" id="next">&nbsp;</td>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td>1</td>
									<td>2</td>
									<td>3</td>
									<td id="today">4</td>
									<td>5</td>
									<td>6</td>
									<td>7</td>
								</tr>
								<tr>
									<td>8</td>
									<td>9</td>
									<td>10</td>
									<td>11</td>
									<td>12</td>
									<td>13</td>
									<td>14</td>
								</tr>
								<tr>
									<td>15</td>
									<td>16</td>
									<td>17</td>
									<td>18</td>
									<td>19</td>
									<td>20</td>
									<td>21</td>
								</tr>
								<tr>
									<td>22</td>
									<td>23</td>
									<td>24</td>
									<td>25</td>
									<td>26</td>
									<td>27</td>
									<td>28</td>
								</tr>
								<tr>
									<td>29</td>
									<td>30</td>
									<td>31</td>
									<td class="pad" colspan="4">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
				</li>
				<li>
					<h2>Dashboard</h2>
					<ul>
						<li><a href="">Functionality One</a></li>
						<li><a href="">Functionality Two Status</a></li>
						<li><a href="">Functionality Three Report</a></li>
						<li><a href="">Functionality Four Hint</a></li>
						<li><a href="">Functionality Five Remark</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- end sidebar-left -->
-->
		<!-- start content -->
		<div id="content">
			<?php contents($page,$tag); ?>
		</div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<?php sidebar($page,$tag) ?>
		</div>
		<!-- end sidebar-right -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>
<div id="footer-wrapper">
	<div id="footer">
		<p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp; Copyright <a href="">IT Farm</a>.</p>
	</div>
</div>
</body>
</html>
<?php
	}
?>
