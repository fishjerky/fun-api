<script type="text/javascript">
$().ready(function() {
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {
			appname: "required",
			description: "required",
			thumb: {
				required: true,
				url: true
			},
			siteurl: {
				required: true,
				url: true
			}
		},
		messages: {
			appname: "必填欄位",
			description: "必填欄位",
			thumb: {
				required: "必填欄位",
				url: "請輸入正確網址"
			},
			siteurl: {
				required: "必填欄位",
				url: "請輸入正確網址"
			}
		}
	});
});
</script>
<form id="form1" name="form1" method="post" action="/developers/apps/update?appid=<?php echo $app['appid']; ?>">
<h3>修改應用程式</h3>

<div class="submsg">
<h5>基本資料</h5>
<table border="0" cellspacing="0" cellpadding="0" class="msgtable" style="width:600px;">
<tbody>
  <tr>
    <th align="center">應用程式名稱</th>
    <td style="400px;"><input name="appname" type="text" id="appname" value="<?php echo $app['appname']; ?>" size="70"/></td>
  </tr>
  <tr>
    <th align="center">簡介</th>
    <td><textarea name="description" id="description" cols="75" rows="5"><?php echo $app['description']; ?></textarea></td>
  </tr>
  <tr>
    <th align="center">LOGO網址</th>
    <td><input name="thumb" type="text" id="thumb"  value="<?php echo $app['thumb']; ?>" size="70"/></td>
  </tr>
</tbody>
</table>
<h5><strong>串接設定</h5>
<table border="0" cellspacing="0" cellpadding="0" class="msgtable" style="width:600px;">
<tbody>
  <tr>
    <th align="center">應用程式網址</th>
    <td style="400px;"><input name="siteurl" type="text" id="siteurl"  value="<?php echo $app['siteurl']; ?>" size="80" /></td>
  </tr>
  <tr>
    <th align="center">OAuth Redirect Uri</th>
    <td><input name="redirect_uri" type="text" id="redirect_uri"  value="<?php echo $app['redirect_uri']; ?>" size="80"  value="" /></td>
  </tr>
</tbody>
</table>
<p>&nbsp;</p>
<div style="width:600px; text-align:right;">
	<input type="submit" name="button" id="button" value="儲存資料" class="btn" />
	<input type="reset" name="Reset" id="button" value="取消" class="btn" />
</div>
</div>
</form>