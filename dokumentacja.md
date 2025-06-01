# 📖 Dokumentacja projektu "GraMY i Oddamy"

---

## 1. Opis projektu

**"GraMY i Oddamy"** to aplikacja webowa do zarządzania wypożyczalnią gier planszowych, stworzona w ramach przedmiotu *Zwinne Metodyki Wytwarzania Oprogramowania* (metodyka SCRUM).

Projekt umożliwia rejestrację i przechowywanie gier, wypożyczanie i zwroty, masowy import i eksport, a także automatyczne pobieranie danych o grach z zewnętrznego API (BoardGameGeek).

---

## 2. Architektura projektu

- **Backend:** PHP 8 + SQLite3
- **Frontend:** PHP (HTML5), Bootstrap 5 (CDN, nowoczesny responsywny wygląd)
- **Baza danych:** SQLite3, plik `database/games.db`
- **API:** BoardGameGeek XML API (pobieranie danych o grach przez plik `bgg_proxy.php`)
- **Import/eksport:** pliki JSON (pełny backup i migracja danych)
- **Repozytorium:** [GitHub](https://github.com/Mariosss93/GraMY-i-OddaMY)

---

## 3. Sprint 1

**Cel Sprintu:**  
Stworzenie bazowej wersji systemu wypożyczalni z możliwością dodawania, edycji, usuwania, przeglądania i wypożyczania gier.

**Zrealizowane zadania:**
- Utworzenie repozytorium na GitHub i projektu w Jira (backlog, sprint planning)
- Zaprojektowanie i stworzenie bazy danych (SQLite, tabela `games`)
- Implementacja CRUD:
  - Dodawanie gry do bazy (formularz)
  - Edycja gry
  - Usuwanie gry (z potwierdzeniem)
  - Przeglądanie listy gier (z tabelą, sortowanie)
- Wypożyczanie i zwracanie gier (zmiana statusu "dostępna"/"wypożyczona")
- Obsługa wyjątków i prostych walidacji
- Publikacja działającej aplikacji na VPS
- Zabezpieczenie bazy przed dostępem z zewnątrz
- Dokumentacja zadań i realizacji w Jira

**Rezultaty Sprintu 1:**
- System działa poprawnie na VPS
- Każdy użytkownik może przeglądać, dodać, edytować, usunąć lub wypożyczyć grę
- Repozytorium oraz backlog projektowy jest na bieżąco aktualizowany

---

## 4. Sprint 2

**Cel Sprintu:**  
Dodanie importu i eksportu danych (JSON), automatycznego pobierania informacji o grach z BoardGameGeek oraz wdrożenie nowoczesnego wyglądu (Bootstrap).

**Zrealizowane zadania:**
- Implementacja eksportu gier do pliku JSON
- Implementacja importu gier z pliku JSON (upload, walidacja)
- Integracja z API BoardGameGeek:
  - Automatyczne pobieranie opisu, liczby graczy, minimalnego wieku (proxy PHP)
  - Wypełnianie formularza na podstawie danych z API
- Nowoczesny interfejs użytkownika (Bootstrap 5):
  - Responsywne tabele
  - Czytelne formularze, buttony, alerty
  - Kolorowe statusy wypożyczenia
- Usprawnienia UX (przyciski, potwierdzenia, alerty)
- Poprawki walidacji i zabezpieczeń (htmlspecialchars, kontrola typów)
- Rozbudowa dokumentacji (README.md, INSTALL.md)
- Uzupełnienie zadań w Jira (historia sprintu, zadania, review)

**Rezultaty Sprintu 2:**
- System posiada profesjonalny wygląd, działa na urządzeniach mobilnych
- Użytkownik może masowo przenosić dane (import/eksport)
- Dodawanie nowych gier zostało zautomatyzowane dzięki API BGG
- Całość kodu, dokumentacji i historii rozwoju dostępna na GitHub

---

## 5. Podsumowanie technologiczne i zalecenia

**Technologie:**  
- PHP 8  
- SQLite3  
- Bootstrap 5  
- BoardGameGeek XML API  
- Git, GitHub

**Minimalne wymagania uruchomienia:**  
- Serwer WWW (np. Apache2)
- PHP z obsługą SQLite3
- Uprawnienia do zapisu w katalogu bazy
- Dostęp do internetu (dla API BGG)

**Najważniejsze cechy projektu:**  
- Skalowalność (możliwość dalszej rozbudowy — np. o konta użytkowników, stany magazynowe, rezerwacje)
- Nowoczesny frontend
- Łatwy deployment na VPS (pełna instrukcja w pliku `INSTALL.md`)
- Czytelna dokumentacja i historia zadań

---

## 6. Załączniki

- `README.md` — instrukcja obsługi
- `INSTALL.md` — instrukcja wdrożenia na VPS



