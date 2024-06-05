<?php

// URL del formulario al que se enviarán los datos
$url = 'http://localhost:8080/plato/new?devMode=1';

// Datos del formulario
$platos = [
    "bebida-1.jpg" => [
        'nombre_plato' => 'Coca-Cola 1',
        'ingredientes' => 'Bebida Gasificada sabor coca',
        'tipo_plato' => 'Bebida',
        'precio' => '1500',
    ],
    "BigPower.jpg" => [
        'nombre_plato' => 'BigPower',
        'ingredientes' => 'Hamburguesa de la casa',
        'tipo_plato' => 'Hamburguesa',
        'precio' => '2000',
    ],
    "Cheeseburger.jpg" => [
        'nombre_plato' => 'Cheeseburger',
        'ingredientes' => 'Hamburguesa de la casa con queso derretido encima',
        'tipo_plato' => 'Hamburguesa',
        'precio' => '2400',
    ],
    "Coca.jpg" => [
        'nombre_plato' => 'Coca Chica',
        'ingredientes' => 'Bebida Gasificada sabor coca, presentacion chica',
        'tipo_plato' => 'Bebida',
        'precio' => '1000',
    ],
    "Fanta.jpg" => [
        'nombre_plato' => 'Fanta Chica',
        'ingredientes' => 'Bebida Gasificada sabor Fanta, presentacion chica',
        'tipo_plato' => 'Bebida',
        'precio' => '1000',
    ],
    "Muzarelitas.jpg" => [
        'nombre_plato' => 'Muzarelitas',
        'ingredientes' => 'Palitos de muzzarella fritos',
        'tipo_plato' => 'Otro Plato',
        'precio' => '2500',
    ]
];

foreach ($platos as $fileImgName => $data) {
    // Ruta del archivo que se va a subir
    $fileImgPath = __DIR__ . "/menu/$fileImgName";

    // Verificar si el archivo existe
    if (!file_exists($fileImgPath)) {
        echo "El archivo $fileImgPath no existe.\n";
        continue;
    }

    // Iniciar una nueva sesión cURL
    $ch = curl_init();

    // Configurar las opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Añadir el archivo al array de datos
    $cfile = new CURLFile($fileImgPath, 'image/jpeg', $fileImgName);
    $data['imagen_plato'] = $cfile;

    // Configurar los campos del formulario para que cURL los envíe como multipart/form-data
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Opciones para recibir la respuesta y manejar errores
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: multipart/form-data',
    ]);

    // Ejecutar la solicitud cURL
    $response = curl_exec($ch);

    // Manejar errores
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo 'Error:' . $error_msg . "\n";
    } else {
        echo 'Respuesta del servidor para ' . $fileImgName . ': ' . $response . "\n";
    }

    // Cerrar la sesión cURL
    curl_close($ch);
}
