<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];

    // Lógica CREATE
    if ($accion == 'crear') {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha_evento'];

        $sql = "INSERT INTO eventos (titulo, descripcion, fecha_evento) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $descripcion, $fecha]);
    }
    
    // Lógica DELETE
    if ($accion == 'eliminar') {
        $id = $_POST['id'];
        $sql = "DELETE FROM eventos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    //Lógica UPDATE
    if($accion == 'actualizar') {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha_evento'];

        $sql = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha_evento = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $descripcion, $fecha, $id]);
    }

    // Redirigir de vuelta al index
    header("Location: index.php");
    exit();
}
?>