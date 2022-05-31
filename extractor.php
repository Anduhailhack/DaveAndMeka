<?php

$zip = new ZipArchive;
if ($zip->open('meka_2.zip') === TRUE) {
    $zip->extractTo('./');
    $zip->close();
    echo 'ok';
}

?>