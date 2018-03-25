<?php
/*
  Request Access Token from Spotify API.
*/

// Identifiers.
$spotifyClientId = '3c9c998f8597445f8f12a0694e982fbc';
$spotifySecretKey = '27910a822052455bbdf17f30f962bbec';

$res = $client->request('POST', 'https://accounts.spotify.com/api/token', [
  'headers' => [
    'Authorization' => 'Basic ' . base64_encode($spotifyClientId.':'.$spotifySecretKey)
  ],
  'form_params' => [
    'grant_type' => 'client_credentials'
  ]
]);
$data = $res->getBody();
$json = json_decode($data);

// Store Access Token.
$spotifyAccessToken = $json->access_token;

?>
