<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/login', '\CodeIgniter\Shield\Controllers\LoginController::loginView');
$routes->get('/logout', '\CodeIgniter\Shield\Controllers\LoginController::logoutAction');
$routes->get('/', 'Home::index');
$routes->add('/exception', 'ExceptionQueueController::index');
$routes->add('/documenthistory', 'DocumentHistoryController::index');
$routes->add('/archive', 'ArchiveHistoryController::index');

$routes->get('data/exceptionqueue', 'ExceptionQueueDataController::index');
$routes->post('data/exceptionqueue', 'ExceptionQueueDataController::index');
$routes->post('rest/exceptionqueue', 'ExceptionQueueDataController::create');
$routes->get('rest/exceptionqueue/(:segment)', 'ExceptionQueueDataController::show/$1');
$routes->put('rest/exceptionqueue/(:segment)', 'ExceptionQueueDataController::update/$1');
$routes->patch('rest/exceptionqueue/(:segment)', 'ExceptionQueueDataController::update/$1');
$routes->delete('rest/exceptionqueue/(:segment)', 'ExceptionQueueDataController::delete/$1');

$routes->get('data/documenthistory', 'DocumentHistoryDataController::index');
$routes->post('data/documenthistory', 'DocumentHistoryDataController::index');
$routes->post('rest/documenthistory', 'DocumentHistoryDataController::create');
$routes->get('rest/documenthistory/(:segment)', 'DocumentHistoryDataController::show/$1');
$routes->put('rest/documenthistory/(:segment)', 'DocumentHistoryDataController::update/$1');
$routes->patch('rest/documenthistory/(:segment)', 'DocumentHistoryDataController::update/$1');
$routes->delete('rest/documenthistory/(:segment)', 'DocumentHistoryDataController::delete/$1');

$routes->get('data/archivehistory', 'ArchiveHistoryDataController::index');
$routes->post('data/archivehistory', 'ArchiveHistoryDataController::index');
$routes->post('rest/archivehistory', 'ArchiveHistoryDataController::create');
$routes->get('rest/archivehistory/(:segment)', 'ArchiveHistoryDataController::show/$1');
$routes->put('rest/archivehistory/(:segment)', 'ArchiveHistoryDataController::update/$1');
$routes->patch('rest/archivehistory/(:segment)', 'ArchiveHistoryDataController::update/$1');
$routes->delete('rest/archivehistory/(:segment)', 'ArchiveHistoryDataController::delete/$1');

$routes->get('data/documenthistorydetail', 'DocumentHistoryDetailDataController::index');
$routes->post('data/documenthistorydetail', 'DocumentHistoryDetailDataController::index');
$routes->post('rest/documenthistorydetail', 'DocumentHistoryDetailDataController::create');
$routes->get('rest/documenthistorydetail/(:segment)', 'DocumentHistoryDetailDataController::show/$1');
$routes->put('rest/documenthistorydetail/(:segment)', 'DocumentHistoryDetailDataController::update/$1');
$routes->patch('rest/documenthistorydetail/(:segment)', 'DocumentHistoryDetailDataController::update/$1');
$routes->delete('rest/documenthistorydetail/(:segment)', 'DocumentHistoryDetailDataController::delete/$1');


service('auth')->routes($routes);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
