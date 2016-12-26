<?php
if(isset($_SESSION['admin_id'])){
  header("Location: ".DOMAIN);
  exit();
}
if (isset($_POST["start_login"])) {
  $username = addslashes(trim($_POST['username']));
  $password = stripslashes($_POST['password']);
  if($username == useradmin && $password == passadmin){
      $_SESSION['admin_id'] = array('username' => $_POST['username']);
      header("Location: ./");
      exit();
  }else{
    $error='<div align="center"><div class="alert alert-danger" role="alert">Username/Password wrong!</div></div>';
  }
  
}
include 'header.php';
?>
<!-- Page Content -->
<div class="container">
<?php echo isset($error)?$error:''; ?>
    <div class="row">

        <div class="login-page">
            <div class="form">
                <form action="" method="POST" class="register-form">
                    <input name="name" type="text" placeholder="name"/>
                    <input name="password" type="password" placeholder="password"/>
                    <input name="email" type="text" placeholder="email address"/>
                    <input type="submit" name="submit" class="button" value="create">
                    <p class="message">Already registered? <a href="javascript:void(0)">Sign In</a></p>
                </form>
                <form name="login">
                    <input name="username" type="text" placeholder="username"/>
                    <input name="password" type="password" placeholder="password"/>
                    <input onClick="passResponse(); return false;" type="submit" name="submit" class="button" value="login">
                    <p class="message">Not registered? <a href="javascript:void(0)">Create an account</a></p>
                </form>
            </div>
        </div>

    </div>

</div>
<!-- /.container -->
<form method="post" action="" name="lform">
  <input type="hidden" name="username">
  <input type="hidden" name="password">
  <input name="start_login" type="hidden" value="<?php echo time(); ?>" />
</form>
<!-- jQuery -->
<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/md5.js"></script>
<script type="text/javascript">
    $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
</script>
<script language="javascript">
  <!--
  function passResponse() {
    document.lform.username.value = document.login.username.value;
    document.lform.password.value = CryptoJS.MD5(document.login.password.value);
    document.login.password.value = "";
    document.lform.submit();
  }
  // -->
</script>
</body>

</html>
