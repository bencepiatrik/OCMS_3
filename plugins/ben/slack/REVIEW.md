# REVIEW

## Migrácie
php artisan october:migrate
toto ti zbehne migrácie, ktoré máš zapísané v version.yaml, kde ale momentálne nič nemáš, takže dáva zmysel že ti to nič nerobí, skús pridať migrácie takto

v1.0.1: First version of Slack
 - create_chats_table.php
 ...

## Importovanie
V routes.php si to opravil, ale opäť to vidím na nejakých iných miestach, napr. Message.php
Ak sa dá, tak VŽDY importuj redšej cez use alebo ::class namiesto importovania cez string

'Parent\Plugin\Class' -> use Parent\Plugin\Class alebo \Parent\Plugin\Class::class

## Relations
V modeloch máš takéto funkcie ktoré súvisia s relations

public function messages()
{
    return $this->hasMany('Ben\Slack\Models\Message', 'chat_id');
}

Využívaš ich niekde? Nemali by byť potrebné, skús vyskúšať či ich je treba, zo skúsenosti stačí keď relations zadefinuješ cez $hasMany, a pod.

## Other
Na niektoré REVIEW komenty si nereagoval, pls pozri to, a vždy keď niečo opravíš / upravíš pls vymaž ten comment s ktorým to súvisí
Pls prejdi si všetky REVIEW komenty, ak sú done tak ich vymaž
