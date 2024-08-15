!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path = 'simple_html_dom.php'; 
if (!file_exists($path)) {
    die("Arquivo $path não encontrado.");
}
include($path);

function fetchLinksFromPage($url) {
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

    $links = [];
    foreach ($container->find('a') as $link) {
        $href = $link->href;
        // Verifica se o link é relativo e o torna absoluto
        if (strpos($href, 'http') !== 0) {
            $href = rtrim($url, '/') . '/' . ltrim($href, '/');
        }
        // Filtra apenas links HTTPS
        if (strpos($href, 'https://') === 0) {
            $links[] = $href;
        }
    }

    return $links;
}

$pageUrl = 'https://ootimista.com.br/edicao-do-dia/o-otimista-edicao-impressa-de-14-08-2024?page=1';

$links = fetchLinksFromPage($pageUrl);

if (empty($links)) {
    echo "Nenhum link encontrado.";
} else {
    foreach ($links as $link) {
        echo htmlspecialchars($link) . "<br>";
    }
}
?>
