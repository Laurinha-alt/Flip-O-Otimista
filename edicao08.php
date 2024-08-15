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

function fetchImageLinksFromPage($url) {
    $html = file_get_contents($url);

    if ($html === FALSE) {
        die("Erro ao recuperar o conteúdo da página.");
    }

    // Debug: Exibir parte do conteúdo HTML
    // echo htmlspecialchars(substr($html, 0, 1000)); // Exibe os primeiros 1000 caracteres do HTML para depuração

    $dom = str_get_html($html);

    if (!$dom) {
        die("Erro ao criar o DOM a partir do HTML.");
    }

    $images = [];
    foreach ($dom->find('img') as $img) {
        // Debug: Exibir o HTML das tags <img> encontradas
        // echo htmlspecialchars($img->outertext) . "<br>"; // Exibe o HTML da tag <img>

        $src = $img->src;
        // Verifica se a URL é relativa e a torna absoluta
        if (strpos($src, 'http') !== 0) {
            $src = rtrim($url, '/') . '/' . ltrim($src, '/');
        }
        // Filtra apenas links HTTPS
        if (strpos($src, 'https://') === 0) {
            $images[] = $src;
        }
    }

    return $images;
}

$pageUrl = 'https://ootimista.com.br/edicao-do-dia/o-otimista-edicao-impressa-de-14-08-2024?page=1';

$images = fetchImageLinksFromPage($pageUrl);

if (empty($images)) {
    echo "Nenhuma imagem encontrada.";
} else {
    foreach ($images as $image) {
        echo htmlspecialchars($image) . "<br>";
    }
}
?>
