<h3>簡介</h3>
<div class="mainmsg">
  <p>FUN名片使用OAuth 2.0(Drat 13)國際通用的授權方式，避免會員在第三方應用程式中輸入用戶名及密碼。<br/>
  所有API參數傳遞皆須使用access_token生成signature base string才能存取， 有關OAuth 2.0的技術說明可參考下列網站</p>
  <div>
  <p>OAuth官方：<a href="http://oauth.net">http://oauth.net</a>。 </p>
  <p>Facebook：<a href="http://developers.facebook.com/docs/authentication">http://developers.facebook.com/docs/authentication</a></p>
  <p>Google：<a href="http://code.google.com/intl/zh-TW/apis/accounts/docs/OAuth2.html">http://code.google.com/intl/zh-TW/apis/accounts/docs/OAuth.html </a></p>
  <p>利用FUN名片提供的元件可以協助完成OAuth 2.0認證及API存取。</p>
    </div>
</div>
<p>&nbsp;</p>
<h3>會員認證OAuth 2.0</h3>
<div class="mainmsg">
  	<div class="pic"></div>
    <h5>OAuth Method</h5>
    <ul style="margin-left:30px;">
          <li>OAuth/authorize</li>
          <li>OAuth/token</li>
    </ul>
    <h5>authorize</h5>
        <ul style="margin-left:30px;">
          <li>URL：<a href="http://api.fun.wayi.com.tw/authorize">http://api.fun.wayi.com.tw/authorize</a></li>
          <li>Method：GET</li>
    </ul>
    <h5>access_token</h5>
        <ul style="margin-left:30px;">
          <li>URL：<a href="http://api.fun.wayi.com.tw/token">http://api.fun.wayi.com.tw/token</a></li>
          <li>Method：POST</li>
          <li>有效時間：無限制時間，使用者將應用程式移除後失效</li>
    </ul>

</div>
<p>&nbsp;</p>
<h3>串接流程</h3>
<div class="submsg">
    <div class="pic">
    <h5>外部應用程式</h5>
    <table>
    <tr>
        <th class="box">申請API Key</th>
        <td class="rr"></td>
        <th class="box">登入FUN名片並詢問會員是否授權</th>
        <td class="rr"></td>
        <th class="box">取得auth_code後換取access_token</th>
        <td class="rr"></td>
        <th class="box">利用access_token存取API</th>
    </tr>
    </table>
    </div>
    <div class="pic">
    <h5>內嵌於FUN名片(Ifram)</h5>
    <table>
    <tr>
        <th class="box">申請API Key</th>
        <td class="rr"></td>
        <th class="box">經由get取得access_tokenn(註1)</th>
        <td class="rr"></td>
        <th class="box">利用access_token存取API</th>
    </tr>
    </table>
    <br />註1：access_token參數名稱為session(JSON格式)
    </div>
</div>
<p>&nbsp;</p>
<h3>API存取方式</h3>
<div class="submsg">
	http://api.fun.wayi.com.tw/v1/[API Method]?[Parameters] 
</div>
<p>&nbsp;</p>
<h3>API輸出格式</h3>
<div class="submsg">
FUN名片API提供兩種輸出格式 XML 與 JSON，可使用 format 參數來指定回傳的格式，未指定格式則預設值為JSON。
</div>
<p>&nbsp;</p>
<h3>Http Method</h3>
<div class="submsg">
<table border="0" cellspacing="0" cellpadding="0" class="msgtable" style=" width:600px">
<thead>
	<tr>
	<th>Method</th>
	<td>說明</td>
	</tr>
</thead>
<tbody>
	<tr>
	<th>GET</th>
	<td>取得資料</td>
	</tr>
	<tr>
	<th>POST</th>
	<td>新增資料</td>
	</tr>
	<tr>
	<th>PUT</th>
	<td>更新 (如果目標資料不存在則新增資料)</td>
	</tr>
	<tr>
	<th>DELETE</th>
	<td>刪除資料</td>
	</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>
<h3>Http Status Code</h3>
<div class="submsg">
    <table border="0" cellspacing="0" cellpadding="0" class="msgtable" style=" width:600px">
    <thead>
        <tr>
        <th>代碼</th>
        <td>說明</td>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th>200</th>
        <td>成功</td>
        </tr>
        <tr>
        <th>401</th>
        <td>未經授權</td>
        </tr>
        <th>404</th>
        <td>API Method錯誤，參數傳遞錯誤，資料不存在</td>
        </tr>
    </tbody>
    </table>
</div>