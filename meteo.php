<?php

    // Autoload vendors.
    require('vendor/autoload.php');

    // Require utils.
    require_once('utils/generateQueryWords.php');

    // Initialize GuzzleHTTP Client.
    $client = new \GuzzleHttp\Client();

    // Require Spotify API.
    require_once('spotify.php');

    // Prepare API URL.
    $url = 'http://api.openweathermap.org/data/2.5/weather?lat='.$_GET['lat'].'&lon='.$_GET['long'].'&units=metric&APPID=e10cd92554b62dddae13cdd67a7a5035';
    $path = './cache/'.md5($url);

    // Retrieve data from cache.
    if(file_exists($path) && time() - filemtime($path) < 10) {
      $weather = json_decode(file_get_contents($path));
    } else {
      // Retrieve current weather from API.
      $res = $client->request('GET', $url);
      $data = $res->getBody();
      $weather = json_decode($data);

      // Save data into cache file.
      file_put_contents($path, json_encode($weather));
    }

?>

<div class="left">
    <div class="container">
        <div class="row">
            <div class="pt-5 mx-auto col-md-8 ">
                <img class="logo" src="images/eustache_logo.png" alt="logo">
                <p class="celsius"><?= round($weather->main->temp); ?>°</p>
                <p class="weather"><img src="http://localhost:8888/api/images/icons/<?= $weather->weather[0]->icon; ?>.svg" width="30px" height="30px" alt="weather_logo"/>     <?= $weather->weather[0]->main; ?></p>
                <p class="town"><img src="images/located_arrow.png" width="15px" height="15px" alt="localisation logo"> <?=  $weather->name; ?></p>
                <p class="date"><?= date('l jS \of F Y G:i ', $weather->dt); ?><p>
                <p>Humidity: <?= $weather->main->humidity; ?>%</p>
                <p>Wind : <?= $weather->wind->speed; ?>M/S</p>
                <a href="prevision.php?lat=<?= $_GET['lat']; ?>&long=<?= $_GET['long']; ?>">Prévision</a>
            </div>
        </div>
    </div>
</div>
<?php
  // Prepare API URL.
  $url = 'https://api.spotify.com/v1/search?q=' . getKeyword($weather->weather[0]->main) . '&type=playlist&market=FR';
  $path = './cache/'.md5($url);

  // Retrieve data from cache.
  if(file_exists($path) && time() - filemtime($path) < 10) {
    $playlists = json_decode(file_get_contents($path));
  } else {
    // Retrieve Spotify Playlists by mood.
    $res = $client->request('GET', $url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $spotifyAccessToken
        ]
    ]);
    $data = $res->getBody();
    $playlists = json_decode($data);

    // Save data into cache file.
    file_put_contents($path, json_encode($playlists));
  }
 ?>
<div class="right">
    <div class="container">
        <div class="row">
            <div class="mx-auto col-xs-8 ">
                <div class="spotify">
                     <iframe src="https://open.spotify.com/embed?uri=<?= $playlists->playlists->items[0]->uri; ?>" width="300" height="400" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                </div>
             </div>
        </div>
    </div>
</div>
