
# Laravel Examen – Canada Trip Planner

Je bouwt een Laravel-toepassing waarin gebruikers een uitstap (trip) in Canada kunnen kiezen en een boeking kunnen aanvragen. We focussen in dit geval op het headless admin-gedeelte voor de reisorganisate, en dus niet op de website voor de eindgebruiker.

Het aanbod van dit project bestaat uit uitstappen, niet noodzakelijk hele vakanties. Denk bijvoorbeeld aan:

	- Off-Grid Camping in Jasper (6 dagen, C$:1234,56)
	- Surf & Storm in Tofino (2 dagen, C$:123,56)
  - Paddle & Camp in Algonquin – Kanoën tussen elanden en sterrenhemel (5 dagen, C$:1234,56)
  - Underground Montréal – Jazz, street art en de beste poutine (2 dagen, C$:123,56)
  - Skylines & Squirrels in Toronto (2 dagen, C$:123,56)
	- Northern Light Hunting in Yellowknife (4 dagen, C$:2345,56)
	- Whales & Waves in Tadoussac (1 dag, C$:99,99)
	- ...


Je maakt gebruik van:

- Models, Migrations, Seeders, Factories, Controllers  
- Eloquent relaties  
- API met validatie  
- Blade voor overzicht  

Er zal bij het evalueren extra aandacht besteed worden aan correct gebruik van het laravel framework / MVC-approach.

Je werkt zoals steeds voor de klant. Je hoeft voor deze opdracht echter geen authorisatie / login te voorzien tenzij anders aangegeven.

---

## Wat moet je maken?

### 1. MODELS

Gebruik **exact** deze modelnamen en velden:

#### Trip

`id` : automatisch
`title` : verplicht
`region` : verplicht: `west`, `east`, `north`, `central`
`start_date` : verplicht
`duration_days` : verplicht, min. 1
`price_per_person` : verplicht, groter dan 0

#### Booking

`id` : automatisch
`trip_id` : verplicht
`name` : verplicht
`email` : verplicht
`number_of_people` : verplicht, min. 1
`status` : waarden: `pending` (standaard), `confirmed`, `cancelled`

**Relaties:**

Een trip kan logischerwijze meerdere bookings hebben en een booking moet steeds een geldige trip_id hebben.

---

### 2. SEEDING & FACTORIES

- Gebruik factories om:
  - **6 Trips** aan te maken (minstens 1 per regio's) die een toekomstige `start_date` hebben
  - **minstens 4 Bookings per Trip met verschillende status**
  - **realistische dummy data te voorzien**

Zorg ervoor dat het **exacte** commando `php artisan migrate:fresh --seed` werkt om alle data te voorzien.

---

### 3. API Endpoints

#### 3.2 Trips ophalen

**Route:**  
`GET /api/trips`

**Verwachte JSON-response:**
 
```json
[{
  "id": 1,
  "title": "Off-Grid Camping in Jasper",
  "region": "west",
  "start_date": 2025-07-01,
  "duration_days": 6,
  "price_per_person": 1234.56,
},
...
]
```


#### 3.2 Booking Aanvragen

**Route:**  
`POST /api/bookings`

**Verwachte JSON-body:**

```json
{
  "trip_id": 1,
  "name": "Jane Doe",
  "email": "jane@example.com",
  "number_of_people": 3,
  "token": "2b615be78cf18a80066ec15d08663b17"
}
```

**Meer info over deze request:**

| Parameter           | Vereisten                                                            |
|---------------------|----------------------------------------------------------------------|
| `trip_id`           | Bestaat als `id` in `trips` tabel                                    |
| `name`              | Niet leeg                                                            |
| `email`             | Geldig e-mailadres                                                   |
| `number_of_people`  | Integer ≥ 1                                                          |
| `token`             | Exact gelijk aan `md5(email + 'canadarocks')`                        |


**Business logica:**

- `status` wordt niet meegestuurd, deze is automatisch `pending`
- Response: JSON met de aangemaakte booking (statuscode `201`)
- Bij foutieve input: statuscode `422` met duidelijke foutboodschappen
- Indien token `token` niet meegestuurd: statuscode `401` met duidelijke foutboodschap
- Indien token `token` niet correct is: statuscode `403` met duidelijke foutboodschap

PS: voor de duidelijkheid: Voor de waarde van `token` moet je dus hetzelfde e-mailadres als je in dezelfde request doorstuurt, samenvoegen met de string "canadarocks" en daar de MD5 value van berekenen.

---

### 4. Blade Interface – `/trips`

Toon een tabel van alle trips:

- gesorteerd per datum, oplopend!
- Per trip:
  - Regio
  - Titel
  - Start date
  - Duur (in dagen)
  - Aantal confirmed bookings
  - Aantal pending bookings
  - Aantal canceled bookings
  - Totale omzet = `price_per_person * aantal personen (met status confirmed)`

---

Succes!!