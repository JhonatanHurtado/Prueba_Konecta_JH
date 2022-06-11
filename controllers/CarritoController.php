<?php
require_once 'models/producto.php';

class carritoController{
	
	public function index(){
		if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1){
			$carrito = $_SESSION['carrito'];
			
			for ($i=0; $i < count($carrito) ; $i++) {
				$producto = new Producto();
				$producto->setId($carrito[$i]['producto']->id);
				$imagen = $producto->Imagen();
				$nueva_imagen = $imagen->fetch_object()->imagen;
				$_SESSION['carrito'][$i]['producto']->imagen = $nueva_imagen;
			}
		}else{
			$carrito = array();
		}

		require_once 'views/carrito/index.php';
	}
	
	public function add(){
		if(isset($_GET['id'])){
			$producto_id = $_GET['id'];
		}else{
			header('Location:'.base_url);
		}
		
		if(isset($_SESSION['carrito'])){
			$counter = 0;
			foreach($_SESSION['carrito'] as $indice => $elemento){
				if($elemento['id_producto'] == $producto_id){
					$_SESSION['carrito'][$indice]['unidades']++;
					$counter++;
				}
			}	
		}
		
		if(!isset($counter) || $counter == 0){
			
			$producto = new Producto();
			$producto->setId($producto_id);
			$producto = $producto->getOne();

			if(is_object($producto)){
				$_SESSION['carrito'][] = array(
					"id_producto" => $producto->id,
					"precio" => $producto->precio,
					"unidades" => 1,
					"producto" => $producto
				);
			}
		}
		
		header("Location:".base_url."carrito/index");
	}
	
	public function delete(){
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			$id = $_GET['id'];
			$stock = $_GET['stock'];
			
			unset($_SESSION['carrito'][$index]);
			$this->updateStock($id, $stock);
		}
		header("Location:".base_url."carrito/index");
	}
	
	public function up(){
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			$id = $_GET['id'];
			$stock = $_GET['stock'];
			
			if ($_SESSION['carrito'][$index]['unidades'] != $stock ) {
				$_SESSION['carrito'][$index]['unidades']++;
				$update_stock = $stock - $_SESSION['carrito'][$index]['unidades'];

				$this->updateStock($id, $update_stock);
			}
		}
		header("Location:".base_url."carrito/index");
	}
	
	public function down(){
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			$id = $_GET['id'];
			$stock_t = $_GET['stock'];
			
			$_SESSION['carrito'][$index]['unidades']--;

			$producto = new Producto();
			$producto->setId($id);
			$stock = $producto->Stock();
			$stock_actual = $stock->fetch_object()->stock;
			
			if($_SESSION['carrito'][$index]['unidades'] == 0){
				unset($_SESSION['carrito'][$index]);
				$this->updateStock($id, $stock_t);
				
			}
			
			if ($stock_t != $stock_actual) {
				$update_stock = $stock_actual+1;
				$this->updateStock($id, $update_stock);
			}
		}
		header("Location:".base_url."carrito/index");
	}

	public function updateStock($id, $update_stock){
		$producto = new Producto();
		$producto->setId($id);
		$producto->setStock($update_stock);
		$producto = $producto->updateStock();
	}
	
}