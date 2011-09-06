<h3>我的應用程式
<div style="float:right;width:115px;height:33px;line-height:33px;font-size: 13px;text-align:center;background: url(/images/button_n3.gif) no-repeat left top;border: 1px solid #bbbcc1;">
<?php if($this->auth->is_logged_in()):?>
<a href="/developers/apps/create">建立應用程式</a>
<?php else:?>
<a href="http://fun.wayi.com.tw/login.php?callback=http://api.fun.wayi.com.tw/developers/apps/my">登入FUN名片</a>
<?php endif;?>
</div>
</h3>
	<?php foreach($myapp as $value):?>
	<div class="submsg">
	<h5><?php echo $value['appname'];?></h5>
	<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
	<tbody>
		<tr>
	    	<td width="100" rowspan="7" align="center" style=" padding:20px; background-color:#F8F8F8;"><img src="<?php if(empty($value['thumb'])):?>/images/nologo.gif<?php else: echo $value['thumb'];?><?php endif;?>" alt="" width="123" height="123" />
	   	    <div style="padding:15px;"><a href="/developers/apps/update?appid=<?php echo $value['appid'];?>">編輯</a>&nbsp;&nbsp;| &nbsp;<a href="/developers/apps/delete?appid=<?php echo $value['appid'];?>">刪除</a></div></td>
			<th>Client ID</th>
			<td><?php echo $value['appid'];?></td>
		</tr>
		<tr>
	    	<th>Client Secret</th>
			<td><?php echo $value['client_secret'];?></td>
		</tr>
		<tr>
	    	<th>Site URL</th>
			<td><?php echo $value['siteurl'];?></td>
		</tr>
		<tr>
	    	<th>Redirect URI</th>
			<td><?php echo $value['redirect_uri'];?></td>
		</tr>
		<tr>
	    	<th>類別</th>
			<td><?php echo $value['classid'];?></td>
		</tr>
		<tr>
	    	<th>應用程式簡介</th>
			<td><?php echo $value['description'];?></td>
		</tr>
	</tbody>
	</table>
	</div>
	<p>&nbsp;&nbsp;</p>
	<?php endforeach;?>