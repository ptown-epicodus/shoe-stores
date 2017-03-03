<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Store.php';
require_once 'src/Brand.php';

$server = 'mysql:host=localhost:8889;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StoreTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Store::deleteAll();
        Brand::deleteAll();
    }

    function test_save()
    {
        //Arrange
        $name = 'DSW';
        $test_Store = new Store($name);

        //Act
        $test_Store->save();
        $result = Store::getAll();

        //Assert
        $this->assertEquals([$test_Store], $result);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'DSW';
        $test_Store1 = new Store($name1);
        $test_Store1->save();

        $name2 = 'Payless';
        $test_Store2 = new Store($name2);
        $test_Store2->save();

        //Act
        $result = Store::getAll();

        //Assert
        $this->assertEquals([$test_Store1, $test_Store2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'DSW';
        $test_Store1 = new Store($name1);
        $test_Store1->save();

        $name2 = 'Payless';
        $test_Store2 = new Store($name2);
        $test_Store2->save();

        //Act
        Store::deleteAll();
        $result = Store::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name1 = 'DSW';
        $test_Store1 = new Store($name1);
        $test_Store1->save();
        $search_id = $test_Store1->getId();

        $name2 = 'Payless';
        $test_Store2 = new Store($name2);
        $test_Store2->save();

        //Act
        $result = Store::find($search_id);

        //Assert
        $this->assertEquals($test_Store1, $result);
    }

    function test_update()
    {
        //Arrange
        $name = 'DSW';
        $new_name = 'Payless';
        $test_Store = new Store($name);
        $test_Store->save();

        //Act
        $test_Store->update($new_name);
        $result = $test_Store->getName();

        //Assert
        $this->assertEquals('Payless', $result);
    }

    function test_delete()
    {
        //Arrange
        $name1 = 'DSW';
        $test_Store1 = new Store($name1);
        $test_Store1->save();

        $name2 = 'Payless';
        $test_Store2 = new Store($name2);
        $test_Store2->save();

        //Act
        $test_Store1->delete();
        $result = Store::getAll();

        //Assert
        $this->assertEquals([$test_Store2], $result);
    }

    function test_addBrand()
    {
        //Arrange
        $store_name = 'DSW';
        $test_Store = new Store($store_name);
        $test_Store->save();

        $brand_name = 'Nike';
        $test_Brand = new Brand($brand_name);
        $test_Brand->save();

        //Act
        $test_Store->addBrand($test_Brand);
        $result = $test_Store->getBrands();

        //Assert
        $this->assertEquals([$test_Brand], $result);
    }

    function test_getBrands()
    {
        //Arrange
        $store_name = 'DSW';
        $test_Store = new Store($store_name);
        $test_Store->save();

        $brand_name1 = 'Nike';
        $test_Brand1 = new Brand($brand_name1);
        $test_Brand1->save();

        $brand_name2 = 'Adidas';
        $test_Brand2 = new Brand($brand_name2);
        $test_Brand2->save();

        //Act
        $test_Store->addBrand($test_Brand1);
        $test_Store->addBrand($test_Brand2);
        $result = $test_Store->getBrands();

        //Assert
        $this->assertEquals([$test_Brand1, $test_Brand2], $result);
    }
}
?>
