<?php
// Change this info so that it works with your system.
               $connection = mysql_connect('localhost', 'root', '') or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
               $database = "simple_blog";
               mysql_select_db($database, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");
?>
