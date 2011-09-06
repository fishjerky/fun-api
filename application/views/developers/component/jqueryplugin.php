<script type="text/javascript">
$(function () {
	var height = document.body.offsetHeight;
	$('<iframe " src="http://fun.wayi.com.tw/proxy.html?' +  height + '" style="display: none;"><\/iframe>').appendTo('body');
});
</script>
<h3>版本</h3>
<div class="submsg">
<h4><i>1.0</i></h4>
</div>
<h3>下載位址</h3>
<div class="submsg">
<h4><i><a href="http://api.fun.wayi.com.tw/assets/jqplugin/v1.min.js">http://api.fun.wayi.com.tw/assets/jqplugin/v1.min.js</a></i></h4>
</div>

<h3>運作環境</h3>
<div class="submsg">
<h4><i>jQuery 1.4.2以上版本</i></h4>
</div>

<h3>說明</h3>
<div class="submsg">
    <h5>jQuery.fun.iframe.setAutoResize()<br />
    自動調整iframe大小 </h5><br />
    <div class="code" id="s1">
      <pre class="brush: jscript;"> &lt;script language=&quot;javascript&quot;&gt;
$(function(){
&nbsp;&nbsp;&nbsp;&nbsp;$(this).fun.iframe.setAutoResize();
});
&lt;/script&gt;
    </pre>
    </div>
    <h5>jQuery.fun.iframe.setHeight(size)<br />
    手動設定iframe高度 </h5><BR />
<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
<thead>
	<tr>
	<td align="center" style="width:20%">參數</td>
	<td align="center" style="width:20%">型態</td>
	<td align="center" style="width:20%">說明</td>
	</tr>
</thead>
<tbody>
	<tr>
	<td>size</td>
    <td>int</td>
    <td><p>高度</p></td>
	</tr>
</tbody>
</table>
    <div class="code" id="s2">
      <pre class="brush: jscript;"> &lt;script language=&quot;javascript&quot;&gt;
$(function(){
&nbsp;&nbsp;&nbsp;&nbsp;$(this).fun.iframe.setHeight(300);
});
&lt;/script&gt;
    </pre>
	</div>
    
    <h5>jQuery.fun.iframe.invites(options)<br />
    發送邀請訊息 </h5><BR />
<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
<thead>
	<tr>
	<td align="center" style="width:20%">參數</td>
	<td align="center" style="width:20%">型態</td>
	<td align="center" style="width:20%">說明</td>
	</tr>
</thead>
<tbody>
	<tr>
	  <td><span class="brush: JScript;">token_screet</span></td>
	  <td>string</td>
	  <td><p>access_token</p>
      <p>(使用php或javascript從cookie取得)</p></td>
	  </tr>
	<tr>
	  <td>max</td>
	  <td>int</td>
	  <td>最多邀請人數</td>
	  </tr>
	<tr>
	  <td>title</td>
	  <td>string</td>
	  <td>標題</td>
	  </tr>
	<tr>
	  <td>content</td>
	  <td>string</td>
	  <td>邀請說明</td>
	  </tr>
	<tr>
	  <td>accept_url</td>
	  <td>string</td>
	  <td>玩家接受邀請後連結目標網址</td>
	  </tr>
	<tr>
	  <td>action_url</td>
	  <td>string</td>
	  <td>邀請送出後接收玩家所勾選的程式</td>
	  </tr>
</tbody>
</table>
    <div class="code" id="s3">
      <pre class="brush: jscript;"> &lt;script language=&quot;javascript&quot;&gt;
$(function(){
	var options = {appid:&quot;appid&quot;,
					access_token:&quot;access_token&quot;,
					max:5,
					title:&quot;FUN名片邀請測試(標題)&quot;,	
					content:&quot;FUN名片邀請測試(內文)&quot;,
					accept_url:&quot;http://api.fun.wayi.com.tw/example/gift.php&quot;,
					action_url:&quot;http://api.fun.wayi.com.tw/example/invites.php&quot;
				  };
  $(&quot;body&quot;).fun.invites(options);
});
&lt;/script&gt;
    </pre>
</div>

