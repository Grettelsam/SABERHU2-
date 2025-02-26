<?php
include 'conexion.php';

$registro_exitoso = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $fecha = $_POST['fecha'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];

    $sql = "INSERT INTO horario (usuario, fecha, hora_entrada, hora_salida) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario, $fecha, $hora_entrada, $hora_salida]);

    // Si la inserción fue exitosa
    if ($stmt->rowCount() > 0) {
        $registro_exitoso = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Horarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-primary d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm p-4">
                    <h2 class="text-center">Registra tu asistencia!!</h2>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" name="usuario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_entrada" class="form-label">Hora de Entrada</label>
                            <input type="time" name="hora_entrada" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_salida" class="form-label">Hora de Salida</label>
                            <input type="time" name="hora_salida" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        <div class="text-center mt-3">
                            <a href="index.html" class="d-block mt-3 btn btn-danger">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.min.js"></script>
    
    <script>
        <?php if ($registro_exitoso): ?>
            Swal.fire({
                title: '¡Asistencia registrada!',
                text: 'Tu asistencia ha sido registrada correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(function() {
                window.location.href = 'index.html';
            });
        <?php endif; ?>
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
