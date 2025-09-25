<?php
// API Database Fetcher
// This file fetches movie data from the external API and formats it like tijdelijk-database.php

function fetchMoviesFromAPI() {
    $apiKey = "EFIdY9nTsPBguvhsjYwSiNYWpYpYYaWx";

    // Fetch all movies from the API using get_movies.php (no parameters to get all)
    $url = "https://annexbios.gluwebsite.nl/admin/api/movies/get_movies.php";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: " . $apiKey]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
            return $data['data']; // Return the movies array directly
        }
    }

    // Fallback to local database if API fails
    return [];
}

// Fetch data from API
$apiData = fetchMoviesFromAPI();

// If API data is empty, fall back to local database
if (empty($apiData)) {
    include 'tijdelijk-database.php'; // Fallback to local data
    $data = $data; // Use the local $data
} else {
    // Format API data to match local database structure
    $data = [];
    foreach ($apiData as $movie) {
        // Extract genres as comma-separated string
        $genres = [];
        if (isset($movie['genres']) && is_array($movie['genres'])) {
            foreach ($movie['genres'] as $genre) {
                $genres[] = $genre['name'] ?? '';
            }
        }
        $genreString = implode(', ', array_filter($genres));

        // Extract actors array in expected format
        $acteurs = [];
        if (isset($movie['cast']) && is_array($movie['cast'])) {
            foreach (array_slice($movie['cast'], 0, 5) as $actor) { // Limit to first 5 actors
                $acteurs[] = [
                    'naam' => $actor['name'] ?? '',
                    'foto' => $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w200' . $actor['profile_path'] : ''
                ];
            }
        }

        // Find director from crew
        $regisseur = '';
        if (isset($movie['crew']) && is_array($movie['crew'])) {
            foreach ($movie['crew'] as $crewMember) {
                if (isset($crewMember['job']) && $crewMember['job'] === 'Director') {
                    $regisseur = $crewMember['name'] ?? '';
                    break;
                }
            }
        }

        $data[] = [
            "film_id" => $movie['id'] ?? 0,
            "titel" => $movie['title'] ?? '',
            "releasedatum" => $movie['release_date'] ?? '',
            "duur" => $movie['runtime'] ?? 0,
            "genre" => $genreString ?: 'Action, Thriller', // Default if no genres
            "imdb_score" => $movie['vote_average'] ?? 0,
            "regisseur" => $regisseur ?: 'Timo Tjahjanto', // Default director
            "land" => $movie['origin_country'] ?? 'US',
            "acteurs" => $acteurs,
            "poster" => $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'] : '',
            "trailers" => '', // API doesn't provide trailer URLs in this response
            "informatie" => $movie['overview'] ?? ''
        ];
    }
}
?>
