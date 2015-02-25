<?php
error_reporting(0);
session_start();

class postContent{
      function __construct(){
               include "../db_config.php";
      }
      function redirect($url = "index.php"){
               echo '<SCRIPT language="JavaScript">window.location="'.$url.'";</SCRIPT>';
      }
      

}
$postContent = new postContent();

if(  strlen($_SESSION['userid']) <1 || empty($_SESSION['userid'])){
  $postContent->redirect("../login");
}

?>

<?php
  if($_SESSION['success']){
    echo '<div style="color:green;">'.$_SESSION['success'].'</div>';
    $_SESSION['success']="";
  }
  if($_SESSION['error']){
    echo '<div style="color:red;">'.$_SESSION['red'].'</div>';
    $_SESSION['error']="";
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="../css/menu_style.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <title>Simple Blog</title>
</head>

<body>
<ul id="menu">
<?php if($_SESSION['userid']>0) : ?>
<li><a href="../">Home</a></li>
<li><a href="../?logout=1">logout</a></li>
<li><a href="../registration/">Registration</a></li>
<li><a href="../registration/?edit=1">Edit</a></li>
<li><a href="./">Post Blog</a></li>
<?php else : ?>
<li><a href="#">Home</a></li>
<li><a href="login/">login</a></li>

<?php endif ?>

</ul>

<form action="" method="POST">
      <table>
             <tr>
                 <td><b>Title :</b></td>
                 <td><input type="text" name="title"></td>
             </tr>
             <tr>
                 <td><b>Content :</b></td>
                 <td><textarea  name="content"></textarea></td>
             </tr>
             <tr>
                 <td><b>Tags :</b></td>
                 <td><input type="text" name="tags"></td>
             </tr>
             <tr>
                 <td colspan="2"><input type="submit" name="submit" value="Save"></td>
             </tr>
      </table>
</form>
</body>
</html>
<?php
     if($_POST['submit']=="Save"){
     
       $query = mysql_query("insert into blog_posts values('','".$_POST['title']."','".$_POST['content']."',".$_SESSION['userid'].",now())");
       $query2 =mysql_query("select * from blog_posts order by id desc limit 1");
       $row = mysql_fetch_assoc($query2);
       $blog_post_id = $row['id'];
       
       if($_POST['tags']){

         $query1 = mysql_query("insert into tags values('','".$_POST['tags']."')");
         $query2 =mysql_query("select * from tags order by id desc limit 1");
         $row = mysql_fetch_assoc($query2);
         $tag_id = $row['id'];

         $query3 = mysql_query("insert into blog_post_tags values($blog_post_id,$tag_id)");
       }

       if($query && $query1 && $query3 ){
         $_SESSION['success'] = "Data successfully posted ";
       }else{
         $_SESSION['error'] = "Error occured. Data did not posted. ";
         die('I ma dead');
       }
       $postContent->redirect();
     }else{
       //echo "No";
     }
     
?>
