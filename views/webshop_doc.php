<?php

require_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Webshop</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Ons assortiment</h2>';
        echo '<br>';
        $this->showWebshopProducts();
    }
    
    private function showWebshopProducts() {
        //$amountOfProducts = count($this->model->products);

        echo '<span>' . $this->model->errProductId . '</span>';
        echo '<span>' . $this->model->errQuantity . '</span>';

        //Geeft per product het product_id, name, description, price en product_picture_location weer
        foreach ($this->model->products as $key => $value){
            echo '<a class="productlink" href="index.php?page=details&productId=' . $this->model->products[$key]->product_id . '"><div>' .
            'Product id: ' . $this->model->products[$key]->product_id . '<br>' .
            'Artikel: ' . $this->model->products[$key]->name . '<br>' .
            'Beschrijving: ' . $this->model->products[$key]->description . '<br>' .
            'Prijs: €' . $this->model->products[$key]->price . '<br>' .
            '<img src="Images/' . $this->model->products[$key]->product_picture_location . '" alt="' . $this->model->products[$key]->product_picture_location . '">' .
            '</div></a>';

            $this->showAddToCartAction($this->model->products[$key]->product_id, 'webshop', 'Voeg toe aan winkelwagen');
        }      
    }
}
?>