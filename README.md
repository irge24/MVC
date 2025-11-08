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

## 📄 Innehåll på min symfony-sida

Webbplatsen innehåller följande sidor:

1. **Startsida** (`/`) – Förstasidan med min introduktion
2. **About** (`/about`) – Om kursen MVC
3. **Report** (`/report`) – Redovisningstexter under kursens gång
4. **Random number** (`/random`) – Visar ett slumpmässigt tal
