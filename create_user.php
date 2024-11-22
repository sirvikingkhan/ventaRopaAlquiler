<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$dbname = "newventa";
$user = "root";
$password = "";

try {
    // Crear una nueva conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Verificar si se enviaron datos a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $idEmpleado = $_POST['idEmpleado'];
    $idAlmacen = $_POST['idAlmacen'];
    $login = $_POST['login'];
    $passlogin = $_POST['passlogin'];
    $idPerfil = $_POST['idPerfil'];

    // Validaciones básicas
    if (empty($idEmpleado) || empty($idAlmacen) || empty($login) || empty($passlogin) || empty($idPerfil)) {
        echo '<script>alert("Todos los campos son obligatorios"); window.location = "create_user_form.html";</script>';
        exit();
    }

    // Encriptar la contraseña
    $passlogin = password_hash($passlogin, PASSWORD_BCRYPT);

    // Consulta para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (idEmpleado, idAlmacen, login, passlogin, idPerfil, estado, ultimo_login, fecha_creacion, es_admin)
            VALUES (:idEmpleado, :idAlmacen, :login, :passlogin, :idPerfil, 1, NULL, NOW(), 0)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEmpleado', $idEmpleado);
        $stmt->bindParam(':idAlmacen', $idAlmacen);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':passlogin', $passlogin);
        $stmt->bindParam(':idPerfil', $idPerfil);
        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            echo '<script>alert("Usuario creado con éxito"); window.location = "create_user_form.html";</script>';
        } else {
            echo '<script>alert("Error al crear el usuario"); window.location = "create_user_form.html";</script>';
        }
    } catch (PDOException $e) {
        echo '<script>alert("Error al crear el usuario: ' . $e->getMessage() . '"); window.location = "create_user_form.html";</script>';
    }
} else {
    // Si el método de solicitud no es POST, redirige al formulario
    header("Location: create_user_form.html");
    exit();
}
?>
