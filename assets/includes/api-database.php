<?php
// API Database Fetcher
// This file fetches movie data from the external API and formats it like tijdelijk-database.php

function fetchMoviesFromAPI() {
    // Clean API key (remove trailing newline and space)
    $apiKey = trim("EFIdY9nTsPBguvhsjYwSiNYWpYpYYaWx");

    // Fetch all movies from the API using get_movies.php (no parameters to get all)
    $url = "https://annexbios.gluwebsite.nl/admin/api/movies/get_movies.php";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["api-key: " . $apiKey]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // cURL Error occurred, return empty array
        curl_close($ch);
        return [];
    }

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

function fetchMovieDetails($id) {
    // Clean API key (remove trailing newline and space)
    $apiKey = trim("EFIdY9nTsPBguvhsjYwSiNYWpYpYYaWx");

    // Fetch movie details from the API using get_movie.php with movie_id
    $url = "https://annexbios.gluwebsite.nl/admin/api/movies/get_movie.php?movie_id=" . $id;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["api-key: " . $apiKey]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // cURL Error occurred, return null
        curl_close($ch);
        return null;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
            return $data['data']; // Return the data object containing movie, genres, cast, crew
        }
    }

    return null;
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
            "imdb_score" => $movie['stars'] ?? 0,
            "regisseur" => $movie['director']['name'] ?? 'Timo Tjahjanto', // Default director
            "land" => $land['movie']['origin_country'] ?? 'US', // Not provided in API
            "acteurs" => $acteurs, // No cast in API, remains empty
            "poster" => $movie['poster'] ?? '',
            "trailers" => '', // API provides has_trailer boolean, but no URL
            "informatie" => $movie['overview'] ?? '',
            "stars"=>$movie['stars']??''
        ];
    }
}
?>
