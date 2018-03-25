if (window.location.search === '' ) {
  fetch('http://ip-api.com/json')
    .then(response => response.json())
    .then(data => {
      window.location.href = window.location.href + "?lat=" + data.lat + "&long=" + data.lon;

    })
    .catch(err => {
      console.error(err);
    });
}
