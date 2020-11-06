<?php
    require_once './View/VistaItems.php';
    require_once './Model/ModelItems.php';
    require_once './Model/ModelMarca.php';

    class ControllerItems{
        private $vista;
        private $model;
        private $modelM;

        function __construct(){
             $this->vista = new VistaItems();
             $this->model = new ModelItems();
             $this->modelM = new ModelMarcas();
        }

        function ShowItems(){
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            session_start();
            if(!isset($_SESSION["email"])){
                $this->vista->ShowItems($items);
            }else{
                $this->vista->ShowItemsLogged($items, $marcas);
            }
        }
        function Insert(){
            $this->model->InsertItems($_POST['modelo_input'],$_POST['talle_input'],$_POST['precio_input'], $_POST['stock_input'], $_POST['marca_input']);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
        function Borrar($params = null){
            $id_zapatilla = $params[':ID'];
            $this->model->BorrarItem($id_zapatilla);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
        function DetalleProducto($params = null){
            $id_zapatilla = $params[':ID'];
            $item = $this->model->GetInfo($id_zapatilla);
            $this->vista->DetalleProduct($item);
        }
        function ShowEditForm($params = null){
            $id_item = $params[":ID"];
            $item = $this->model->GetItem($id_item);
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowFormEdit($item, $marcas);
        }
        function Edit($params = null){
            $modelo = $_POST["modelo_input"];
            $talle = $_POST["talle_input"];
            $precio = $_POST["precio_input"];
            $stock = $_POST["stock_input"];
            $marca = $_POST["marca_input"];
            $id_item = $params[":ID"];
            $this->model->EditItem($modelo, $talle, $precio, $stock, $marca, $id_item);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
        function Comentar($params = null){
            $id_item = $params[":ID"];
            $item = $this->model->GetItem($id_item);
            $this->vista->ShowFormComent($item);
        }
        function Notar($params = null){
            $id_item = $params[":ID"];
            $item = $this->model->GetItem($id_item);
            $this->vista->ShowFormNote($item);
        }
    }
?>