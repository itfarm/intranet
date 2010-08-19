<?php
	@include_once('./header.php');
?>
	<!-- start page -->
	<div id="page">
		<!-- start content -->
		<div id="content">
			<div style="clear: both;">&nbsp;</div>
			<div class="scrolldown">
			<?php
				resources_contents($tag);
			?>
			</div>
		</div>
		<!-- end content -->
		<!-- start sidebar-right -->
		<div id="sidebar-right" class="sidebar">
			<?php resources_sidebar($tag); ?>
		</div>
		<!-- end sidebar-right -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
<?php
	@include_once('./footer.php');
?>
