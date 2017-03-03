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

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
    }

    function addBrand($brand)
    {
        $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
    }

    function getBrands()
    {
        $brands = [];

        $query = $GLOBALS['DB']->query(
            "SELECT brands.* FROM" .
            " stores" .
            " JOIN brands_stores ON (stores.id = brands_stores.store_id)" .
            " JOIN brands ON (brands_stores.brand_id = brands.id)" .
            " WHERE stores.id = {$this->getId()};"
        );
        foreach($query as $brand) {
            $id = $brand['id'];
            $name = $brand['name'];
            array_push($brands, new Brand($name, $id));
        }

        return $brands;
    }

    static function getAll()
    {
        $query = $GLOBALS['DB']->query("SELECT * FROM stores;");
        return $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Store', [ 'name', 'id' ]);
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM stores;");
        $GLOBALS['DB']->exec("DELETE FROM brands_stores;");
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
