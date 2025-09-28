#### **08-09-2025**

Bilal was 2 uren bezig met zoeken en notion te lezen en 1 uur met  taak verdelen 
Mohammed was bezig met 2 uren debriefing  en 1 uur in notion lezen
Rachael was 2 bezig met technische ontwerpen en 1.5 uur notion te lezen 

#### **09-09-2025**

Bilal was  2 uur  bezig met header en bestanden te Regelen en 1.5 uur bezig  logo te goed te maken
Mohammed was 3 uur bezig met debriefing en plan van aanpak maken 
Rachael was 2 uur bezig met technische ontwerpen en 1 uur met footer
armin niet gekomen

#### **10-09-2025**

Bilal heeft header gemaakt en het duurde 4 uren met  branch mergen 
Mohammed heeft debriefing gemaakt en 2 uren bezig met ERD maken
Rachael was  2 uren bezig met  de technische ontwerpen en heeft het afgemaakt en  1.5 uur bezig met footer 
armin niet gekomen

#### **11-09-2025**
Bilal heeft meer style toegevoegd en heeft met content begonnen het duurde 4 uren.
Mohammed heeft  ERD afgemaakt  in 1.5 uur en he is bezig met hero section
rachel was ziek 

armin niet gekomen

#### **12-09-2025**
Bilal was 2 uur  bezig met content.
Mohammed was 1.5 uur bezig met hero section .
rachel was ziek

#### **15-09-2025**
Bilal was 3 uur bezig films in de content  te zetten
muhammed  was afwezig 
rachel was ziek
#### **16-09-2025**
Bilal was 3 uur bezig met styling van film agenda pagina 
Mohammed was 3 uur bezig met hero section
rachel was 3 uur bezig met footer 
#### **17-09-2025**
Bilal was 5 uur bezig met header/content/film agenda pagina stylen en maken.
Mohammed was 5 uur bezig met de hero section af te maken .
rachel was  5 uur bezig met footer af te maken .

#### **18-09-2025**
Bilal was 6 uur  bezig met detail pagina maken en voor het echte werkende detail pagina maken 
Mohammed was 6 uur bezig met hero section af te maken en beginnen met stoelen te maken 
Rachel was 6 uur bezig met kies je ticket te maken en stylen

#### **19-09-2025**
Bilal was 2 uur bezig met detail pagina sterren en img en detail pagina te stylen 
Mohammed was 2 uur bezig met stoelen in bestel pagina te maken .
Rachel was 2 uur bezig met kies je ticket in de bestel pgina te maken.
#### **22-09-2025**
Bilal was 3.5 uur bezig met detail pagina .
Rachel was 3.5 uur bezig met kies je ticket.
Mohammed was 3.5 uur bezig met stoelen te maken.

#### **23-09-2025**
Bilal was 3 uur bezig met detail pagina .
Rachel was 3 uur bezig met formulier te maken.
Mohammed was 3uur bezig met stoelen te maken.

#### **24-09-2025**
Bilal was 3 uur bezig met bestel pagina .
Rachel was 3 uur bezig met formulier te maken.
Mohammed was 3uur bezig met stoelen te maken.

### Gedetailleerde Samenvatting van Uitgevoerde Werkzaamheden (Gebaseerd op Dagelijkse Entries en Code Analyse)

#### Bilal (Ik):
- **Initial Setup en Header (09-09 tot 10-09)**: Projectstructuur opgezet, header met navigatie en dropdown gemaakt (assets/js/dropdown.js), logo geïntegreerd (assets/logo/), bestanden georganiseerd in assets/css/includes/. Branch merging en basis tests uitgevoerd.
- **Content en Styling (11-09 tot 15-09)**: Styling toegevoegd aan hoofdpagina (index.php), content secties gebouwd, films toegevoegd met posters (assets/films/), CSS bestanden zoals content.css beheerd en verwijderd waar redundant.
- **Film Agenda Pagina (16-09 tot 17-09)**: film-agenda.php gestyled met layout voor filmoverzicht, inclusief integratie met tijdelijk-database.php voor filmdata.
- **Detail Pagina Ontwikkeling (18-09 tot 23-09)**: detail-pagina.php volledig gebouwd met film details (titel, release, duur, genre, IMDb score), sterren rating via stars-filter.php, acteur afbeeldingen (assets/acteurs/), kijkwijzer logica (assets/kijkwijzers/), trailer embed functionaliteit, lees-meer modal (assets/js/lees-meer.js), en styling (assets/css/detail-pagina.css). API integratie via api-database.php voor gedetailleerde data, overbodige bestanden verwijderd.
- **Bestel Pagina en Fixes (24-09)**: bestel-pagina.php ontwikkeld met ticket bestellen form, film selectie fixes, API calls voor orders (fetchTicketOrders), price.php gemaakt voor prijsberekening en validatie, integratie met stoelen.php. Kijkwijzer images toegevoegd.

#### Mohammed:
- **Hero Section (11-09 tot 18-09)**: Hero section op index.php gemaakt met achtergrond (assets/images/background.jpg), styling (assets/css/includes/hero-section.css), en functionaliteit voor scrollbare header (assets/js/scrollbare-header.js). Merges uitgevoerd voor integratie.
- **Stoelen en Bestel Integratie (18-09 tot 24-09)**: stoelen.php gemaakt voor zaal layouts (assets/zalen/), interactieve stoel selectie met JS (assets/js/stoelen.js), integratie in bestel-pagina.php. Merges van stoelen branch, updates voor ticket selectie.

#### Rachael:
- **Footer (09-09 tot 17-09)**: Footer gemaakt met social media icons (assets/icons/), styling (assets/css/includes/footer.css), en integratie in alle pagina's.
- **Kies Je Ticket (18-09 tot 22-09)**: Kies-je-ticket component gebouwd voor bestel-pagina.php, met dropdown filters (assets/js/bestel-dropdown-filter.js), styling (assets/css/includes/kies-ticket.css), en merge van branch.
- **Formulier (23-09 tot 24-09)**: Bestel formulier gemaakt met styling en layout.

#### Armin:
- Niet deelgenomen aan de werkzaamheden.

#### Algemene Werkzaamheden:
- **Merges en Tests**: Meerdere branch merges uitgevoerd voor integratie van header, stoelen, detail-pagina, en kies-je-ticket. Basis tests en deletes voor cleanup.
- **API Integratie**: api-database.php opgezet met curl calls naar externe API, fallback naar tijdelijk-database.php, formatting van data voor consistentie.
- **Overige Updates**: Nieuwe kijkwijzer images toegevoegd voor discriminatie, drugs, grof taal, etc., ter ondersteuning van kijkwijzer functionaliteit.

