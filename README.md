# Min Symfony-sida för MVC-kursen

![Webbplatsbild](https://www.student.bth.se/~irge24/dbwebb-kurser/mvc/me/report/public/img/php.jpg)

Detta är min egna `me/report`-sida i kursen **MVC**.  
SIdan är byggd med Symfony-ramverket och innehåller en enkel struktur med routing, controllers och templates.

---

## Scrutinizer - KMOM06

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/irge24/MVC/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/irge24/MVC/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/irge24/MVC/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/irge24/MVC/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/irge24/MVC/badges/build.png?b=main)](https://scrutinizer-ci.com/g/irge24/MVC/build-status/main)

[![Code Intelligence Status](https://scrutinizer-ci.com/g/irge24/MVC/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)


## Hur du klonar och kör projektet

Innan du börjar behöver du ha följande installerat på din dator:

- [PHP](https://www.php.net/) (version 8.1 eller senare)
- [Composer](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download)

---

### Klona mitt repo

Kör följande i terminalen

```bash
git clone https://github.com/irge24/MVC.git
cd MVC/me/report
```

---

### Starta servern

1. Stå i `MVC/me/report`-mappen:

```bash
cd MVC/me/report
```

2. Starta Symfony-servern på följande sätt i terminalen:

```bash
symfony server:start
```

3. Öppna webbläsaren och gå till:

```
http://127.0.0.1:8000
```

---

## 📄 Innehåll i repot och på min symfony-sida

Webbplatsen innehåller följande sidor:

1. **Startsida - Home** (`/`) – Förstasidan med min introduktion
2. **About** (`/about`) – Om kursen MVC
3. **Random number** (`/random`) – Visar ett slumpmässigt tal
4. **Report** (`/report`) – Redovisningstexter för alla kmom
5. **Card** (`/card`) – Kortlek
6. **Session** (`/session`) – Sessionen
7. **Game** (`/game`) – Spel med kort
8. **Library** (`/library`) – Databas bibliotek
9. **Metrics** (`/metrics`) – Metrics analys
10. **Project** (`/proj`) – Projekt Kmom10

Repot innehåller all kod för ovanstående sidor på Symfony, därtill kod
för JSON api-sidorna, klasser, metoder, controllers m.m. Alltså all kod för både frontend och backend. Repot innehåller också information och analyser av min kod och man kan exempelvis ta sig vidare till Scrutinizer via ovanstående badges, för att se mer av kodanalysen.
Repot finns för att representera och samla mitt arbete under kursen MVC - Objektorienterade webbteknologier på Blekinge Tekniska Högskola, under programmet Webbprogrammering distans 120 hp. Koden är från första kursmomentet, kmom01, till det sista kmom07/10, vilket är projektet.