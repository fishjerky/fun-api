
<a name="register"></a>
<h3>取得粉絲團清單</h3>

<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/fans</i></h4>
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
        <th>fanid</th>
        <td>int</td>
        <td>-</td>
        <td>粉絲團代號</td>
	</tr>
	<tr>
        <th>name</th>
        <td>string</td>
        <td>-</td>
        <td>粉絲團名稱</td>
	</tr>
</tbody>
</table>
<br />

<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">範例 (ASP)</a></h6>
<div class="code" id="s1">
  <pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
Dim result = fun.Api("/v1/me/fans","get","xml")
If result.status Then
	xml = result.data
End If
</pre></div>
</div>