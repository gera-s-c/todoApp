<?php
class Tarea {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerTodas() {
        // Lógica para obtener todas las tareas
    }

    public function obtenerPorId($id) {
        // Lógica para obtener una tarea por su ID
    }

    public function crear($datos) {
        // Lógica para crear una nueva tarea
    }

    public function actualizar($id, $datos) {
        // Lógica para actualizar una tarea existente
    }

    public function eliminar($id) {
        // Lógica para eliminar una tarea
    }
}
?>
