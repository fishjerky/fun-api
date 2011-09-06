<h3>版本</h3>
<div class="submsg">
<h4><i>1.0</i></h4>
</div>
<h3>下載位址</h3>
<div class="submsg">
<h4><i><a href="http://api.fun.wayi.com.tw/download/as3v1.zip">http://api.fun.wayi.com.tw/download/as3v1.zip</a></i></h4>
</div>

<h3>運作環境</h3>
<div class="submsg">
<h4><i>Flash Player 9.0以上版本</i></h4>
</div>

<h3>Class</h3>
<div class="submsg">
<h4><i>com.wayi.fun.Fun;</i></h4>
<h4><i>com.wayi.fun.core.FunResult;</i></h4>
</div>

<h3>說明</h3>
<div class="submsg">
<h5>com.wayi.fun.Fun</h5>
<h4><i>Public Method </i><i>(static)</i></h4>
<table border="0" cellspacing="0" cellpadding="0" class="msgtable">
<thead>
	<tr>
	<th align="center" style="width:20%">方法</th>
	<td align="center" style="width:20%">參數</td>
	<td align="center" style="width:20%">型態</td>
	<td align="center" style="width:20%">說明</td>
	</tr>
</thead>
<tbody>
	<tr>
	  <th rowspan="2" align="center" valign="top"><p>init</p></th>
	  <td>appid</td>
	  <td>number</td>
	  <td>初使化傳入基本參數</td>
	  </tr>
	<tr>
	  <td>accessToken</td>
	  <td>string</td>
	  <td>使用php或javascript從cookie取得</td>
	  </tr>
	<tr>
	  <th rowspan="4" align="center" valign="top"><p>api</p></th>
	  <td>method</td>
	  <td>string</td>
	  <td>API Method</td>
	  </tr>
	<tr>
	  <td>callback</td>
	  <td>Function</td>
	  <td>執行成功後呼叫的Function</td>
	  </tr>
	<tr>
	  <td>params</td>
	  <td>Object</td>
	  <td>參數</td>
	  </tr>
	<tr>
	  <td>requestMethod</td>
	  <td>string</td>
	  <td>http method</td>
	  </tr>
</tbody>
</table>
<h5>com.wayi.fun.core.FunResult</h5>
<h4><i>Public Properties </i></h4>
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
	<th>status</th>
	<td>string</td>

	<td>-</td>
    <td>httpStatus</td>
	</tr>
	<tr>
	  <th>data</th>
	  <td>object</td>
	  <td>-</td>
	  <td>結果</td>
	  </tr>
	<tr>
	  <th>rawData</th>
	  <td>string</td>
	  <td>&nbsp;</td>
	  <td>結果(json原始資料)</td>
	  </tr>
</tbody>
</table>
</div>
<h3>範例(ActionScript)：</h3>
<div class="submsg">
	<h6><a href="###" class="shrink" onclick="collapse(this, 's1')">取得朋友清單</a></h6>
    <div class="code" id="s1">
      <pre class="brush: as3;">
      import com.wayi.fun.Fun;
      import com.wayi.fun.core.FunResult;
      
      var appid:String = this.loaderInfo.parameters["appid"];
      var accessToken:String = this.loaderInfo.parameters["accessToken"];
      
	  Fun.init(appid, accessToken);
	  Fun.api("/v1/me/friends", onCallApi, null, "GET");
	  private function onCallApi(result:FunResult):void {
		if(result.status)
			trace(result.rawData);
		else
			trace("錯誤代碼：" + result.httpStatus);
	  }
	</pre>
    </div>
</div>
</div>

