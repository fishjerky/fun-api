<?php
include_once('./init.php');
try {
	//取得使用者個人資料
	$user = $fun->Api('/v1/me/user');
} catch (ApiException $e) {
	  echo "錯誤代碼：".$e->getCode();
	  echo "說明：".$e->getMessage();
	  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://api.fun.wayi.com.tw/assets/jqplugin/v1.min.js"></script>
<title>Untitled Document</title>
<style type="text/css">
body {
		background-color: #F4FAFF;
}
</style>
</head>

<body>
<script language="javascript">
$(window).load(function() {
	$(this).fun.iframe.setAutoResize();
});
</script>
<div style=" text-align:center;">
  <p><strong>FUN名片串接範例(淡藍色區塊都屬於外部應用程式範圍) </strong></p>
  <p><a href="user.php">取得個人資料(PHP)</a> | <a href="friends.php">取得好友(PHP)</a> | <a href="index.php">jQuery邀請朋友畫面</a> | <a href="flash.php">AS3存取API</a></p>
  <table width="600" border="1" cellpadding="0" cellspacing="0" align="center">
    <tr style="color:#FFF;">
      <td align="center" bgcolor="#0080FF"><strong>UID</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>登入類別</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>暱稱</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>姓別</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>電子信箱</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>家鄉</strong></td>
      <td align="center" bgcolor="#0080FF"><strong>居住地</strong></td>
    </tr>
    <tr>
      <td align="center"><?php echo $user['uid']?></td>
      <td align="center"><?php echo $user['logintype']?></td>
      <td align="center"><?php echo $user['username']?></td>
      <td align="center"><?php echo $user['sex']?></td>
      <td align="center"><?php echo $user['email']?></td>
      <td align="center"><?php echo $user['birthprovince']?><?php echo $user['birthcity']?></td>
      <td align="center"><?php echo $user['resideprovince']?><?php echo $user['residecity']?></td>
    </tr>
  </table>

  </p>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body>
</html>