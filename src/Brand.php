<?php
class Brand
{
    private $id;
    private $name;

    function __construct($name, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    static function getAll()
    {
        $query = $GLOBALS['DB']->query("SELECT * FROM brands;");
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Brand', [ 'name', 'id' ]);
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM brands;");
    }

    static function find($search_id)
    {
        $found_brand = null;

        $query = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$search_id};");
        $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Brand', [ 'name', 'id' ]);
        $found_brand = $query->fetch();

        return $found_brand;
    }
}
?>
