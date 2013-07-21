<?php
session_start();
require_once 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (Ackintosh\Captcha::isValidCode($_POST['code']))
        echo 'ok';
    else
        echo 'ng';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>captcha sample</title>
</head>
<body>
<img id="captcha" src="sample_captcha.php">
<input id="btn" type="button" value="refresh">
<form method="post" action="">
<div><input type="text" name="code" value=""> <input type="submit" value="send"></div>
</form>
<script src="//code.jquery.com/jquery-2.0.3.min.js"></script>
<script>
$('#btn').click(function () {
    $('#captcha').attr('src', $('#captcha').attr('src') + '?' + new Date().getTime());
});
</script>
</body>
</html>
