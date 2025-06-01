

````markdown
# 📦 Instrukcja instalacji i wdrożenia projektu „GraMY i Oddamy” na VPS

## Wymagania serwera

- System: Ubuntu (testowane na 22.04/24.10, ale działa na większości Linuxów)
- Zainstalowany **serwer WWW** (np. Apache2)
- **PHP 8** (lub nowszy)
- **SQLite3** (wraz z rozszerzeniem dla PHP)
- **git** (jeśli klonujesz repozytorium)

---

## Kroki instalacji

### 1. Zainstaluj wymagane pakiety

```bash
sudo apt update
sudo apt install apache2 php php-sqlite3 sqlite3 git
````

---

### 2. Sklonuj repozytorium projektu

```bash
cd /var/www/html
git clone https://github.com/Mariosss93/GraMY-i-OddaMY.git graMY
cd graMY
```

---

### 3. Utwórz bazę danych SQLite (jeśli nie istnieje)

```bash
mkdir -p ../database
sqlite3 ../database/games.db "
CREATE TABLE IF NOT EXISTS games (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    players TEXT,
    age INTEGER,
    status TEXT DEFAULT 'available'
);
"
```

*(jeśli katalog `database` już istnieje i ma plik `games.db`, ten krok można pominąć)*

---

### 4. Ustaw uprawnienia do katalogu bazy

```bash
sudo chown -R www-data:www-data ../database
sudo chmod -R 755 ../database
```

---

### 5. (Opcjonalnie) Skonfiguruj Apache (jeśli strona nie wyświetla się poprawnie)

Sprawdź, czy katalog `/var/www/html/graMY` jest dostępny pod adresem:
`http://[adres_vps]/graMY/index.php`

---

### 6. Gotowe!

* Otwórz przeglądarkę i wejdź na adres:
  `http://[adres_vps]/graMY/index.php`
* Dodawaj gry, testuj wypożyczanie, korzystaj z API BGG!

---

## Dodatkowe informacje

* Wszystkie pliki PHP powinny być w katalogu `graMY`
* Plik bazy danych: `../database/games.db` (jeden poziom wyżej, by nie był dostępny z sieci)
* Jeśli pojawią się błędy „Permission denied” przy zapisie bazy — upewnij się, że użytkownik serwera (`www-data`) ma prawa do katalogu `database`

---

## Aktualizacja aplikacji (gdy są nowe wersje na GitHubie)

```bash
cd /var/www/html/graMY
git pull
```

---

## FAQ

* **Jak sprawdzić wersję PHP?**
  `php -v`
* **Jak sprawdzić, czy działa baza?**
  `sqlite3 ../database/games.db ".tables"`
* **Jak zmienić port serwera?**
  Zmień konfigurację Apache: `/etc/apache2/ports.conf`

---

## KONIEC!

Aplikacja jest gotowa do użytku na Twoim VPS!
W razie problemów — patrz logi serwera (`/var/log/apache2/error.log`) lub napisz do autora 😎

```

---

