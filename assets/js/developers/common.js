var chm = 0;
var menu =
[
	['簡介','/developers/oauth'],
	['我的應用程式','/developers/apps/my'],
	['API v1.0',''],
	[
		['會員資料','/developers/apiv1/user'],
		['塗鴉牆','/developers/apiv1/feeds'],
		['好友','/developers/apiv1/friends'],
		['粉絲團','/developers/apiv1/fans'],
		['相簿','/developers/apiv1/albums'],
		['頭像','/developers/avatar'],
	],
	['開發元件',''],
	[
		['ActionScript 3.0','/developers/component/as3'],
		['jQuery Plugin','/developers/component/jqueryplugin'],
		['PHP','/developers/component/php'],
		['ASP 3.0','/developers/component/asp']
	]
];

function $(id) {
	return document.getElementById(id);
}

var currentfile = location.href.replace('http://'+location.hostname,'');
function documentmenu(showtype) {
	var returnstr = '';
	if(showtype && chm) {
		document.body.style.background = 'none';
		$('wrap').style.paddingLeft = 0;
		return;
	}
	var menucount = 0;
	var tabon;
	for(var i in menu) {
		if(typeof(menu[i][0]) == 'object') {
			if(showtype) {
				returnstr += '<div class="subinfo" id="menu' + menucount + '" style="display: ">';
				for(var k in menu[i]) {
					tabon = '';
					if(currentfile == menu[i][k][1]) {
						tabon = 'tabon ';
					}
					if(!menu[i][k][1]) {
						menu[i][k][1] = '';
					}
					returnstr += '<a class="' + tabon + 'sidelist" href="' + menu[i][k][1] + '">' + menu[i][k][0] + '</a>';
				}
				returnstr += '</div>';
			}
		} else {
			tabon = '';
			if(!menu[i][1]) {
				menu[i][1] = '';
			}
			if(showtype) {
				menucount++;
				if(currentfile == menu[i][1]) {
					tabon = 'tabon ';
				}
				returnstr += '<a class="' + tabon + 'sideul"';
				if(menu[i][1] != '') {
					returnstr += ' href="' + menu[i][1] +'"';
				}
				returnstr += '><em class="shrink" onclick="collapse(this, \'menu' + menucount + '\');return false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</em>' + menu[i][0] + '</a>';
			} else {
				returnstr += '<li><a';
				if(menu[i][1] != '') {
					returnstr += ' href="' + menu[i][1] +'"';
				}
				returnstr += '>' + menu[i][0] + '</a></li>';
			}
		}
	}
	if(showtype) {
		document.write('<div class="side" style="height: 400px;">' + returnstr + '</div>');
	} else {
		return '<ul>' + returnstr + '</ul>';
	}
}

function showmenu(ctrl) {
	ctrl.className = ctrl.className == 'otherson' ? 'othersoff' : 'otherson';
	var menu = parent.document.getElementById('toggle');
	if(!menu) {
		menu = parent.document.createElement('div');
		menu.id = 'toggle';
		menu.innerHTML = documentmenu(0);
		var obj = ctrl;
		var x = ctrl.offsetLeft;
		var y = ctrl.offsetTop;
		while((obj = obj.offsetParent) != null) {
			x += obj.offsetLeft;
			y += obj.offsetTop;
		}
		menu.style.left = x + 'px';
		menu.style.top = y + ctrl.offsetHeight + 'px';
		menu.className = 'togglemenu';
		menu.style.display = '';
		parent.document.body.appendChild(menu);
	} else {
		menu.style.display = menu.style.display == 'none' ? '' : 'none';
	}
}

function collapse(ctrlobj, showobj) {
	if(!$(showobj)) {
		return;
	}
	if($(showobj).style.display == '') {
		ctrlobj.className = 'spread';
		$(showobj).style.display = 'none';
	} else {
		ctrlobj.className = 'shrink';
		$(showobj).style.display = '';
	}
}
