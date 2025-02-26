<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos existen en $_POST antes de usarlos
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

    if (!empty($correo) && !empty($contrasena)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            // Verifica la contraseña sin encriptación
            if ($contrasena === $usuario['contrasena']) { 
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según el rol
                header("Location: " . ($usuario['rol'] == 'admin' ? "admin.php" : "usuario.php"));
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "El usuario no existe.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<form method="POST" action="login.php">
    <input type="email" name="correo" required placeholder="Correo">
    <input type="password" name="contrasena" required placeholder="Contraseña">
    <button type="submit">Ingresar</button>
</form>
