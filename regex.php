!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function fetchLinksFromPage($url) {

    $html = file_get_contents($url);


    if ($html === FALSE) {
        die("Erro ao recuperar o conteúdo da página.");
    }


    preg_match('/<div class="container">(.*?)<\/div>/s', $html, $matches);

    if (!isset($matches[1])) {
        die("Div com a classe 'container' não encontrada.");
    }


    $containerHtml = $matches[1];

    preg_match_all('/<a\s+href="([^"]*)"/i', $containerHtml, $linkMatches);

    $links = [];

        if (strpos($href, 'http') !== 0) {
            $href = $url . '/' . ltrim($href, '/');
        }
        $links[] = $href;
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