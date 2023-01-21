<?php

include_once __DIR__ . '/../models/Product.php';

class ProductsDao
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $result = $this->db->prepare('SELECT * FROM products');
        $result->execute();
        $products = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push(
                $products,
                new ProductModel($id, $name, $price, $description)

                // array( 'id' => $id, 'name' => $name, 'price' => $price, 'description' => $description)
            );
        }
        return $products;
    }

    public function getById($id)
    {

        $stmt = $this->db->prepare('SELECT  * FROM products WHERE id = ?');
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $description = $row['description'];

            return new ProductModel($id, $name, $price, $description);
        }
        return NULL;
    }

    public function create($newProduct)
    {
        $stmt = $this->db->prepare('INSERT INTO products SET name = :name, price = :price, description = :description');

        $stmt->bindParam(':name', $newProduct->name);
        $stmt->bindParam(':price', $newProduct->price);
        $stmt->bindParam(':description', $newProduct->description);

        if($stmt->execute()) {
            return TRUE;
        }
        return FALSE;
    }


    public function update($newProduct)
    {
        $stmt = $this->db->prepare('UPDATE products SET name = :name, price = :price, description = :description WHERE id = :id');
        $stmt->bindParam(':name', $newProduct->name);
        $stmt->bindParam(':price', $newProduct->price);
        $stmt->bindParam(':description', $newProduct->description);
        $stmt->bindParam(':id', $newProduct->id);

        if($stmt->execute()) {
            return TRUE;
        }

        return FALSE;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return TRUE;
        }

        return FALSE;
    }
}
