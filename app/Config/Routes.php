<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // View Routes

$routes->get('/administrator/register', 'Home::administrator');

$routes->get('/', 'Home::index');
$routes->get('/register', 'Home::register');
$routes->get('/login', 'Home::login');

$routes->get('/supplier', 'SupplierController::index');
$routes->get('/supplier/list', 'SupplierController::list');
$routes->get('/supplier/detail', 'SupplierController::detail');
$routes->get('/supplier/edit', 'SupplierController::edit');
$routes->get('/supplier/data-penunjang', 'SupplierController::dataPenunjang');

$routes->get('/manajer', 'ManajerController::index');
$routes->get('/manajer/register', 'ManajerController::register');

$routes->get('/news', 'NewsController::index');
$routes->get('/news/add', 'NewsController::add');
$routes->get('/news/edit', 'NewsController::edit');

service('auth')->routes($routes);

// API Routes
$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {

  // Get
  $routes->get("invalid-access", "AuthController::accessDenied");
  // Post
  $routes->post("register", "AuthController::register");
  // Post
  $routes->post("login", "AuthController::login");
  // Get
  $routes->get("logout", "AuthController::logout", ["filter" => "auth"]);


  $routes->group("administrator", ["namespace" => "App\Controllers\Api"], function($routes) {
    // Post
    $routes->post("register", "AdministratorController::register");
  });

  
  $routes->group("manajer", ["namespace" => "App\Controllers\Api"], function($routes) {
    // Post
    $routes->post("register", "ManajerController::register", ["filter" => "auth"]);
    // Get
    $routes->get("list", "ManajerController::list", ["filter" => "auth"]);
    // Delete
    $routes->delete("delete/(:num)", "ManajerController::deleteManager/$1", ["filter" => "auth"]);
  });

  
  $routes->group("supplier", ["namespace" => "App\Controllers\Api"], function($routes) {
    // Get
    $routes->get("profile", "SupplierController::profile", ["filter" => "auth"]);
    // Get
    $routes->get("list", "SupplierController::list", ["filter" => "auth"]);
    // Get
    $routes->get("single/(:num)", "SupplierController::single/$1", ["filter" => "auth"]);
    // Put
    $routes->put("accept/(:num)", "SupplierController::accept/$1", ["filter" => "auth"]);
    // Put
    $routes->put("update", "SupplierController::updateData", ["filter" => "auth"]);
    // Delete
    $routes->delete("delete/(:num)", "SupplierController::deleteSupplier/$1", ["filter" => "auth"]);
  });


  $routes->group("news", ["namespace" => "App\Controllers\Api"], function($routes) {
    // Post
    $routes->post("add", "NewsController::addNews", ["filter" => "auth"]);
    // Get
    $routes->get("list", "NewsController::listNews");
    // Get
    $routes->get("single/(:num)", "NewsController::singleNews/$1", ["filter" => "auth"]);
    // Put
    $routes->put("update/(:num)", "NewsController::updateNews/$1", ["filter" => "auth"]);
    // Delete
    $routes->delete("delete/(:num)", "NewsController::deleteNews/$1", ["filter" => "auth"]);
  });
});