<?php

require_once('header.php');

    if (isset($_GET['lat']) && isset($_GET['long']))  {
      include('meteo.php');
    }
    else {
      include('localisation.php');
    }
  ?>
  <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
