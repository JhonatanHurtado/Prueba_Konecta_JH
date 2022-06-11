<?php

class Pedido{
	private $id;
	private $usuario_id;
	private $departamento;
	private $ciudad;
	private $direccion;
	private $coste;
	private $estado;
	private $fecha;
	private $hora;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getUsuario_id() {
		return $this->usuario_id;
	}

	function getDepartamento() {
		return $this->departamento;
	}

	function getCiudad() {
		return $this->ciudad;
	}

	function getDireccion() {
		return $this->direccion;
	}

	function getCoste() {
		return $this->coste;
	}

	function getEstado() {
		return $this->estado;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getHora() {
		return $this->hora;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setUsuario_id($usuario_id) {
		$this->usuario_id = $usuario_id;
	}

	function setDepartamento($departamento) {
		$this->departamento = $this->db->real_escape_string($departamento);
	}

	function setCiudad($ciudad) {
		$this->ciudad = $this->db->real_escape_string($ciudad);
	}

	function setDireccion($direccion) {
		$this->direccion = $this->db->real_escape_string($direccion);
	}

	function setCoste($coste) {
		$this->coste = $coste;
	}

	function setEstado($estado) {
		$this->estado = $estado;
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setHora($hora) {
		$this->hora = $hora;
	}

	public function getAll(){
		$productos = $this->db->query("SELECT * FROM datos_venta ORDER BY id DESC");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM datos_venta WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	public function getOneByUser(){
		$sql = "SELECT p.id, p.coste FROM datos_venta p "
				//. "INNER JOIN ventas lp ON lp.datos_venta_id = p.id "
				. "ORDER BY id DESC LIMIT 1";
			
		$pedido = $this->db->query($sql);
			
		return $pedido->fetch_object();
	}
	
	public function getProductosByPedido($id){
	
		$sql = "SELECT pr.*, lp.unidades FROM productos pr "
				. "INNER JOIN ventas lp ON pr.id = lp.producto_id "
				. "WHERE lp.datos_venta_id={$id}";
				
		$productos = $this->db->query($sql);
			
		return $productos;
	}
	
	public function save(){
		$sql = "INSERT INTO datos_venta VALUES(NULL, '{$this->getDepartamento()}', '{$this->getCiudad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'vendido', CURDATE(), CURTIME());";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function save_linea(){
		$sql = "SELECT LAST_INSERT_ID() as 'pedido';";
		$query = $this->db->query($sql);
		$datos_venta_id = $query->fetch_object()->pedido;
		
		foreach($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];
			
			$insert = "INSERT INTO ventas VALUES(NULL, {$datos_venta_id}, {$producto->id}, {$elemento['unidades']})";
			$save = $this->db->query($insert);
			
		}
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
}