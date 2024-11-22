<?php
// Incluye la conexión a la base de datos y las clases necesarias
require_once 'db_connect.php'; // Asegúrate de tener esta conexión a la base de datos
require_once 'ControllerUsuarios.php';


// Verifica si se enviaron datos a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $idEmpleado = $_POST['idEmpleado'];
    $idAlmacen = $_POST['idAlmacen'];
    $login = $_POST['login'];
    $passlogin = $_POST['passlogin'];
    $idPerfil = $_POST['idPerfil'];

    // Crear un array con los datos del nuevo usuario
    $datosUsuario = array(
        "idEmpleado" => $idEmpleado,
        "idAlmacen" => $idAlmacen,
        "login" => $login,
        "passlogin" => $passlogin,
        "idPerfil" => $idPerfil
    );

    // Llama al método para crear el usuario
    $respuesta = ControllerUsuarios::ctrCrearUsuario($datosUsuario);

    // Verifica la respuesta y muestra un mensaje adecuado
    if ($respuesta == "ok") {
        echo '<script>alert("Usuario creado con éxito"); window.location = "create_user.php";</script>';
    } else {
        echo '<script>alert("Error al crear el usuario"); window.location = "create_user.php";</script>';
    }
} else {
    // Si el método de solicitud no es POST, redirige al formulario
    header("Location: create_user.php");
    exit();
}
?>
