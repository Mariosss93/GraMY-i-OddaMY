# 🎲 GraMY i Oddamy — Biblioteka Gier Planszowych

**Projekt zaliczeniowy na przedmiot: Zwinne Metodyki Wytwarzania Oprogramowania**  
**Autorzy:** Mariusz Pawlak, Bartłomiej Kajetan Paszko

---

## 📋 Opis projektu

**GraMY i Oddamy** to webowa aplikacja do zarządzania biblioteką gier planszowych z funkcją rejestracji, rezerwacji/wypożyczeń, importu/eksportu danych oraz integracją z API BoardGameGeek (BGG). Projekt powstał w metodyce SCRUM, a prace były dokumentowane w Jira i repozytorium GitHub.

- **Frontend:** PHP + Bootstrap 5 (nowoczesny, responsywny wygląd)
- **Backend:** PHP 8, SQLite3
- **Repozytorium:** [github.com/Mariosss93/GraMY-i-OddaMY](https://github.com/Mariosss93/GraMY-i-OddaMY)
- **Demo:** [http://57.128.228.140/graMY/index.php](http://57.128.228.140/graMY/index.php)

---

## 🛠️ Główne funkcje

- Rejestracja i logowanie użytkowników (różne role: admin, worker, user)
- Dodawanie, edycja i usuwanie gier (CRUD)
- Przeglądanie szczegółów gry
- Wypożyczanie/rezerwacja oraz zwracanie gier (obsługa stanu magazynowego)
- Generowanie numeru rezerwacji z komunikatem o odbiorze (adres WSPIA Lublin, ul. Bursaki 12)
- Integracja z BoardGameGeek (BGG) — automatyczne pobieranie opisu, liczby graczy, wieku, itp. (proxy PHP, bezpośrednie połączenie z XML API)
- Eksport wszystkich gier do pliku JSON
- Import gier z pliku JSON (upload i masowy import)
- Obsługa wyjątków i komunikatów błędów
- Nowoczesny, responsywny frontend (Bootstrap 5)
- Zabezpieczenia: walidacja danych, sesje, ograniczenie panelu admina

---

## 💡 Technologie i wymagania

- PHP 8 (CLI lub serwer Apache/Nginx z PHP)
- SQLite3 (baza w `database/games.db`)
- Bootstrap 5 (CDN — nie trzeba instalować)
- BoardGameGeek XML API + własny serwis proxy: `bgg_proxy.php`
- **Repozytorium GIT:** całość kodu wersjonowana na GitHub

---

## ⚙️ Instrukcja wdrożenia / uruchomienia

1. **Sklonuj repozytorium lub wrzuć pliki na swój serwer/VPS**  
git clone https://github.com/Mariosss93/GraMY-i-OddaMY.git

2. **Upewnij się, że masz zainstalowane PHP 8+ i SQLite3**  
- Sprawdź wersję PHP: `php -v`
- Sprawdź SQLite3: `sqlite3 --version`

3. **Przygotuj katalog na bazę danych**  
- Upewnij się, że katalog `database/` zawiera plik `games.db`
- Jeśli nie — uruchom aplikację i dodaj pierwszą grę, baza zostanie założona automatycznie.

4. **Nadaj uprawnienia do zapisu dla serwera www na katalog `database/`**
bash
sudo chown -R www-data:www-data database/
sudo chmod -R 755 database/
Uruchom aplikację w przeglądarce:


http://<adres-serwera>/graMY/index.php
lub użyj adresu demo (jeśli jest aktywny):
http://57.128.228.140/graMY/index.php

5. **Loginy startowe:
Możesz zarejestrować nowe konto (rola user), a pierwszego admina dodać ręcznie w bazie lub poprzez formularz rejestracji.
---

## 📦 Backlog, SCRUM i proces zwinny
Projekt tworzony w metodyce SCRUM (podział na sprinty: backlog, Sprint 1, Sprint 2, Sprint 3)

Każda funkcjonalność rozpisana w Jira — user stories, backlog, Sprint Review, DoD, dokumentacja zadań

Repozytorium GIT z historią commitów oraz pull requestami

---

## 🔒 Zabezpieczenia aplikacji
Walidacja i sanityzacja danych wejściowych (SQL Injection, XSS)

Sesje i role użytkowników — tylko zalogowany admin/worker ma dostęp do panelu administracyjnego

Obsługa wylogowania użytkownika (logout.php)

(Opcjonalnie do rozbudowy) — opisany mechanizm tokenów CSRF


---


## 📢 Literatura i inspiracje
https://php.net/

https://www.sqlite.org/

https://getbootstrap.com/

https://boardgamegeek.com/xmlapi/

Dokumentacja BoardGameGeek API

