<?php

	require_once("header.php");		  
    require_once("dbcon.php");

    if (checkVar($_SESSION['userid'])) { 
 
        $getRooms = "SELECT *
        			 FROM chat_rooms";
        $roomResults = mysql_query($getRooms);
	}
?>

    <div id="page-wrap"> 
    
    	<div id="chat-header">
    	
        	<div id="you"><span>Chatting as:<b> <?php echo $_SESSION['userid']?></b> | <a href="leavesession.php">Leave <b>Session</b></a> | <a href="createroom.php">Create Private Room</a> </span></div>
        	
        </div>
        
    	<div id="section">
    	
            <div id="rooms">
            	<h3 style="font-size:3em">Rooms</h3>
                <ul>
                    <?php 
                        while($rooms = mysql_fetch_array($roomResults)):
                            $room = $rooms['name'];
                            $query = mysql_query("SELECT * FROM `chat_users_rooms` WHERE `room` = '$room' ") or die("Cannot find data". mysql_error());
                            $numOfUsers = mysql_num_rows($query);
                    ?>
                    <li>
                        <a href="room/?name=<?php echo $rooms['name']?>"><?php echo $rooms['name'] . "<span>Users chatting: <strong>" . $numOfUsers . "</strong></span>" ?></a>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        
    </div>
<?php
	require_once("footer.php");
?>
