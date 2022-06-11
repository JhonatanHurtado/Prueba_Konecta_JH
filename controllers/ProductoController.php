<?php
require_once 'models/producto.php';

class productoController
{

	public function index()
	{
		$producto = new Producto();
		$productos = $producto->getRandom(6);

		require_once 'views/producto/destacados.php';
	}

	public function ver()
	{
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$producto = new Producto();
			$producto->setId($id);
			$stock = $producto->Stock();
			$stock_actual = $stock->fetch_object()->stock;
			$product = $producto->getOne();
		}
		require_once 'views/producto/ver.php';
	}

	public function gestion()
	{

		$producto = new Producto();
		$productos = $producto->getAll();

		require_once 'views/producto/gestion.php';
	}

	public function crear()
	{

		require_once 'views/producto/crear.php';
	}

	public function save()
	{

		if (isset($_POST)) {
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
			$precio = isset($_POST['precio']) ? $_POST['precio'] : false;
			$peso = isset($_POST['peso']) ? $_POST['peso'] : false;
			$stock = isset($_POST['stock']) ? $_POST['stock'] : false;
			$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
			// $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;

			if ($nombre && $descripcion && $precio && $stock && $categoria) {
				$producto = new Producto();
				$producto->setNombre($nombre);
				$producto->setDescripcion($descripcion);
				$producto->setPrecio($precio);
				$producto->setPeso($peso);
				$producto->setStock($stock);
				$producto->setCategoria_id($categoria);

				// Guardar la imagen
				if (isset($_FILES['imagen'])) {
					$file = $_FILES['imagen'];
					$filename = $file['name'];
					$mimetype = $file['type'];

					if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

						if (!is_dir('uploads/images')) {
							mkdir('uploads/images', 0777, true);
						}

						$producto->setImagen($filename);
						move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
					}
				}

				if (isset($_GET['id'])) {
					$id = $_GET['id'];
					$producto->setId($id);

					$save = $producto->edit();
				} else {
					$save = $producto->save();
				}

				if ($save) {
					$_SESSION['producto'] = "complete";
				} else {
					$_SESSION['producto'] = "failed";
				}
			} else {
				$_SESSION['producto'] = "failed";
			}
		} else {
			$_SESSION['producto'] = "failed";
		}
		header('Location:' . base_url . 'producto/gestion');
	}

	public function editar()
	{

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$edit = true;

			$producto = new Producto();
			$producto->setId($id);

			$pro = $producto->getOne();

			require_once 'views/producto/crear.php';
		} else {
			header('Location:' . base_url . 'producto/gestion');
		}
	}

	public function eliminar()
	{
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$producto = new Producto();
			$producto->setId($id);
			
			// var_dump($_SESSION['carrito']);
			// die();
			for ($i=0; $i < count($_SESSION['carrito']); $i++) { 
				if ($_SESSION['carrito'][$i]['producto']->id == $id) {
					unset($_SESSION['carrito'][$i]);
					// print_r($_SESSION['carrito'][$i]['producto']->id);
				}
			}
			// die();
			
			$delete = $producto->delete();
			if ($delete) {
				$_SESSION['delete'] = 'complete';
			} else {
				$_SESSION['delete'] = 'failed';
			}
		} else {
			$_SESSION['delete'] = 'failed';
		}

		header('Location:' . base_url . 'producto/gestion');
	}
}