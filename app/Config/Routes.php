<?php namespace Config;
use Config\Database as Database;
use \CodeIgniter\Database\ConnectionInterface;
/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$Database = new Database;
if ($Database->default['hostname']=='') {header('Location: /init.html'); exit;}
$mysqli = mysqli_connect($Database->default['hostname'], $Database->default['username'], $Database->default['password'], $Database->default['database']);
if ($mysqli->connect_errno) { header('Location: /init.html'); exit; }

if ($_SERVER['REQUEST_URI']=='/index.php') { header("HTTP/1.1 301 Moved Permanently"); header('Location: /'); exit; } 
$last = strlen($_SERVER['REQUEST_URI'])-1;  if (($last=='/')AND(strlen($_SERVER['REQUEST_URI'])>1)) { header("HTTP/1.1 301 Moved Permanently"); header('Location: '.substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI'])-1)); exit; }  

$close=0;
$result = $mysqli->query("SELECT * FROM `ns_config` WHERE `name`='close'");
while($obj = $result->fetch_object()){ if ($obj->param==1) { error_reporting(0); session_start(); if ((!isset($_COOKIE['goclose']))OR($_COOKIE['goclose']!=1)) { $route['default_controller'] = 'close'; $route['404_override'] = 'page404'; $close=1; } } }
if (($close==0)OR((isset($_COOKIE['goClose']))AND($_COOKIE['goClose']==1))) { 
	$i=0;
	$result1 = $mysqli->query("SELECT * FROM ns_languages WHERE visible=1 ORDER BY main DESC, number ASC");
	while($lang = $result1->fetch_object()){ $i++;
		if ($lang->url!='') { $langnow='('.$lang->url.')/'; $langnow1=$lang->url; } else { $langnow=''; $langnow1=''; }
		$routes->add($lang->url, 'Chapter::index/'.$langnow1);
		$result2 = $mysqli->query("SELECT url,parent FROM ns_chapters ORDER BY number ASC, name ASC");
		$while=0;
		while($obj = $result2->fetch_object()){ 
			$url = $obj->url;
			if ($langnow!='') {
				$routes->add($langnow.'('.$url.')', 'Chapter::index/$1/$2');
				$routes->add($langnow.'('.$url.')/(:any)', 'Chapter::index/$1/$2/$3');
			} else {
				$routes->add($url, 'Chapter::index//'.$url);
				$routes->add($url.'/(:any)', 'Chapter::index//'.$url.'/$1');
			}
			if (($while==0)AND($obj->parent==0)) { if ($_SERVER['REQUEST_URI']=='/'.$url) { header("HTTP/1.1 301 Moved Permanently"); header('Location: /'); exit; } $while++; } 
		}
		if ($langnow!='') {
			$routes->add($langnow.'account', 'Account::index/$1');
			$routes->add($langnow.'registration', 'Registration::index/$1');
			$routes->add($langnow.'search/(:any)', 'Search::index/$1/$2');
			$routes->add($langnow.'activation/(:any)', 'Registration::index/$1/activation/$2');
			$routes->add($langnow.'article/(:any)', 'Article::index/$1/$2');
			$routes->add($langnow.'note/(:any)', 'Note::index/$1/$2');
			$routes->add($langnow.'note/(:any)/(:any)', 'Note::index/$1/$2/$3');
		} else {
			$routes->add('account', 'Account::index');
			$routes->add('registration', 'Registration::index');
			$routes->add('search/(:any)', 'Search::index//$1');
			$routes->add('activation/(:any)', 'Registration::index//activation/$1');
			$routes->add('article/(:any)', 'Article::index//$1/$2');
			$routes->add('note/(:any)', 'Note::index//$1');
			$routes->add('note/(:any)/(:any)', 'Note::index//$1/$2');
		}
	}
	if ($i==0) { 
		if (file_exists('init.html')) { header('Location: /init.html'); exit; } 
	}
	
	$routes->add('/', 'Chapter::index');
	
} else {
	
	$routes->add('/', 'Close::index');
	
}

$routes->set404Override('App\Controllers\Page404::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
