<?php

require __DIR__ . '/../vendor/autoload.php';
chdir(__DIR__);

$content = include __DIR__ . '/index.php';
file_put_contents('templates/output.html', $content);
$date = \Carbon\Carbon::now()->format('d-m-Y');

$outputFolder = __DIR__ . "/../cv/";
if (!file_exists($outputFolder)) {
    mkdir($outputFolder);
}

$output_file = "$outputFolder/CV Mandy Schoep - $date.pdf";

if (file_exists($output_file)) {
    unlink($output_file);
}
$str = "wkhtmltopdf --footer-html templates/footer.html --margin-top 14mm --margin-left 20mm --margin-right 20mm --margin-bottom 16mm templates/output.html '$output_file'";
system($str);