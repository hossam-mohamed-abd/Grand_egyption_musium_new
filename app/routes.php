<?php
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Controller.php';

$router = new Router(BASE_URL);

$router->get('/', function () {
    require VIEW_PATH . 'home.php';
});


$router->get('/profile/edit', function () {
    require VIEW_PATH . 'profile/edit.php';
});

$router->post('/profile/update', function () {
    require APP_PATH . '/Controllers/UserController.php';
    (new UserController)->updateProfile();
});

$router->get('/food', function () {
    require APP_PATH . "/Controllers/FoodController.php";
    (new FoodController)->categories();
});

$router->get('/food/items', function () {
    require APP_PATH . "/Controllers/FoodController.php";
    (new FoodController)->items();
});

$router->get('/kids-zone', function () {
    require VIEW_PATH . 'Kids-Zone/KidsZone.php';
});

$router->get('/booking', function () {
    require VIEW_PATH . 'booking/booking.php';
});


$router->get('/collections', function () {
    require APP_PATH . "/Controllers/CollectionsController.php";
    (new CollectionsController)->index();
});


$router->get('/api/collections/load-more', function () {
    require APP_PATH . "/Controllers/CollectionsController.php";
    (new CollectionsController)->loadMore();
});

$router->get('/donate', function () {
    require VIEW_PATH . 'Donate/Donate.php';
});

$router->post('/donations/store', function () {
    require APP_PATH . "/Controllers/DonationsController.php";
    (new DonationsController)->store();
});

$router->get('/login', function () {
    require VIEW_PATH . 'regestration/login/login.php';
});

$router->get('/register', function () {
    require VIEW_PATH . 'regestration/register/register.php';
});

$router->get('/logout', function () {
    session_start();
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "login");
    exit;
});


$router->get('/events', function () {
    require APP_PATH . "/Controllers/EventsController.php";
    (new EventsController)->index();
});

$router->get('/event-details', function () {
    require APP_PATH . "/Controllers/EventsController.php";
    $id = $_GET["id"] ?? null;
    (new EventsController)->show($id);
});

$router->get('/plans', function () {
    require APP_PATH . "/Controllers/PlansController.php";
    (new PlansController)->index();
});

$router->post('/booking/submit', function () {
    require APP_PATH . "/Controllers/BookingController.php";
    (new BookingController)->submit();
});



// test route // delete  ******
$router->get('/admin', function () {
    require APP_PATH . '/Controllers/AdminController.php';
    (new AdminController)->dashboard();
});

$router->post('/admin/plans/store', function () {
    require APP_PATH . '/Controllers/AdminController.php';
    (new AdminController)->storePlan();
});

$router->post('/admin/plans/delete', function () {
    require APP_PATH . '/Controllers/AdminController.php';
    (new AdminController)->deletePlan();
});

$router->post('/admin/users/update-role', function () {
    require APP_PATH . '/Controllers/AdminController.php';
    (new AdminController)->updateUserRole();
});


return $router;
