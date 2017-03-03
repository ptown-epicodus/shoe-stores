<?php
date_default_timezone_set('America/Los_Angeles');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Brand.php';
require_once __DIR__ . '/../src/Store.php';

$app = new Silex\Application();
$app['debug']=true;

$server = 'mysql:host=localhost:8889;dbname=shoes';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views/'
]);

$app->get('/', function() use ($app) {
    return $app['twig']->render('home.html.twig');
});

// CRUD for Store
$app->get('/stores', function() use ($app) {
    return $app['twig']->render('stores.html.twig', [
        'all_stores' => Store::getAll()
    ]);
});

$app->post('/add_store', function() use ($app) {
    $store_name = $_POST['store-name'];
    $new_store = new Store($store_name);
    $new_store->save();
    return $app->redirect('/stores');
});

return $app;
?>
