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
$apiKey = trim("EFIdY9nTsPBguvhsjYwSiNYWpYpYYaWx");
 
// Test movie ID (try a different one if this doesn't work)
$movieId = 1007734;
 
// Try different API key header names and methods
$methods = [
    "api-key" => "https://annexbios.gluwebsite.nl/admin/api/movies/get_movie.php?movie_id=" . $movieId,
   // "Authorization" => "https://annexbios.gluwebsite.nl/admin/api/movies/get_movie.php?movie_id=" . $movieId,
    //"query_param" => "https://annexbios.gluwebsite.nl/admin/api/movies/get_movie.php?movie_id=" . $movieId . "&api_key=" . $apiKey
];
 
foreach ($methods as $method => $url) {
    echo "<h3>Testing method: " . $method . "</h3>";
 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    if ($method !== "query_param") {
        $headerValue = ($method === "Authorization") ? "Bearer " . $apiKey : $apiKey;
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$method . ": " . $headerValue]);
    }
 
    // Add error handling
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For testing, disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
 
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
    echo "<hr>";
}
 
// Debug information
echo "<br><br>Debug Info:<br>";
echo "API Key: " . $apiKey . "<br>";
echo "Movie ID: " . $movieId . "<br>";
?>
<!-- Expected API Responses:
200 OK: { "success": true, "status": 200, "message": "OK", "data": { ... } }
400 Bad Request: { "success": false, "status": 400, "message": "Missing movie_id" }