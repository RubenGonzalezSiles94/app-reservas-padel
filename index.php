<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package Laravel
 */

// Definir el directorio public
define('LARAVEL_PUBLIC_DIR', __DIR__ . '/public');

// Obtener la URI solicitada y limpiarla
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Remover /public de la URI si existe
$uri = preg_replace('/^\/public/', '', $uri);

// Verificar si el archivo existe en public
if ($uri !== '/' && file_exists(LARAVEL_PUBLIC_DIR . $uri)) {
    $mime = mime_content_type(LARAVEL_PUBLIC_DIR . $uri);
    header('Content-Type: ' . $mime);
    readfile(LARAVEL_PUBLIC_DIR . $uri);
    return;
}

// Redirigir todas las demás solicitudes al index.php de Laravel
require_once LARAVEL_PUBLIC_DIR . '/index.php';
