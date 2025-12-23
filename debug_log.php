<?php
$content = file_get_contents('storage/logs/laravel.log');
$search = "Trying to access array offset on null";
$pos = strrpos($content, $search);

if ($pos !== false) {
    $start = strrpos(substr($content, 0, $pos), '{');
    if ($start !== false) {
        $raw = substr($content, $start, 10000); // Read plenty
        $clean = str_replace(['\n', '\"', '\\\\'], ["\n", '"', '\\'], $raw);
        file_put_contents('trace.txt', $clean);
        echo "Trace written to trace.txt";
    }
} else {
    echo "Error string not found.";
}
