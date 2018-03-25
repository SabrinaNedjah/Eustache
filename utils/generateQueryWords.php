<?php

// Function to match weather to words to make efficient query to the Spotify API.
function getKeyword($weather) {
  switch (strtolower($weather)) {
    case 'rain':
      return 'Jour de pluie';
    case 'snow':
      return 'Winter Sounds';
    case 'mist':
      return 'cocooning';
    case 'clouds':
      return 'i got a sunshine on a cloudy day';
    case 'clear':
      return 'Sunny';
    case 'thunderstorm':
      return 'Dark & Stormy';
    case 'drizzle';
      return 'Nocturne';
    default:
      break;
  }
}

?>
