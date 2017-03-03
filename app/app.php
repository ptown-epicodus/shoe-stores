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

// Routes for Store
$app->get('/stores', function() use ($app) {
    return $app['twig']->render('stores.html.twig', [
        'all_stores' => Store::getAll()
    ]);
});

$app->get('/stores/{id}', function($id) use ($app) {
    $store = Store::find($id);
    $carried_brands = $store->getBrands();
    $unavailable_brands = array_udiff(Brand::getAll(), $carried_brands, function($a, $b) {
        return $a->getId() - $b->getId();
    });
    return $app['twig']->render('store.html.twig', [
        'store' => $store,
        'carried_brands' => $carried_brands,
        'unavailable_brands' => $unavailable_brands
    ]);
});

$app->post('/add_store', function() use ($app) {
    $store_name = $_POST['store-name'];
    $new_store = new Store($store_name);
    $new_store->save();
    return $app->redirect('/stores');
});

$app->post('stores/{id}/brands', function($id) use ($app) {
    $store = Store::find($id);
    $brand = Brand::find($_POST['brand-id']);
    $store->addBrand($brand);
    return $app->redirect("/stores/{$id}");
});

// Routes for Brand
$app->get('/brands', function() use ($app) {
    return $app['twig']->render('brands.html.twig', [
        'all_brands' => Brand::getAll()
    ]);
});

$app->post('/add_brand', function() use ($app) {
    $brand_name = $_POST['brand-name'];
    $new_brand = new Brand($brand_name);
    $new_brand->save();
    return $app->redirect('/brands');
});

return $app;
?>
