# TODO: Add Kijkwijzer Viewing Guides to Films

## Steps from Approved Plan

- [x] Step 1: Download standard Kijkwijzer icons (ages: 6,9,14,16,18,AL; warnings: angst, seks, drugs, discriminatie, grof-taal) to assets/kijkwijzers/ using curl. Existing: 12, eng, geweld.
- [x] Step 2: Update assets/includes/api-database.php - In the foreach loop formatting $data, add genre-based logic to set "kijkwijzer" => ["age" => "12", "warnings" => ["geweld"]] for each film.
- [x] Step 3: Update assets/includes/tijdelijk-database.php - Add "kijkwijzer" arrays to each fallback film entry based on genre assumptions.
- [x] Step 4: Update detail-pagina.php - Replace hardcoded .detail-viewing-guide <img> tags with dynamic PHP: output age img + loop over warnings imgs using generic names (e.g., kijkwijzer-12.png, kijkwijzer-geweld.png).
- [x] Step 5: Verify - Use list_files on assets/kijkwijzers/ to confirm icons; browser_action on local detail-pagina.php (simulate POST for a film ID) to check display; update this TODO with progress.

Notes:
- Genre assumptions: Animation/Family=AL/6 no warnings; Drama/Romance/Comedy=12 possible grof/seks; Action/Thriller=12-14 geweld+angst; Horror=16 geweld+angst; Sci-Fi/Fantasy=12 geweld.
- For legacy static films (Deadpool etc.), add manual entries if displayed, but focus on API data.
- After all steps, mark complete and use attempt_completion.
