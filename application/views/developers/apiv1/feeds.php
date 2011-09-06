
<a name="register"></a>
<h3>發佈塗鴉牆訊息</h3>

<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/feed</i></h4>
<h4><i>Method：POST</i></h4>
<h5>需求參數</h5>
<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
<thead>
	<tr>
	<th style="width:20%">參數</th>
	<td style="width:20%">格式</td>
	<td style="width:20%">預設值</td>
	<td>說明</td>
	</tr>
</thead>
<tbody>
	<tr>
        <th>uid</th>
        <td>int</td>
        <td>-</td>
        <td>FUN名片代號(UID可改為ME表示當前的User)</td>
	</tr>
	<tr>
        <th>title</th>
        <td>string</td>
        <td>-</td>
        <td>標題</td>
	</tr>
	<tr>
        <th>subject</th>
        <td>string</td>
        <td>-</td>
        <td>主題</td>
	</tr>
	<tr>
        <th>summary</th>
        <td>string</td>
        <td>-</td>
        <td>內文</td>
	</tr>
	<tr>
        <th>general</th>
        <td>string</td>
        <td>-</td>
        <td>提示</td>
	</tr>
	<tr>
        <th>image</th>
        <td>string</td>
        <td>-</td>
        <td>圖片</td>
	</tr>
	<tr>
        <th>image_link</th>
        <td>string</td>
        <td>-</td>
        <td>連結</td>
	</tr>
</tbody>
</table>

<h5>回應參數</h5>
<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
<thead>
	<tr>
	<th style="width:20%">參數</th>
	<td style="width:20%">格式</td>
	<td style="width:20%">預設值</td>
	<td>說明</td>
	</tr>
</thead>
<tbody>
	<tr>
        <th>feedid</th>
        <td>int</td>
        <td>-</td>
        <td>塗鴉牆編號</td>
	</tr>
</tbody>
</table>
<br />
<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">參數示意圖</a></h6>
<div id="s1">
<img src="/assets/images/feed.png" board="0"></img>
</div>
<h6><a href="###" class="shrink" onclick="collapse(this, 's2')">範例 (ASP)</a></h6>
<div class="code" id="s2">
<pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
Dim data = "title=標題&subject=主題&sumary=內文&general=提示
&image=http://invite.wayi.com.tw/activity/991209/content/logo.jpg
&image_link=http://fun.wayi.com.tw/"
Dim result = fun.Api("/v1/me/user","post","xml",data) 
If result.status Then 
xml = result.rawData 
End If
</pre></div>
</div>