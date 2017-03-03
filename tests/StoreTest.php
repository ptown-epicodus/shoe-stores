<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Store.php';

$server = 'mysql:host=localhost:8889;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class StoreTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Store::deleteAll();
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
}
?>
