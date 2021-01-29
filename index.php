<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket.io map points</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.0/socket.io.js"></script>
    <style>
        #mapid {
            height: 98vh;
        }
    </style>
    <?php header('Access-Control-Allow-Origin: *'); ?>
</head>

<body>
    <div id="mapid"></div>

    <script>
        var mymap = L.map('mapid').setView([52.406, 16.925], 7);
        const socket = io("http://localhost:3000");
        socket.on("marker", data => {
            const marker = new L.marker(data).addTo(mymap);
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);
        L.marker([52.406, 16.925]).addTo(mymap);

        function onMapClick(e) {
            console.log("You clicked the map at " + e.latlng);
            L.marker(e.latlng).addTo(mymap);
            socket.emit("marker", e.latlng);
        }

        mymap.on('click', onMapClick);
    </script>
</body>

</html>