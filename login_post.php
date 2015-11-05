<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script type="text/javascript" language="javascript">
<!--
function loginerr() {
  alert("ユーザ名もしくはパスワードが違います");
  location.href="index.html";
}
//-->
</script>
<?php
mb_http_output('UTF-8');
mb_internal_encoding('UTF-8');

if (isset($_POST['cancel'])) {
  header("Location: index.html");
}
include('db_setting.php');

$user = $_POST["username"];
$pass = $_POST["password"];

$db = pg_pconnect('host='.$DBHost.' port='.$DBPort.' dbname='.$DBName.' user='.$DBUser.' password='.$DBPass);
$sql = "select email,name,type from users where username='".$user."' and userpass='".$pass."'";
$res = pg_query($db, $sql);
$row = pg_num_rows ($res);
$col = pg_fetch_row($res);
$email = $col[0];
$name = $col[1];
$type = $col[2];
pg_close($db);
$error_type = 0;
if ($row > 0) {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $name;
    $_SESSION['type'] = $type;
    header("Location: list.html");
} else {
  $error_type = 1;
}
echo "</head>";
if ($error_type == 1) {
  echo "<body onload='loginerr()'></body>";
}
?>
</html>
