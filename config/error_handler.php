<?php

$errorHandler = function ($level, $message, $file, $line) {
    file_put_contents('php://stderr', json_encode([
        'channel' => 'php',
        'level' => match ($level) {
            E_ERROR, E_CORE_ERROR => 'critical',
            E_WARNING, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING => 'warning',
            E_PARSE, E_COMPILE_ERROR => 'alert',
            E_NOTICE, E_USER_NOTICE, E_STRICT, E_DEPRECATED, E_USER_DEPRECATED => 'notice',
            E_USER_ERROR, E_RECOVERABLE_ERROR => 'error',
        },
        'message' => match ($level) {
            E_PARSE => "Parse error: $message",
            E_WARNING => "Warning: $message",
            default => $message,
        },
        'file' => "$file:$line",
        'request' => ['id' => $_SERVER['HTTP_X_REQUEST_ID'] ?? null],
    ], JSON_UNESCAPED_SLASHES)."\n");

    return true;
};

register_shutdown_function(function () use ($errorHandler) {
    if (!$error = error_get_last()) {
        return;
    }

    $errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
});

set_error_handler($errorHandler, error_reporting());
