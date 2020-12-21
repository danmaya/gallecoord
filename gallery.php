<!DOCTYPE html>
<html>

    <head>
        <title>Test API MediaWiki</title>
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
            // Agafa l'adreça
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

            // Agafa les coordenades i les imatges
            $data = json_decode($openstreetmap_json, true)[0];
            $lat = $data['lat'];
            $lon = $data['lon'];
            $mediawiki_url ="https://commons.wikimedia.org/w/api.php?action=query&format=json&prop=imageinfo&generator=geosearch&iiprop=url&ggscoord=".$lat."|".$lon."&ggsradius=500&ggsnamespace=6&ggsprimary=all";
            $mediawiki_json = file_get_contents($mediawiki_url);

            // Mostra la adreça cercada i les imatges
            $imgData = json_decode($mediawiki_json, true);

            echo $address . "<br>";

            foreach ($imgData["query"]["pages"] as $page) {
                echo "<img src=" . $page["imageinfo"][0]["url"] . " width='200'>";
            }

        }
    ?>

</body>

</html>