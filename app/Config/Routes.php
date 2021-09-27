<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::Index');
$routes->get('eventlist', 'Home::EventList');
$routes->group('admin', function($routes) {
	$routes->get('/', 'admin\Profile::Index');
	$routes->match(['get', 'post'], 'login', 'admin\Profile::Login');
	$routes->get('signout', 'admin\Profile::Signout');
	$routes->get('dashboard', 'admin\Profile::Dashboard');
	$routes->get('event', 'admin\Events::Datalist');
	$routes->post('event/add', 'admin\Events::Addnew');
	$routes->get('event/add/form', 'admin\Events::Addform');
	$routes->post('event/update/(:any)', 'admin\Events::Update/$1');
	$routes->get('event/edit/(:any)/form', 'admin\Events::Editform/$1');
	$routes->delete('event/delete/(:any)', 'admin\Events::Delete/$1');
	$routes->post('event/privacy/(:any)', 'admin\Events::Privacy/$1');
	$routes->post('event/status/(:any)', 'admin\Events::Status/$1');
});

$routes->group('user', function($routes) {
	$routes->get('/', 'user\Profile::Index');
	$routes->match(['get', 'post'], 'login', 'user\Profile::Login');
	$routes->get('signout', 'user\Profile::Signout');
	$routes->get('dashboard', 'user\Profile::Dashboard');
	$routes->get('event', 'user\Events::Datalist');
	$routes->post('event/add', 'user\Events::Addnew');
	$routes->get('event/add/form', 'user\Events::Addform');
	$routes->post('event/update/(:any)', 'user\Events::Update/$1');
	$routes->get('event/edit/(:any)/form', 'user\Events::Editform/$1');
	$routes->delete('event/delete/(:any)', 'user\Events::Delete/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
