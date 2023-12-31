<?php

require_once "./models/page_model.php";
require_once "./models/user_model.php";
require_once "./models/shop_model.php";
require_once "./models/ajax_model.php";
require_once "./util.php";

class PageController {

    private $model;
    private ModelFactory $modelFactory;

    public function __construct($modelFactory) {
        $this->modelFactory = $modelFactory;
        $this->model = $this->modelFactory->createModel("page");
    }

    public function handleRequest() {
        $this->model->getRequest();
        switch($this->model->request) {
            case "page":
                $this->model->getRequestedPage();
                $this->processRequest();
                $this->showResponse();
                break;
            case "ajax":
                require_once "ajax_controller.php";
                $this->model = $this->modelFactory->createModel("ajax");
                $ajaxController = new AjaxController($this->model);
                $ajaxController->handleAction();
                break;                
        }
    }

    //business flow code
    private function processRequest() {
        
        switch($this->model->page) {
            case "contact":
                $this->model = $this->modelFactory->createModel("user");
                $this->model->validateContact();
                break;
            case "login":
                $this->model = $this->modelFactory->createModel("user");
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage("home");
                }
                break;
            case "logout":
                $this->model = $this->modelFactory->createModel("user");
                $this->model->doLogoutUser();
                $this->model->setPage("home");
                break;
            case "register":
                $this->model = $this->modelFactory->createModel("user");
                $this->model->validateRegister();
                if ($this->model->valid) {
                    $this->model->doRegisterNewAccount();
                    $this->model->setPage("login");
                }
                break;
            case "webshop":
                $this->model = $this->modelFactory->createModel("shop");
                $this->model->getWebshopProducts();
                $this->model->handleActions();
                break;
            case "details":
                $this->model = $this->modelFactory->createModel("shop");
                $this->model->getWebshopProductDetails();
                $this->model->handleActions();
                break;
            case "cart":
                $this->model = $this->modelFactory->createModel("shop");
                $this->model->getCartLines();
                $this->model->handleActions();
                break;
            case "orders":
                $this->model = $this->modelFactory->createModel("shop");
                if (is_numeric(Util::getUrlVar('orderId'))){
                    $this->model->getRowsByOrderId();
                    $this->model->getOrderAndSum();
                } else {
                    $this->model->getOrdersAndSum();
                }
                break;
        }
    }

    //to client
    private function showResponse() {
        $this->model->createMenu();

        switch($this->model->page) {
            case "home":
                require_once "./views/home_doc.php";
                $view = new HomeDoc($this->model);
                break;
            case "about":
                require_once "./views/about_doc.php";
                $view = new AboutDoc($this->model);
                break;
            case "contact":
                require_once "./views/contact_doc.php";
                $view = new ContactDoc($this->model);
                break;
            case "login":
                require_once "./views/login_doc.php";
                $view = new LoginDoc($this->model);
                break;
            case "register":
                require_once "./views/register_doc.php";
                $view = new RegisterDoc($this->model);
                break;
            case "webshop":
                require_once "./views/webshop_doc.php";
                $view = new WebshopDoc($this->model);
                break;
            case "details":
                require_once "./views/details_doc.php";
                $view = new DetailsDoc($this->model);
                break;
            case "cart":
                require_once "./views/cart_doc.php";
                $view = new CartDoc($this->model);
                break;
            case "orders":
                require_once "./views/orders_doc.php";
                $view = new OrdersDoc($this->model);
                break;
        }
        $view->show();
    }
}
?>