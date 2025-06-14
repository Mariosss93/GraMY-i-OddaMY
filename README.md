# 🎲 GraMY i Oddamy — Biblioteka Gier Planszowych

Projekt zaliczeniowy na przedmiot **Zwinne Metodyki Wytwarzania Oprogramowania**  
Autorzy: Mariusz Pawlak, Bartłomiej Kajetan Paszko

---

## 📋 **Opis projektu**

Aplikacja webowa do zarządzania biblioteką gier planszowych z funkcją wypożyczania, importu/eksportu danych, oraz integracją z BoardGameGeek API (BGG).

- **Frontend:** PHP + Bootstrap 5 (nowoczesny wygląd, responsywność)
- **Backend:** PHP 8, SQLite3
- **Repozytorium:** [github.com/Mariosss93/GraMY-i-OddaMY](https://github.com/Mariosss93/GraMY-i-OddaMY)
- **Demo:** http://57.128.228.140/graMY/index.php

---

## 🛠️ **Główne funkcje**

- Dodawanie, edycja i usuwanie gier (CRUD)
- Przeglądanie szczegółów gry
- Wypożyczanie i zwracanie gier (zmiana statusu)
- Integracja z BoardGameGeek (BGG) API — automatyczne pobieranie danych o grach (opis, liczba graczy, wiek) przez proxy PHP
- Eksport danych do pliku JSON
- Import danych z pliku JSON (upload i masowy import)
- Nowoczesny frontend (Bootstrap 5)
- Obsługa wyjątków i komunikatów błędów

---

## 💡 **Technologie i wymagania**

- PHP 8
- SQLite3 (baza w katalogu `database/games.db`)
- Bootstrap 5 (CDN, nie trzeba instalować)
- BoardGameGeek XML API + własny serwis proxy (`bgg_proxy.php`)

---

## ⚙️ **Jak uruchomić projekt**

1. Sklonuj repozytorium lub wrzuć pliki na serwer/VPS z PHP i SQLite
2. Upewnij się, że masz katalog `database/` z plikiem `games.db` (struktura generowana automatycznie lub wg migracji)
3. Otwórz w przeglądarce: `http://adres-serwera/graMY/index.php`

---

## 🚀 **Backlog i zwinny proces**

- **SCRUM, Jira**: podział na Sprint 1 (CRUD, baza, podstawy, wypożyczanie), Sprint 2 (import/eksport, integracja BGG, nowoczesny frontend)
- Każda funkcjonalność w Jira — backlog, Sprint Review, dokumentacja zadań
- Repozytorium z historią commitów

---

## 🧑‍💻 **Autorzy**

- **Mariusz Pawlak** [github.com/Mariosss93](https://github.com/Mariosss93)
- **Bartłomiej Kajetan Paszko**


