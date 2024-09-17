<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // Cambia si tu servidor es diferente
$username = "root";        // Usuario por defecto de MySQL en XAMPP
$password = "";            // Contraseña por defecto de MySQL en XAMPP (vacío en instalaciones por defecto)
$dbname = "registro_db";   // Nombre de la base de datos que creaste

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $fecha = htmlspecialchars($_POST['fecha']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $edad = htmlspecialchars($_POST['edad']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $email = htmlspecialchars($_POST['email']);
    $genero = htmlspecialchars($_POST['genero']);

    // Preparar la consulta SQL para insertar datos
    $sql = "INSERT INTO usuarios (fecha, nombre, edad, telefono, email, genero)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar declaración
    $stmt = $conn->prepare($sql);

    // Enlazar parámetros
    $stmt->bind_param("ssisii", $fecha, $nombre, $edad, $telefono, $email, $genero);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo "<!DOCTYPE html>";
        echo "<html lang='es'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Datos Guardados</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; margin: 20px; }";
        echo ".container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #d28800; border-radius: 50px; box-shadow: 0 0 10px rgb(249, 144, 5); }";
        echo "h1 { text-align: center; }";
        echo "p { margin: 10px 0; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h1>Datos Guardados</h1>";
        echo "<p>Los datos se han guardado correctamente en la base de datos.</p>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar declaración
    $stmt->close();
} else {
    // Si el script es accedido directamente sin enviar un formulario
    echo "No se han enviado datos.";
}

// Cerrar conexión
$conn->close();
?>
