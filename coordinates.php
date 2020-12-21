<!DOCTYPE html>
<html>

    <head>
        <title>Test API Google Maps</title>
    </head>

    <body>

        <form action="" method="GET">
            <label>Adreça:</label>
            <input type="text" name="address" placeholder="Escriu una adreça">
            <button type="submit">Consulta</button>
        </form>

        <?php
            if (isset($_GET['address']))
            {
                $address = $_GET['address'];
                $httpOptions = [
                "http" => [
                "method" => "GET",
                "header" => "User-Agent: Nominatim-Test"
                ]
                ];
                $streamContext = stream_context_create($httpOptions);
                $openstreetmap_url = "https://nominatim.openstreetmap.org/search?q=" . $address . "&format=json";
                $openstreetmap_json = file_get_contents($openstreetmap_url, false, $streamContext);

                // Mostra la latitud i la longitud de l'adreça cercada
                $data = json_decode($openstreetmap_json, true)[0];
                
                echo "Latitud: " . $data['lat'] . "<br>";
                echo "Longitud: " . $data['lon'];

            }
        ?>

    </body>
    
</html>