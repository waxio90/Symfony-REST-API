# Symfony Docker REST API

## Wymagania systemowe:

    PHP 8.2
    Symfony6
    Baza danych (PostgreSQL)

## Instalacja:

1. Sklonuj repozytorium kodu.
2. Zainstaluj Docker Compose
3. Uruchom `docker compose build --pull --no-cache`
4. Uruchom `docker compose up -d`

## Endpointy:

### Firma

    GET /api/companies - pobierz listę firm
    POST /api/companies - dodaj nową firmę
    GET /api/companies/{id} - pobierz dane konkretnej firmy
    PUT /api/companies/{id} - zaktualizuj dane konkretnej firmy
    DELETE /api/companies/{id} - usuń konkretną firmę

### Pracownicy

    GET /api/companies/{id}/employees - pobierz wszystkich pracowników danej firmy
    POST /api/companies/{id}/employees - dodaj nowego pracownika dla danej firmy
    GET /api/companies/{id}/employees/{employeeId} - pobierz dane konkretnego pracownika dla danej firmy
    PUT /api/companies/{id}/employees/{employeeId} - zaktualizuj dane konkretnego pracownika dla danej firmy
    DELETE /api/companies/{id}/employees/{employeeId} - usuń konkretnego pracownika dla danej firmy

## Parametry

Wszystkie dane są przekazywane w formacie JSON.

### Przykładowe dane dla utworzenia nowej firmy:


    {
        "name": "Nazwa firmy",
        "nip": "1234567890",
        "address": "ul. Przykładowa 10",
        "city": "Kraków",
        "postalCode": "30-000"
    }

### Przykładowe dane dla utworzenia nowego pracownika:

    {
        "firstName": "Jan",
        "lastName": "Kowalski",
        "email": "jan.kowalski@example.com",
        "phone": "+48123456789"
    }
