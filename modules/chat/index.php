<?php
	require_once("header.php");
?>
				<p class="important">PRIME MINISTER'S INSTANT CHATTING SESSION</p>
				<form method="post" action="jumpin.php">
					<label>Desired Username:</label>
					<div>
						<input type="text" id="userid" name="userid" value="<?php echo $_SESSION['username'] ?>"/>
						<input type="submit" value="Check" id="jumpin" />
					</div>
				</form>
			</div>
			
			<div id="status">
				<?php if (isset($_GET['error'])): ?>
					<!-- Display error when returning with error URL param? -->
				<?php endif;?>
			</div>
			
		</div>
<?php
	require_once("footer.php");
?>
