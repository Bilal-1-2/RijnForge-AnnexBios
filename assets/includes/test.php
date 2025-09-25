<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

// Clean API key (remove trailing newline and space)
$apiKey = "EFIdY9nTsPBguvhsjYwSiNYWpYpYYaWx";

// Test the get_movies.php endpoint to fetch all movies
$url = "https://annexbios.gluwebsite.nl/admin/api/movies/get_movies.php";

echo "<h3>Testing get_movies.php endpoint</h3>";

// //----
// $ch = curl_init("https://annexbios.gluwebsite.nl/admin/api/movies/get_movie.php?movie_id=1007734");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: jouw_api_key"]);
// $response = curl_exec($ch);
// curl_close($ch);
// echo $response;
// //----------------------------



$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: " . $apiKey]);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For testing, disable SSL verification
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    // Get HTTP status code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "HTTP Status Code: " . $httpCode . "<br><br>";
    echo "Response:<br><pre>" . htmlspecialchars($response) . "</pre>";
}

curl_close($ch);

// Debug information
echo "<br><br>Debug Info:<br>";
echo "API Key: " . $apiKey . "<br>";
echo "URL: " . $url . "<br>";
echo "Expected API Responses:<br>";
echo "
"
?>

</body>
</html>
