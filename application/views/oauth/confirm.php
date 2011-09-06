<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="/assets/css/authorize.css"/>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>
</head>

<body>
<div><iframe src="http://www.wayi.com.tw/wayi-bar/wayi-bar.asp" height="35" width="100%" scrolling="no" frameborder="no" allowtransparency="true"></iframe></div>
<form id="form1" name="form1" method="post" action="/oauth/confirm">
<table class="reg" style="margin-top: 20px; margin-bottom: 20px;" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
		<td style="padding: 20px;" valign="top"><h1>授權請求</h1>
			<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0">
		            <tbody>
		            	<tr>
		            		<td width="122" rowspan="2" align="center" valign="top"><img src="<?php echo $logo;?>"></td>
		            		<td>&quot;<?php echo $name;?>&quot;需要你的授權以執行以下事項：</td>
		            	</tr>
		            	<tr>
		            	<td valign="top"><strong>允許此程式取得我的基本資料</strong><br />
		            	允許此程式取得包括姓名、大頭貼照片、性別、所屬網絡、用戶 ID、朋友名單等基本資料，以及其他我同意和所有人分享的內容。<br>
		            	<strong>在我的塗鴉牆上發佈訊息</strong><br />
		            	 允許「<?php echo $name;?>」應用程式在我的塗鴉牆上發佈動態訊息、網誌、相片、以及影片內容</td>
		            	</tr>
		            	<tr></tr>
		            	<tr>
		            		<td colspan="2" align="center" valign="top"><input id="regsubmit" name="approve" value="同意" class="submit" type="submit"> <input id="regsubmit" name="deny" value="拒絕" class="submit" type="submit"></td>
		            	</tr>
		            </tbody>
	        </table>
	   </td>
	   </tr>
	</tbody>
</table>
</form>
</body>
</html>