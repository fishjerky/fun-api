
<a name="register"></a>
<h3>取得會員基本資料</h3>

<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/v1/{uid}/user</i></h4>
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
        <th>uid</th>
        <td>int</td>
        <td>-</td>
        <td>FUN名片代號</td>
	</tr>
	<tr>
        <th>logintype</th>
        <td>string</td>
        <td>-</td>
        <td>登入類別</td>
	</tr>
	<tr>
        <th>pid</th>
        <td>string</td>
        <td>-</td>
        <td>華義帳號或OpenID假帳號</td>
	</tr>
	<tr>
        <th>opid</th>
        <td>string</td>
        <td>-</td>
        <td>OpenID代碼</td>
	</tr>
	<tr>
        <th>username</th>
        <td>string</td>
        <td>-</td>
        <td>使用者暱稱</td>
	</tr>
	<tr>
        <th>birthprovince</th>
        <td>string</td>
        <td>-</td>
        <td>出生地(省)</td>
	</tr>
	<tr>
        <th>birthcity</th>
        <td>string</td>
        <td>-</td>
        <td>出生地(城市)</td>
	</tr>
	<tr>
        <th>resideprovince</th>
        <td>string</td>
        <td>-</td>
        <td>居住地(省)</td>
	</tr>
	<tr>
        <th>residecity</th>
        <td>string</td>
        <td>-</td>
        <td>居住地(城市)</td>
	</tr>
</tbody>
</table>
<br />

<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">範例 (ASP)</a></h6>
<div class="code" id="s1">
<pre class="brush: vb;">
Set fun = Server.CreateObject("wayi.fun")
Set result = fun.Api("/v1/me/user","get","xml")
If result.status Then
	xml = result.data
End If
</pre></div>
</div>