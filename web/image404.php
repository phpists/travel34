<?php
$image = base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
header('Content-Type: image/gif');
header('Content-Length: ' . mb_strlen($image, '8bit'));
echo $image;
exit;
