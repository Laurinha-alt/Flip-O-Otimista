<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = 'simple_html_dom.php'; 
if (!file_exists($path)) {
    die("Arquivo $path não encontrado.");
}
include($path);

function fetchImagesFromPage($url) {
 
    $html = file_get_contents($url);

    if ($html === FALSE) {
        die("Erro ao recuperar o conteúdo da página.");
    }

    $dom = str_get_html($html);

    if (!$dom) {
        die("Erro ao criar o DOM a partir do HTML.");
    }

    $container = $dom->find('div.container', 0);

    if (!$container) {
        die("Div com a classe 'container' não encontrada.");
    }

    $images = [];
    foreach ($container->find('img') as $img) {
        $src = $img->src;
        if (strpos($src, 'http') !== 0) {
            $src = $url . '/' . ltrim($src, '/');
        }
        $images[] = $src;
    }

    return $images;
}

$pageUrl = 'https://ootimista.com.br/edicao-do-dia/o-otimista-edicao-impressa-de-14-08-2024?page=1'; 


$images = fetchImagesFromPage($pageUrl);

if (empty($images)) {
    echo "Nenhuma imagem encontrada.";
} else {
    foreach ($images as $image) {
        echo htmlspecialchars($image) . "<br>";
    }
}
?>