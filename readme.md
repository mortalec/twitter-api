Úvod
=================

Twitter-api je jednoduché API, které vrátí 100 nejnovějších tweetů dle konfigurace. Aplikace je rozdělená na dvě části. Hlavní stránka (example.com/) pro jednoduchý grafický výpis a API, které vrací JSON formát příspěvků (example.com/api).

Požadavky
------------

- PHP 7.2
- Composer

Instalace
------------

Spusťte následující přikazy v terminálu.
```
> composer install
```

Použití
=================

### Povolené HTTP requesty

`GET`, `POST`

### Popis obvyklých odpovědí API

- `200 OK` – Požadavek proběhl v pořádku.

### Parametry requestu / konfigurace

Request neočekává žádné parametry. 
Konfigurace se prování pouze v souboru `www/searchQuery.txt`, kde jsou vypsána klíčová slova oddělená čárkou, která musí tweety obsahovat.

### Struktura odpovědi

Odpověď API je výpis jednotlivých tweetů ve formátu JSON, s následujícími prvky:
- `createdAt` – Datum tweetu.
- `text` – Textový obsah tweetu.
- `userName` – Jméno uživatele.
- `userScreenName` – Zkrácené jméno uživatele (např. pro odkaz na profil uživatele atd.)
- `favorites` – Počet lajků.
- `retweets` – Počet retweetů.
- `link` – Odkaz na tweet.

### Příklad

Chci najít tweety obsahující následující slova/hashtagy: #pilulka, #pilulka.cz, #pilulkacz, pilulka.cz, pilulka a pilulkacz. 

Obsah souboru `www/searchQuery.txt` tedy mám `#pilulka,#pilulka.cz,#pilulkacz,pilulka.cz,pilulka,pilulkacz`

Odkážu se na
`example.com/api`

Výsledek:
```json
[
  {
    "createdAt": "2021-02-19T11:11:08+01:00",
    "text": "@OSPraha https://t.co/i0II5i8Doz :)",
    "userName": "Nika Zubritskaya 🤍♥️🤍",
    "userScreenName": "nikakeda",
    "favorites": 1,
    "retweets": 0,
    "link": "https://twitter.com/nikakeda/status/1362706274035658753"
  },
  {
    "createdAt": "2021-02-19T10:15:17+01:00",
    "text": "@nerudovad @tomcuprcz To spíš @Pilulkacz ? @petrkasa @martin_kasa",
    "userName": "David Andreatta",
    "userScreenName": "Dav_Andreatta",
    "favorites": 0,
    "retweets": 0,
    "link": "https://twitter.com/Dav_Andreatta/status/1362692220177035264"
  },
  {
    "createdAt": "2021-02-18T23:25:10+01:00",
    "text": "@Jan_Svancara No, u nás to taky houstne. Nás,  lékárníky, verbuje Pilulka. cz na zajišťování a prodej robertků a dalšího erotického zboží. Svět se zbláznil, ale Vaše kamera a pak to lano v komentářích mě vrátilo humor.",
    "userName": "Lenka Tulachová",
    "userScreenName": "LTulachova",
    "favorites": 1,
    "retweets": 0,
    "link": "https://twitter.com/LTulachova/status/1362528613963345921"
  },
  {
    "createdAt": "2021-02-18T21:50:06+01:00",
    "text": "@martin_kasa @_invalid_error_ @PiratIvanBartos @Pilulkacz Je to tak. Ono to je nejen vláda, ale i úřady. Vše dělají nesmyslně komplikovaně a komplexně. Namísto řešení, co by pokrylo 80 % problému a lze vyřešit za dva dny.",
    "userName": "Jakub Šulák",
    "userScreenName": "SulakJakub",
    "favorites": 0,
    "retweets": 0,
    "link": "https://twitter.com/SulakJakub/status/1362504689447755786"
  }
]

...
```

## Využité postupy, zdroje a knihovny

### Knihovny / framework

- [Nette](https://nette.org/)
- [Bootstrap](https://getbootstrap.com/)

### Postupy a zdroje

K získání tweetů se používá Twitter API metoda [GET search/tweets](https://developer.twitter.com/en/docs/twitter-api/v1/tweets/search/api-reference/get-search-tweets).

Pro autorizaci zde používám bearer token odeslaný v hlavičce requestu. Pak se jednoduše naskládají potřebné parametry do URL a požadavek se odešle.



