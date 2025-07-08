<?php
require_once '../app/controllers/TareasController.php';

$controller = new TareasController();

$accion = $_GET['accion'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($accion) {
    case 'crear':
        $controller->crear();
        break;

    case 'editar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->actualizar();
        } else {
            $controller->editar($id);
        }
        break;

    case 'completar':
        if ($id !== null) {
            $controller->completar($id);
        }
        break;

    case 'eliminarLogico':
        if ($id !== null) {
            $controller->eliminarLogico($id);
        }
        break;

    case 'eliminar':
        if ($id !== null) {
            $controller->eliminar($id);
        }
        break;

    case 'tareasCompletadas':
        $controller->listarTareasPorEstado(1);
        break;

    case 'tareasPendientes':
        $controller->listarTareasPorEstado(0);
        break;

    case 'historialTareas':
        $controller->listarTareasTodas();
        break;

    case 'buscar':
        $controller->buscar();
        break;

    case 'ordenar':
        $controller->ordenar();
        break;

    default:
        $controller->listarTareas();
        break;
}
?>
