<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Brand.php';

$server = 'mysql:host=localhost:8889;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class BrandTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Brand::deleteAll();
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
}
?>
