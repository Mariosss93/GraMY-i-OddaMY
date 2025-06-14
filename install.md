## Krótka instrukcja uruchomienia projektu na VPS
Poniżej znajduje się prosta instrukcja uruchomienia aplikacji „GraMY i OddaMY” na własnym serwerze VPS z systemem Ubuntu.

### Krok 1. Zainstaluj wymagane pakiety

```bash
sudo apt update
sudo apt install apache2 php php-sqlite3 php-xml git unzip
```

### Krok 2. Pobierz projekt z repozytorium GitHub

```bash
cd /var/www/html/
sudo git clone https://github.com/Mariosss93/GraMY-i-OddaMY.git graMY
cd graMY
(Jeśli repo jest prywatne, użyj swojego loginu/hasła/tokena)
```

### Krok 3. Ustaw odpowiednie uprawnienia

```bash
sudo chown -R www-data:www-data /var/www/html/graMY
sudo chmod -R 755 /var/www/html/graMY
```

###Krok 4. Utwórz bazę danych SQLite

```bash
cd /var/www/html/graMY/database
sqlite3 games.db < schema.sql
```
(jeśli masz plik schema.sql; jeśli nie, możesz utworzyć bazę z poziomu aplikacji)

### Krok 5. Uruchom serwer

```bash
sudo systemctl restart apache2
Aplikacja powinna być dostępna pod adresem:
http://[adres_IP_VPS]/graMY/
```

### Krok 6. (Opcjonalnie) Skonfiguruj HTTPS
Polecane jest użycie certyfikatu SSL (np. Let's Encrypt).
Przykład instalacji:

```bash

sudo apt install certbot python3-certbot-apache
sudo certbot --apache
```

### Dodatkowe wskazówki:

Możesz zarządzać kodem przez GitHub – każde git pull pobierze aktualizacje.

Konfigurację bazy danych i katalogów sprawdzaj w plikach PHP (np. ścieżka do database/games.db).

W razie błędów sprawdzaj logi Apache:

```bash

sudo tail -n 100 /var/log/apache2/error.log
```

---

### Podsumowanie
Projekt gotowy do użycia!
Po wdrożeniu możesz korzystać ze wszystkich funkcji: rejestracja/logowanie użytkowników, wypożyczanie, integracja z API BGG, import/eksport danych itd.

