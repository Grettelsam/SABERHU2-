<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $usuario = $_POST["usuario"];
    $fecha = $_POST["fecha"];
    $hora_entrada = $_POST["hora_entrada"];
    $hora_salida = $_POST["hora_salida"];

    // Conexión a la base de datos (ajusta con tus credenciales)
    $conn = new mysqli("localhost", "root", "", "test");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Actualizar datos
    $sql = "UPDATE horario SET usuario=?, fecha=?, hora_entrada=?, hora_salida=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $usuario, $fecha, $hora_entrada, $hora_salida, $id);

    if ($stmt->execute()) {
        echo "Horario actualizado con éxito.";
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirigir a la página principal después de editar
    header("Location: admin.php");
    exit();
}
?>
