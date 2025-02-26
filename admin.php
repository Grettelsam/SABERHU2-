<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captcha = $_POST["g-recaptcha-response"];
    $secretKey = "6LdaeOMqAAAAAHt3XoBPy8R7PdDsMirD9iNgA6gp"; 
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha";

    // Validar con Google reCAPTCHA
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        echo "Error: reCAPTCHA no válido.";
        exit;
    }

    // Obtener datos del formulario
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    //Usuario y la contraseña en la base de datos
    $usuario_valido = "cchacon@gmail.com";
    $password_valida = "1234";

    if ($correo === $usuario_valido && $password === $password_valida) {
        echo "Login exitoso. ¡Bienvenido!";
   }  else {
       echo "Error: Credenciales incorrectas.";
    }
}

// Eliminar registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->query("DELETE FROM horario WHERE id = $id");
}

// Obtener registros
$stmt = $pdo->query("SELECT id, usuario, fecha, hora_entrada, hora_salida FROM horario ");
$horarios = $stmt->fetchAll();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Horarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Gestión de Horarios</a>
            <a class="btn btn-danger" href="logout.php">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Hora de Entrada</th>
                        <th>Hora de Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $horario): ?>
                    <tr>
                        <td><?= $horario['usuario'] ?></td>
                        <td><?= $horario['fecha'] ?></td>
                        <td><?= $horario['hora_entrada'] ?></td>
                        <td><?= $horario['hora_salida'] ?></td>
                        <td>
                            <!-- Botón Editar -->
                            <button class="btn btn-warning btn-sm btn-edit" 
                                data-id="<?= $horario['id'] ?>"
                                data-usuario="<?= $horario['usuario'] ?>"
                                data-fecha="<?= $horario['fecha'] ?>"
                                data-hora_entrada="<?= $horario['hora_entrada'] ?>"
                                data-hora_salida="<?= $horario['hora_salida'] ?>"
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal">
                                Editar
                            </button>

                            <!-- Botón Eliminar -->
                            <a href="?delete=<?= $horario['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="editar_horario.php">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="edit-usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="edit-fecha" name="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-hora_entrada" class="form-label">Hora de Entrada</label>
                            <input type="time" class="form-control" id="edit-hora_entrada" name="hora_entrada" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-hora_salida" class="form-label">Hora de Salida</label>
                            <input type="time" class="form-control" id="edit-hora_salida" name="hora_salida" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Cuando se haga clic en el botón de edición
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", function () {
                    document.getElementById("edit-id").value = this.getAttribute("data-id");
                    document.getElementById("edit-usuario").value = this.getAttribute("data-usuario");
                    document.getElementById("edit-fecha").value = this.getAttribute("data-fecha");
                    document.getElementById("edit-hora_entrada").value = this.getAttribute("data-hora_entrada");
                    document.getElementById("edit-hora_salida").value = this.getAttribute("data-hora_salida");
                });
            });
        });
    </script>
</body>
</html>
