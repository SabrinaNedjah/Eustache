
<?php

require_once('header.php');

// Autoload vendors.
require('vendor/autoload.php');

// Initialize GuzzleHTTP Client.
$client = new \GuzzleHttp\Client();

// Prepare API URL.
$url = 'http://api.openweathermap.org/data/2.5/forecast?lat='.$_GET['lat'].'&lon='.$_GET['long'].'&units=metric&APPID=e10cd92554b62dddae13cdd67a7a5035';
$path = './cache/'.md5($url);

// Retrieve data from cache.
if(file_exists($path) && time() - filemtime($path) < 10) {
  $forecast = json_decode(file_get_contents($path));
} else {
  // Retrieve forecast.
  $res = $client->request('GET', $url);
  $data = $res->getBody();
  $forecast = json_decode($data);

  // Save data into cache file.
  file_put_contents($path, json_encode($forecast));
}
?>
<div class="prev_weather">
  <div class="container">
    <div class="row">
     <img class="logow" src="images/eustache_logo.png" alt="logo">
      <div class="previ_day mx-auto col-xs-12 ">
      
  <?php
  foreach($forecast->list as $_forecast):
    if (date('H', $_forecast->dt) === '11' || date('H', $_forecast->dt) === '12') { ?>
        <div class="day">
          <div><?= date('D m Y', $_forecast->dt); ?></div>
          <div><?= round($_forecast->main->temp); ?>°</div>
        </div>
    <?php
    }
  endforeach; ?>
      </div>
    </div>
  </div>
</div>