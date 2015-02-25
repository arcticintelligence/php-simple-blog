<?php
error_reporting(0);
session_start();

class blogLogin{
      function __construct(){
               include "../db_config.php";
      }
      function redirect($url = "index.php"){
               echo '<SCRIPT language="JavaScript">window.location="'.$url.'";</SCRIPT>';
      }
}
$blogLogin = new blogLogin();

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
<li><a href="../new/">Post Blog</a></li>
<?php else : ?>
<li><a href="#">Home</a></li>
<li><a href="login/">login</a></li>

<?php endif ?>

</ul>

<form action="" method="POST">
      <table>
             <tr>
                 <td><b>User Id :</b></td>
                 <td><input type="text" name="userid"></td>
             </tr>
             <tr>
                 <td><b>Password :</b></td>
                 <td><input type="password"  name="password"></td>
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


       $query =mysql_query("select * from people where userid='".$_POST['userid']."' and password='".$_POST['password']."'");

       if(mysql_num_rows($query)>0){
         $row = mysql_fetch_assoc($query);
         $_SESSION['userid'] = $row['id'];

       }
       $blogLogin->redirect("../");
     }else{
       $_SESSION['error'] = "User Id and Password does not correct";
       //$blogLogin->redirect();
     }

?>
