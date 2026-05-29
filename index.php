<?php include 'conexion.php'; ?>
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
        <input type="hidden" name="accion" value="crear">
        <div class="col-md-3">
            <input type="text" name="titulo" class="form-control" placeholder="Título del evento" required>
        </div>
        <div class="col-md-4">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
        </div>
        <div class="col-md-3">
            <input type="date" name="fecha_evento" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Guardar</button>
        </div>
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