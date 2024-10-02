# REVIEW

## General
Celkovo mi príde že robíš veci inak, alebo ich vôbec nerobíš oproti levelu 2
Nie som si istý prečo, ak to má nejaký dôvod, ktorý by si chcel rozoberať tak daj vedieť, ale každopádne v kóde spomínam v komentoch konkrétne veci, niektoré spomínam tu v REVIEW.md
Čo je ale fajn že si správne pochopil dátovú štruktúru, a tým myslím to ako si spravil migrácie, aj keď version.yaml trochu nerozumiem prečo tie migrácie nie sú
Potom sú tu relations, ale to by som prebral keď opravíme veci čo spomínam v tomto review

Pozri čo píšem v tomto review, na rôznych miestach sa pýtam, ale celkovo môžeme to riešiť na slacku, keď tak len pofixuj čo spomínam

## composer.json
v composer.json máš toto v require blocku
"ext-http": "*"
Pridával si to manuálne? Ak hej tak prečo?

## Class importing
Na viacerých miestach v kóde používaš namiesto importovania cez 'use' importovanie cez string
čiže napr. 'Ben\Slack\Models\Chat'
V routes.php som to spomenul podrobnejšie, ale deje sa to na viacerých miestach

## Controllers
Aktuálne to máš urobené tak že logika pre endpointy sa deje v controlleroch, čo je dobré, ale existujú 2 typy controller a je treba ich rozlišovať
Prvý typ je OCMS admin area controller, to sú controlleri ktoré sú zodpovedné za spravovanie logiky v admin area, čiže napr. na akej url sa nachádza list pre userov a pod.
Druhý typ je HTTP controller, ktorý by mal mať logiku ktorá sa deje v endpointch

Momentálne ich máš pre každý model ako keby zlúčené v jednom controlleri, napr. ChatController.php
Tento controller obsahuje OCMS logiku pre form a list, ale zároveň v ňom máš svoju custom logiku pre endpointy
Malo by to byť oddelené, čiže v controllers/ sú OCMS a v http/controllers/ sú HTTP controlleri
To čo sa vygeneruje commandom php artisan create:controller ostáva v controllers/ a to čo tvoríš ty patrí do http/controllers/
Daj vedieť či to dáva zmysel
