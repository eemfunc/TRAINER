<?php
if(isset($_GET["sign-in"]) && $_GET["sign-in"] == "now"){
    if(!$core->chk_POST(array('email', 'password')))
        $core->err();
    elseif(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", strtolower($_POST["email"])))
        $core->err();
    elseif(!$core->dbNumRows('users', array('activated' => '1', 'email' => $core->aes(strtolower($_POST['email'])))))
        $core->err();
    elseif(!$core->dbNumRows('users', array('activated' => '1', 'password' => $core->aes($_POST['password'])."' AND email='".$core->aes(strtolower($_POST['email'])))))
        $core->err();
    else{
        $core->userSignIn(strtolower($_POST['email']));
        $core->err();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $core->txt('0105') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/vendors/jquery/jquery-3.4.1.min.js"></script>
    <script src="<?php echo V_THEME_FOLDER_PATH; ?>assets/js/java.script.sign-in.js"></script>
    <style>
        @font-face{font-family:Helvetica-Bold;src: url('<?php echo V_THEME_FOLDER_PATH; ?>assets/fonts/HelveticaNeue/HelveticaNeueW23-Bd.woff');}
        @font-face{font-family:Helvetica-Reg;src: url('<?php echo V_THEME_FOLDER_PATH; ?>assets/fonts/HelveticaNeue/HelveticaNeueW23-Reg.woff');}
    </style>
    <link rel="stylesheet" href="<?php echo V_THEME_FOLDER_PATH; ?>assets/css/style.sign-in.css">
</head>
<body>
<div class="wrapper">
	<div class="container">
        <form class="form" method="post" action="<?php echo V_URLP; ?>sign-in&sign-in=now" autocomplete="off">
            <input autocomplete="false" name="hidden" type="text" style="display:none;">
			<input type="text" placeholder="Email" name="email">
			<input type="password" placeholder="*******" name="password">
			<button type="submit" id="login-button"><?php echo $core->txt('0105') ?></button>
        </form>
	</div>
	<ul class="bg-bubbles"><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
</div>
</body>
</html>