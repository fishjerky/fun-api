<h3>取得相簿清單</h3>

<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/albums</i></h4>
<h4><i>Method：GET</i></h4>
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
        <th>albumid</th>
        <td>int</td>
        <td>0</td>
        <td>相簿編號,0為預設相簿</td>
	</tr>
	<tr>
        <th>name</th>
        <td>string</td>
        <td>-</td>
        <td>相簿名稱</td>
	</tr>
</tbody>
</table>
<br />

<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">範例 (ASP)</a></h6>
<div class="code" id="s1">
  <pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
dim result = fun.Api("/v1/me/albums","get")
If result.status Then
	xml = result.rawData
End If
</pre></div>
</div>

<h3>取得相簿裡所有的照片</h3>

<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/albums/{albumid}</i></h4>
<h4><i>Method：GET</i></h4>
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
        <th>albumid</th>
        <td>int</td>
        <td>0</td>
        <td>相簿編號,0為預設相簿</td>
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
        <th>pid</th>
        <td>int</td>
        <td>-</td>
        <td>照片編號</td>
	</tr>
	<tr>
        <th>title</th>
        <td>string</td>
        <td>-</td>
        <td>標題</td>
	</tr>
	<tr>
        <th>pic_url</th>
        <td>string</td>
        <td>-</td>
        <td>相片網址</td>
	</tr>
	<tr>
        <th>thumb_url</th>
        <td>string</td>
        <td>-</td>
        <td>相片縮圖</td>
	</tr>
</tbody>
</table>
<br />

<h6><a href="###" class="shrink" onclick="collapse(this, 's2')">範例 (ASP)</a></h6>
<div class="code" id="s2">
  <pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
Dim result = fun.Api("/v1/me/albums/35215","get")
If result.status Then
	xml = result.rawData
End If
</pre></div>
</div>

<h3>上傳照片至特定相簿</h3>
<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/albums/{albumid}</i></h4>
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
        <th>albumid</th>
        <td>int</td>
        <td>0</td>
        <td>相簿編號,0為預設相簿</td>
	</tr>
	<tr>
        <th>title</th>
        <td>string</td>
        <td>-</td>
        <td>標題</td>
	</tr>
	<tr>
        <th>upload_file</th>
        <td>file</td>
        <td>-</td>
        <td>照片</td>
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
        <th>pid</th>
        <td>int</td>
        <td>-</td>
        <td>照片編號</td>
	</tr>
	<tr>
        <th>pic_url</th>
        <td>string</td>
        <td>-</td>
        <td>相片網址</td>
	</tr>
	<tr>
        <th>thumb_url</th>
        <td>string</td>
        <td>-</td>
        <td>相片縮圖</td>
	</tr>
</tbody>
</table>
<br />

<h6><a href="###" class="shrink" onclick="collapse(this, 's3')">範例 (ASP)</a></h6>
<div class="code" id="s3">
  <pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
Dim result = fun.Api("/v1/me/albums/35215","post")
Dim data = "title=標題&upload_file=photo"
If result.status Then
	xml = result.rawData
End If
</pre>
註：upload_file請填寫表單欄位名稱
</div>
</div>