<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

$statusCode = 200;
// Emulate sending headers like a PHP framework would.
header('Connection: keep-alive', false, $statusCode);
header('Content-Type: text/event-stream', true, $statusCode);
header('Cache-Control: no-cache, private, max-age=0', false, $statusCode);
header('X-Accel-Buffering: no', false, $statusCode); // Disables FastCGI Buffering on Nginx.
header('HTTP/1.1 200 OK', true, $statusCode);

if (ob_get_length()) {
    ob_end_clean();
}

flush();

$events = 100;
while ($events > 0) {
    echo "event: ping\n";
    $curDate = date(DATE_ISO8601);
    echo 'data: {"time": "' . $curDate . '"}';
    echo "\n\n";

    if (ob_get_length()) {
        ob_end_clean();
    }

    flush();

    // Interrompe o loop se o cliente abortou a conexão (fechou a página)
    if (connection_aborted()) {
        break;
    };

    sleep(1);
    $events--;
}
