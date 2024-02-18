<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

$events = 10;
while ($events >= 0) {
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
