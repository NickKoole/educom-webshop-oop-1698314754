<?php
class AjaxDoc {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function response() {
        $json = json_encode($this->model->data);
        echo $json;
    }
}
?>