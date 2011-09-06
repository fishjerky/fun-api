<h3>取得頭像</h3>
<div class="submsg">
<h4><i>URL：http://api.fun.wayi.com.tw/{uid}/avatar/{size}</i></h4>
<h4><i>Method：GET</i></h4>
<h4 style="color:#999">註：頭像為公開資料不需access_token即可取得</h4>
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
        <td>FUN名片代號</td>
	</tr>
	<tr>
        <th valign="top">size</th>
        <td valign="top">string</td>
        <td valign="top">small</td>
        <td>big：200 x 250<br />middle：120 x 120<br />small:48 x 48</td>
	</tr>
</tbody>
</table>
<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">HTML範例</a></h6>
<div class="code" id="s1">
  <pre class="brush: xml;">
&lt;img arc=&quot;http://api.fun.wayi.com.tw/avatar/85649/small&quot; board=&quot;0&quot;&gt;
</pre>
</div>
</div>