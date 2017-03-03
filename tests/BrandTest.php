<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Brand.php';
require_once 'src/Store.php';

$server = 'mysql:host=localhost:8889;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class BrandTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Brand::deleteAll();
        Store::deleteAll();
    }

    function test_save()
    {
        //Arrange
        $name = 'Nike';
        $test_Brand = new Brand($name);

        //Act
        $test_Brand->save();
        $result = Brand::getAll();

        //Arrange
        $this->assertEquals([$test_Brand], $result);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'Nike';
        $test_Brand1 = new Brand($name1);
        $test_Brand1->save();

        $name2 = 'Adidas';
        $test_Brand2 = new Brand($name2);
        $test_Brand2->save();

        //Act
        $result = Brand::getAll();

        //Arrange
        $this->assertEquals([$test_Brand1, $test_Brand2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'Nike';
        $test_Brand1 = new Brand($name1);
        $test_Brand1->save();

        $name2 = 'Adidas';
        $test_Brand2 = new Brand($name2);
        $test_Brand2->save();

        //Act
        Brand::deleteAll();
        $result = Brand::getAll();

        //Arrange
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name1 = 'Nike';
        $test_Brand1 = new Brand($name1);
        $test_Brand1->save();
        $search_id = $test_Brand1->getId();

        $name2 = 'Adidas';
        $test_Brand2 = new Brand($name2);
        $test_Brand2->save();

        //Act
        $result = Brand::find($search_id);

        //Arrange
        $this->assertEquals($test_Brand1, $result);
    }

    function test_addStore()
    {
        //Arrange
        $brand_name = 'Nike';
        $test_Brand = new Brand($brand_name);
        $test_Brand->save();

        $store_name = 'DSW';
        $test_Store = new Store($store_name);
        $test_Store->save();

        //Act
        $test_Brand->addStore($test_Store);
        $result = $test_Brand->getStores();

        //Assert
        $this->assertEquals([$test_Store], $result);
    }

    function test_getStores()
    {
        //Arrange
        $brand_name = 'Nike';
        $test_Brand = new Brand($brand_name);
        $test_Brand->save();

        $store_name1 = 'DSW';
        $test_Store1 = new Store($store_name1);
        $test_Store1->save();

        $store_name2 = 'Payless';
        $test_Store2 = new Store($store_name2);
        $test_Store2->save();

        //Act
        $test_Brand->addStore($test_Store1);
        $test_Brand->addStore($test_Store2);
        $result = $test_Brand->getStores();

        //Assert
        $this->assertEquals([$test_Store1, $test_Store2], $result);
    }
}
?>
