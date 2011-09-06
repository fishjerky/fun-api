<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邀請FUN名片朋友</title>
<link href="/assets/css/invite.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

var alluser,selected=0;
function resetfilter(){
	$(".friends div" ).show();
	$('#name_input').val('');
	
}
function hide_friend_group() {
   $('#friend_group').removeClass('active');
   $('#friend_group_list').hide();
}

function friend_group() {
   $('#friend_group').toggleClass('active');
   $('#friend_group_list').toggle();
}

function filterByGroup(gid) {
   filterByAll();
   if(gid>=0){
	   $(".friends div" ).each(function(i){
		  if ($(this).attr("gid")==gid) 
			 $(this).show();
		  else
			 $(this).hide();
	   });
   }
	friend_group();
}

function filterByUids(uids) {
	for(var i=0;i<uids.lenght;i++){
		$('#user_'+i).show();
	}
   $('#view_all').removeClass('Active');
   $('#view_selected').removeClass('Active');
}

function filterByAll() {
	hide_friend_group();
	$('.friends div').show();
	$('#view_all').addClass('active');
	$('#view_selected').removeClass('active');
}

function filterBySelected() {
	hide_friend_group();
	$('.friends div[selected=false]').hide();
	$('.friends div[selected=true]').show();
	$('#view_all').removeClass('active');
	$('#view_selected').addClass('active');
}

function filterByName () {
   var name = $('#name_input').val().toLowerCase();
   if (name.length >= 0) {
      filterByAll();
   }

   $(".friends div .name" ).each(function(i){
      if ($(this).html().toLowerCase().indexOf(name) > -1)
         $(this).parent().show();
	  else
	  	 $(this).parent().hide();
   });
}


$(function(){
    $('#name_input').focus(function(){
		if(this.value == $(this).attr('default')) {
			this.value = '';
		}
	});
		
	$('#name_input').blur(function(){
		if(this.value == '') {
			this.value = $(this).attr('default');
		}
	});
	
	$(".friends div").hover(function() {
		if($(this).attr("selected")!="true")
			$(this).attr("class","f_hover txt13bk");
	}, function() {
		if($(this).attr("selected")!="true")
			$(this).attr("class","f_list txt13bk");
	});
	
	$(".friends div").click(function() {
		hide_friend_group();
		if($(this).attr("selected")=="false"){
			$(this).attr("class","f_click txt13w");
			$(this).attr("selected","true");
			$(this).find("input[type=checkbox]:first").attr("checked",true);
			selected++;
		}else{
			$(this).attr("class","f_list txt13bk");
			$(this).attr("selected","false");
			$(this).find("input[type=checkbox]:first").attr("checked",false);
			selected--;
		}
		$('#num_selected').html(selected);
	});

	$("#btn_invite").click(function(){
        if (typeof ($("input:checked").val()) == "undefined") {
            alert("請至少選取一位朋友");
            return false;
        }
        if ($("input:checked").length > <?php echo $settings['max'];?>) {
            alert("每次最多只能選取<?php echo $settings['max'];?>個朋友");
            return false;
        }
		 var data = $("#invites").serialize();
		 $.ajax({
             url: "http://api.fun.wayi.com.tw/invites",
             type: "post",
             data: data,
             success: function(data){
               if(data=="ok")
            	   $("#invites").submit();
               else
                   alert($data);
             }
         });
	});
});

//-->
</script>
</head>
<body>
<div class="finder">
    <div class="container">
        <input type="button" class="inputbutton" value="取消" />
        <h2><strong> 選擇你想要邀請的好友 </strong></h2>
        <h4>你可以點下方朋友相片，選最多<?php $max;?>個人發送邀請。</h4>
        <div class="f_label">
            <label>找朋友：</label>
            <input id="name_input" name="name" type="text" class="inputtext"  onkeyup="filterByName();" default="請輸入朋友姓名" value="請輸入朋友姓名" />
        </div>
        <div class="view_on">
            <div class="friend_group txt13Blue" style="" onclick="friend_group();return false;">
                <h3><a id="friend_group" href="#">&nbsp;朋友名單類別</a></h3>
                <ul id="friend_group_list">
                	<li><a href="#" onclick="filterByGroup(-1);return false;">全部</a></li>
                    <li><a href="#" onclick="filterByGroup(1);return false;">透過本站認識</a></li>
                    <li><a href="#" onclick="filterByGroup(2);return false;">透過活動認識</a></li>
                    <li><a href="#" onclick="filterByGroup(3);return false;">透過朋友認識</a></li>
                    <li><a href="#" onclick="filterByGroup(4);return false;">親人</a></li>
                    <li><a href="#" onclick="filterByGroup(5);return false;">同事</a></li>
                    <li><a href="#" onclick="filterByGroup(6);return false;">同學</a></li>
                    <li><a href="#" onclick="filterByGroup(7);return false;">不認識</a></li>
	                <?php foreach($group as $key=>$value):?>
	                <li><a href="#" onclick="filterByGroup(<?php echo $key;?>);return false;"><?php echo $value;?></a></li>
	                <?php endforeach;?>
                </ul>
            </div>
            <div class="select_filter">
                    <a id="view_all" href="#" class="active" onclick="filterByAll(); return false;">全部</a>
                    <a id="view_selected" href="#" onclick="filterBySelected(); return false;">已選取<strong>(<span id="num_selected">0</span>)</strong></a>
            </div>
        </div>
        <form id="invites" name="invites" action="<?php echo $settings['action_url'];?>" method="post" target="_parent">
		<input name="access_token" type="hidden" value="<?php echo $settings['access_token'];?>" />
		<input name="title" type="hidden" value="<?php echo $settings['title'];?>" />
		<input name="content" type="hidden" value="<?php echo $settings['content'];?>" />
		<input name="accept_url" type="hidden" value="<?php echo $settings['accept_url'];?>" />
        <div class="friends">
        <?php foreach($friends as $value):?>
            <div id="uid_<?php echo $value['uid'];?>" selected="false" gid="0" class="f_list txt13bk">
                <a href="#"><img src="<?php echo get_avatar_url($value['uid'], 'small');?>"/></a>
                <p class="name"><?php echo $value['username'];?></p>
                <p class="ok"><img src="/assets/images/invite/click.gif" alt="ok" /></p>
                <input id="cb_<?php echo $value['uid'];?>" name="touids[]" type="checkbox" value="<?php echo $value['uid'];?>" style="display:none" />
            </div>
        <?php endforeach;?>
        </div>
        <div class="clr"></div>
        <input id="btn_invite" type="button" value="發送邀請訊息"  style="width:150px;" class="inpute_button"/>
         </form>
        <input type="button" class="inputbutton" value="取消" />
    </div>
	<div class="clr"></div>
</div>
</body>
</html>
