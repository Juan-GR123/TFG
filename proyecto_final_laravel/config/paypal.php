<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PayPal API Credentials
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir las credenciales de tu cuenta de PayPal.
    |
    */

    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret' => env('PAYPAL_SECRET'),
    'currency' => env('PAYPAL_CURRENCY', 'EUR'), // Cambia 'USD' por tu moneda preferida, como 'EUR'
    'mode' => env('PAYPAL_MODE', 'sandbox'), // Cambia a 'live' cuando estés listo para producción

    /*
    |--------------------------------------------------------------------------
    | Configuración del entorno de la API
    |--------------------------------------------------------------------------
    |
    | Define el modo de conexión. 'sandbox' es para pruebas y 'live' es para producción.
    |
    */

    'sandbox' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
    ],

    'live' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SECRET'),
    ],

    'payment_action' => 'Sale', // Puede ser 'Sale', 'Authorization', o 'Order'
    'currency' => env('PAYPAL_CURRENCY', 'EUR'), // Establece la moneda que desees usar
    'notify_url' => '', // Opcional: la URL de notificación de PayPal (usualmente usada para IPN)
    'locale' => 'en_US', // Establece el idioma para la interfaz
    'validate_ssl' => true, // Validar SSL
];
