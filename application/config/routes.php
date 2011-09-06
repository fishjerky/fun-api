<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "developers/oauth";
$route['404_override'] = '';

//頭像
$route['avatar/(\d+)/([a-z]+)'] = "common/avatar/index/$1/$2";

//頭像
$route['invites'] = "common/invites/default";

//使用者
$route['v1/(:any)/user'] = "v1/user/default/uid/$1";

//相本
$route['v1/(:any)/albums'] = "v1/albums/default/uid/$1/albumid/0";
$route['v1/(:any)/albums/(\d+)'] = "v1/albums/default/uid/$1/albumid/$2";

//塗鴉牆
$route['v1/(:any)/feeds'] = "v1/feeds/default/uid/$1";

//好友
$route['v1/(:any)/friends'] = "v1/friends/default/uid/$1";
$route['v1/(:any)/friends/app'] = "v1/friends/app/uid/$1/status/installed";

//粉絲團
$route['v1/(:any)/fans'] = "v1/fans/default/uid/$1";
$route['v1/(:any)/fans/(\d+)'] = "v1/fans/default/uid/$1/fanid/$2";

/* End of file routes.php */
/* Location: ./application/config/routes.php */