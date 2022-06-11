<?php
require_once 'models/pedido.php';

class pedidoController{
	
	public function hacer(){
		
		require_once 'views/pedido/hacer.php';
	}
	
	public function add(){
		$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : false;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : false;
		$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
		
		$stats = Utils::statsCarrito();
		$coste = $stats['total'];
			
		if($departamento && $ciudad && $direccion){
			
			$pedido = new Pedido();
			$pedido->setDepartamento($departamento);
			$pedido->setCiudad($ciudad);
			$pedido->setDireccion($direccion);
			$pedido->setCoste($coste);
			
			$save = $pedido->save();

			$save_linea = $pedido->save_linea();
			
			if($save && $save_linea){
				unset($_SESSION['carrito']);
				$_SESSION['pedido'] = "complete";
			}else{
				$_SESSION['pedido'] = "failed";
			}
			
		}else{
			$_SESSION['pedido'] = "failed";
		}
		
		header("Location:".base_url.'pedido/confirmado');			
	}
	
	public function confirmado(){
			$pedido = new Pedido();
			
			$pedido = $pedido->getOneByUser();
			
			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($pedido->id);
		require_once 'views/pedido/confirmado.php';
	}
	
	public function detalle(){
		
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			
			$venta = new Pedido();
			$venta->setId($id);
			$venta = $venta->getOne();
			
			$venta_productos = new Pedido();
			$productos = $venta_productos->getProductosByPedido($id);
			
			require_once 'views/pedido/detalle.php';
		}else{
			header('Location:'.base_url.'pedido/mis_pedidos');
		}
	}
	
	public function gestion(){
		
		$gestion = true;
		
		$pedido = new Pedido();
		$pedidos = $pedido->getAll();
		
		require_once 'views/pedido/mis_pedidos.php';
	}
	
}