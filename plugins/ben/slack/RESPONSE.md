## composer.json
Najprv som nesprávne importoval Http\Request, nie z Illuminate\Http\Request, ale z iného zdroja, a musel som pridať správny riadok do composeru, aby to fungovalo. Nakoniec som na to zabudol a nechal som to tam.

## Class importing
Nevšimol som si, že neimportujem triedy podľa štandardu, ale odteraz si na to dávam pozor.

## Migracie
Databázové migrácie mi stále nefungujú cez october:up/down ani october:migrate, a preto používam Laravel príkaz php artisan migrate --path=plugins/ben/slack/updates/.
