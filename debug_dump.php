<?php
$file = 'storage/logs/laravel.log';
$size = filesize($file);
$read = 5000;
$offset = max(0, $size - $read);
$content = file_get_contents($file, false, null, $offset, $read);
file_put_contents('last_log.txt', $content);
echo "Dumped last $read bytes to last_log.txt";
