<?php
include 'conexion.php';

// 1. Para verificar si el usuario presionó editar.
$evento_editar = null;
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $stmt_edit = $pdo->prepare("SELECT * FROM eventos WHERE id = ?");
    $stmt_edit->execute([$id_editar]);
    $evento_editar = $stmt_edit->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Mi Calendario de Eventos</h2>
    
    <form action="procesar.php" method="POST" class="mb-4 row g-3">
        <input type="hidden" name="accion" value="<?= $evento_editar ? 'actualizar' : 'crear' ?>">
        
        <?php if ($evento_editar): ?>
            <input type="hidden" name="id" value="<?= $evento_editar['id'] ?>">
        <?php endif; ?>

        <div class="col-md-3">
            <input type="text" name="titulo" class="form-control" placeholder="Título del evento" required
                   value="<?= $evento_editar ? $evento_editar['titulo'] : '' ?>">
        </div>
        <div class="col-md-4">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción"
                   value="<?= $evento_editar ? $evento_editar['descripcion'] : '' ?>">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_evento" class="form-control" required
                   value="<?= $evento_editar ? $evento_editar['fecha_evento'] : '' ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn <?= $evento_editar ? 'btn-success' : 'btn-primary' ?> w-100">
                <?= $evento_editar ? 'Actualizar' : 'Guardar' ?>
            </button>
        </div>
        
        <?php if ($evento_editar): ?>
            <div class="col-12 mt-2">
                <a href="index.php" class="btn btn-secondary btn-sm">Cancelar edición</a>
            </div>
        <?php endif; ?>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM eventos ORDER BY fecha_evento ASC");
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$fila['fecha_evento']}</td>
                        <td>{$fila['titulo']}</td>
                        <td>{$fila['descripcion']}</td>
                        <td>
                            <a href='index.php?editar={$fila['id']}' class='btn btn-warning btn-sm'>Editar</a>

                            <form action='procesar.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='accion' value='eliminar'>
                                <input type='hidden' name='id' value='{$fila['id']}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>