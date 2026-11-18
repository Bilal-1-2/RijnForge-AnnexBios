## Docker omgeving die lijkt op een XAMPP omgeving

Windows 

- Stap 1:
  Installeer Docker Desktop

- Stap 2:
  Clone deze repo in een eigen `map` (vul hiervoor zelf een naam in)
  Navigeer naar deze `map` met je command line tool (terminal, cmd of PowerShell)

- Stap 3:
  Kopieer en plak `.env.example` en rename de file naar `.env`

- Stap 4:
  Verander `SITES_ROOT` in `.env` naar het pad naar de map waar jouw websites staan

- Stap 5:
  Start Docker Desktop<br />
  Login met je Github account en vul alles in<br />
  Run in je terminal: `docker compose build`<br />
  Dan: `docker compose up -d`<br />

- Stap 6:
  Ga daarna naar http://localhost/ om te kijken of je een witte pagina krijgt

---

Mac

- Stap 1:
  Installeer Docker Desktop.

- Stap 2:
  Maak een map aan in je documenten en noem die `AMP`.
  `AMP` staat voor Apache MySQL PHP.

- Stap 3:
  Clone hierin de git-repo.

- Stap 3:
  Kopieer in de online git-omgeving het bestand `.env.example`, plak het in je map en hernoem de file naar `.env`


- Stap 4:
  Verander het pad naar
  `SITES_ROOT="/Users/****/Sites/localhost"`

  Vervang **** door je MacBook-gebruikersnaam.

- Stap 5:
  Start Docker Desktop.<br />
  Log in met je GitHub-account en vul alles in.<br />

- Stap 6:
  Klik met je rechtermuisknop op de AMP-folder en kies voor een nieuw Terminal-tabblad.
  Run in je terminal: `docker compose build`<br />
  Daarna: `docker compose up -d`<br />

**Handige tips

  `docker compose down` om de servers uit te zetten.

  `docker compose up -d` om de servers aan te zetten.

  Als Docker geen toegang heeft tot de bestanden, ga dan in Docker naar Settings → Resources (2e tab) → File Sharing en voeg het volgende pad toe:

  `/Users/****/Sites/localhost`

  Vervang **** door je MacBook-gebruikersnaam.
  
- Stap 7:
  Ga daarna naar http://localhost/ om te kijken of je een witte pagina krijgt.

- Stap 8 bonus voor mappenstructuur:
  Maak nu een file (via visual studio) aan in amp/apache en zet daarin het bestand apache-vhost.conf

Zet nu in de apache-vhost.conf:

```bash
<VirtualHost *:80>
    DocumentRoot /var/www/html
 
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
 
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

- Stap 9: 

  om alles te verwijderen 
  nu type je in `docker compose down -v` 

- Stap 10:
  om de update mappenstructuur te verwerken 
  `docker compose up --build`