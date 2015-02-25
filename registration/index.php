<?php
error_reporting(0);
session_start();

class userRegistration{
      function __construct(){
               include "../db_config.php";
      }
      function redirect($url = "index.php"){
               echo '<SCRIPT language="JavaScript">window.location="'.$url.'";</SCRIPT>';
      }
      function checkForValidFirstName($str){
        if(trim($str)=="" || strlen($str)<1){
          return "You must have First Name";
        }else{
          return NULL;
        }
      }
      
      function checkForValidPassword($str1,$str2){
        if(strlen($str1)<6)
        {
          return "Password must have atleast 6 character.";
        }
        
        if(trim($str1) <> trim($str2)){
          return "Password did not match! insert correctly.";
        }

        return NULL;

      }
      
      function checkForValidEmail($str){
        if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $str)) {
          return "Invalid email address.";
        }
        
        return NULL;

      }
}
$userReg = new userRegistration();



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

<?php
     if($_POST['submit']=="Save"){

       if($_POST['edit'] <>1){
         //Validation for UserName/UserID.
         if(strlen(trim($_POST['u_name']))<1){
           $error['uname'] = "Empty user name is not allowed.";
         }
         $query =mysql_query("select * from people where userid = '".$_POST['u_name']."'");
         if(mysql_num_rows($query)>0){
           $error['uname'] = "This User Name is already exists! Please choose another User Name.";
         }
       }

       //Validation for FirsrName.
       $error['fname'] = $userReg->checkForValidFirstName($_POST['f_name']);

       //Validation for password.
       $error['password'] = $userReg->checkForValidPassword($_POST['pass1'],$_POST['pass2']);

       //Validation for Email.
       $error['email'] = $userReg->checkForValidEmail($_POST['email']);

       if(strlen($error['uname'])<1 && strlen($error['fname'])<1 && strlen($error['password'])<1 && strlen($error['email'])<1 ){
         if($_POST['edit'] ==1){
           $query = mysql_query(" update people set password ='".$_POST['pass1']."', first_name='".$_POST['f_name']."', last_name='".$_POST['l_name']."', url='".$_POST['url']."', email='".$_POST['email']."', date_time=now() where id = ".$_SESSION['userid'] );

         }else{
           $query = mysql_query(" insert into people values('', '".$_POST['u_name']."', '".$_POST['pass1']."', '".$_POST['f_name']."', '".$_POST['l_name']."', '".$_POST['url']."', '".$_POST['email']."', now() ) ");


           //Get the current id.
           $query =mysql_query("select * from people order by id desc limit 1");
           $row = mysql_fetch_assoc($query);
           $_SESSION['userid'] = $row['id'];

           $userReg->redirect("");
         }
       }
       if($query ){
           $_SESSION['success'] = "User Registration successfully done. cllick <a href='../'>here</a> to go homepage ";
       }else{
           $_SESSION['error'] = "Error occured. Registration did not done. ";
       }


     }else{

       if($_GET['edit'] == "1"){

         //Get the current id.
         $query =mysql_query("select * from people where id = ".$_SESSION['userid']);
         $row = mysql_fetch_assoc($query);
         $_POST['u_name'] = $row['userid'];
         $_POST['f_name'] = $row['first_name'];
         $_POST['l_name'] = $row['last_name'];
         $_POST['pass1'] = $row['password'];
         $_POST['pass2'] = $row['password'];
         $_POST['url'] = $row['url'];
         $_POST['email'] = $row['email'];
       }
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
<li><a href="./">Registration</a></li>
<li><a href="./?edit=1">Edit</a></li>
<li><a href="../new/">Post Blog</a></li>
<?php else : ?>
<li><a href="#">Home</a></li>
<li><a href="login/">login</a></li>

<?php endif ?>

</ul>

<form action="" method="POST">
      <table>
             <tr>
               <td colspan="2">
                   <?php
                       if($error['fname']){
                         echo '<div style="color:red;">'.$error['fname'].'</div>';
                         $error['fname']="";
                       }
                   ?>
                 </td>
             </tr>
             <tr>
                 <td><b>First Name :</b></td>
                 <td><input type="text" name="f_name" value="<?php echo $_POST['f_name']?>"></td>
             </tr>
             <tr>
                 <td><b>Last Name :</b></td>
                 <td><input type="text"  name="l_name"  value="<?php echo $_POST['l_name']?>"></td>
             </tr>
             <?php if($_GET['edit'] <> "1") : ?>
               <tr>
                 <td colspan="2">
                   <?php
                       if($error['uname']){
                         echo '<div style="color:red;">'.$error['uname'].'</div>';
                         $error['uname']="";
                       }
                   ?>
                 </td>
               </tr>

               <tr>
                 <td><b>User Name :</b></td>
                 <td><input type="text" name="u_name"  value="<?php echo $_POST['u_name']?>"></td>
               </tr>
             <?php else :?>
               <tr>
                 <td><b>User Name :</b></td>
                 <td><?php echo $_POST['u_name']?></td>
               </tr>
             <?php endif ?>

             <tr>
               <td colspan="2">
                   <?php
                       if($error['password']){
                         echo '<div style="color:red;">'.$error['password'].'</div>';
                         $error['password']="";
                       }
                   ?>
                 </td>
             </tr>
             <tr>
                 <td><b>Password :</b></td>
                 <td><input type="password" name="pass1"  value="<?php echo $_POST['pass1']?>">&nbsp; Re type Password:&nbsp;<input type="password" name="pass2"  value="<?php echo $_POST['pass2']?>"></td>
             </tr>
             <tr>
               <td colspan="2">
                   <?php
                       if($error['email']){
                         echo '<div style="color:red;">'.$error['email'].'</div>';
                         $error['email']="";
                       }
                   ?>
                 </td>
             </tr>
             <tr>
                 <td><b>Email :</b></td>
                 <td><input type="text" name="email"  value="<?php echo $_POST['email']?>"></td>
             </tr>
             <tr>
               <td colspan="2">
                   <?php
                       if($error['url']){
                         echo '<div style="color:red;">'.$error['url'].'</div>';
                         $error['url']="";
                       }
                   ?>
                 </td>
             </tr>
             <tr>
                 <td><b>Url :</b></td>
                 <td><input type="text" name="url"  value="<?php echo $_POST['url']?>"></td>
             </tr>
             <tr>
                 <td colspan="2"><input type="submit" name="submit" value="Save"></td>
             </tr>
             <?php if($_GET['edit'] == "1"):?>
               <tr>
                 <td colspan="2"><input type="hidden" name="edit" value="1"></td>
             </tr>
             <?php endif?>
      </table>
</form>
</body>
</html>

