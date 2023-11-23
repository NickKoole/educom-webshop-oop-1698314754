<?php
class RatingCrud {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function getRatingByProductId($productId) {
        $sql = "SELECT AVG(R.rating) AS rating
                FROM ratings AS R
                INNER JOIN products AS P ON P.product_id = R.product_id
                WHERE R.product_id = :productId";
        $values = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $values);
    }

    public function getRatingForAllProducts() {
        $sql = "SELECT DISTINCT R.product_id AS productId, AVG(R.rating) AS rating
                FROM ratings AS R
                GROUP BY R.product_id";

        return $this->crud->readMultipleRows($sql);
    }

    public function updateRatingByProductIdForUserId($userId, $productId, $rating) {
        $sql = "UPDATE ratings 
                SET rating = :rating
                WHERE product_id = :productId AND user_id = :userId";
        $values = array("userId" => $userId, "productId" => $productId, "rating" => $rating);

        $this->crud->updateRow($sql, $values);
    }

    public function writeRatingByproductIdForUserId($userId, $productId, $rating) {
        $sql = "INSERT INTO ratings (product_id, user_id, rating)
                VALUES (:productId, :userId, :rating)";
        $values = array("userId" => $userId, "productId" => $productId, "rating" => $rating);

        $this->crud->createRow($sql, $values);
    }

    //De volgende functies staan ook in de ShopCrud, maar kreeg een foutmelding nu deze nog geen crud heeft
    //bij een ajax request
    public function doesProductExist($productId) {
        return !empty($this->readProduct($productId));
    }

    public function readProduct($productId) {
        $sql = "SELECT * FROM products WHERE product_id = :productId";
        $productId = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $productId);
    }
}
?>