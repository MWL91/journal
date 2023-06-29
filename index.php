<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

const BASE_URL = 'https://api.openai.com/v1';
define("API_KEY", $_ENV['OPENAI_API_KEY']);

$inputFromDairy = $_POST['inputFromDairy'] ?? null;

$body = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [["role" => "user", "content" => 'Na podstawie wpisu z dziennika: `' . $inputFromDairy . '`. Zadaj 3 pytania do zastanowienia się nad tymi zagadnieniami, które mogą je pogłębić.']]
];
$header = ['Authorization' => 'Bearer ' . API_KEY, 'Content-Type' => 'application/json'];

$client = new Client([
    'base_uri' => BASE_URL,
]);
$request = new Request(
    'POST',
    BASE_URL . '/chat/completions',
    $header,
    json_encode($body)
);

$responseData = null;
if($inputFromDairy) {
    $response = $client->send($request);
    $responseData = json_decode($response->getBody()->getContents());
}

$inputFromDairy ??= "Stworzyłem na swojej stronie ofertę indywidualnych szkoleń programistycznych, tak by wszystko było do kupienia.

Zrobiłem też trochę zmian na stronie i wprowadziłem slajdy.

Pod koniec dnia stworzyłem scenariusz, ale obawiam się, że nie jest wystarczająco idealny.

Muszę się nauczyć robienia lepszych i ciekawszych filmów. Również takich, które będą prostsze.

Montaż zajmuje dużo czasu. Dobrze napisane scenariusze mogą mi pomóc skrócić ten czas drastycznie i zrobić materiały, które bardziej się spodobają innym ludziom.

Vega robił plany oddziałujące odpowiednio na widza, różnymi bodźcami. Projektowanie emocji jest kluczowe!";


include 'content.php';