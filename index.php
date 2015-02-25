<?php
error_reporting(0);
session_start();
if($_GET['logout'] == "1")
{
  $_SESSION['userid'] = "";
  unset($_SESSION['userid']);
}
?>
<?php
  $_SESSION['error']="";
  $_SESSION['success']="";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/menu_style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <title>Simple Blog</title>
</head>

<body>
<ul id="menu">
<?php if($_SESSION['userid']>0) : ?>
<li><a href="#">Home</a></li>
<li><a href="?logout=1">logout</a></li>
<li><a href="registration/">Registration</a></li>
<li><a href="registration/?edit=1">Edit</a></li>
<li><a href="new/">Post Blog</a></li>
<?php else : ?>
<li><a href="#">Home</a></li>
<li><a href="login/">login</a></li>

<?php endif ?>

</ul>

<div id="main">
	<h1>My Simple Blog</h1>
	<div id="blogPosts">
	<?php
	include ("includes/includes.php");
	
	$blogPosts = GetBlogPosts();
	
	foreach ($blogPosts as $post)
	{
		echo "<div class='post'>";
		echo "<h2>" . $post->title . "</h2>";
		echo "<p>" . $post->post . "</p";
		echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span";
		echo "</div>";
	}
	?>
	</div>
</div>

</body>

</html>
