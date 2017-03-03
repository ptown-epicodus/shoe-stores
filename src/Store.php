<?php
class Store
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
        $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $query = $GLOBALS['DB']->query("SELECT * FROM stores;");
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Store', [ 'name', 'id']);
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM stores;");
    }

    static function find($search_id)
    {
        $found_store = null;

        $query = $GLOBALS['DB']->query("SELECT * FROM stores;");
        $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Store', [ 'name', 'id']);
        $found_store = $query->fetch();

        return $found_store;
    }
}
?>
