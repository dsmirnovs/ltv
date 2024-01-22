# LTV uzdevums
Pārbaudes uzdevums: Vecākā programmētāja (Backend) - Uzdevums (2. Variants), izmantojot tehnoloģijas: Laravel + MySql.

# Instalēšana
1. [x] Lejupielādēt projektu ar **git clone** palīdzību
2. [x] Nokopet .env.example failu, ka .env
3. [x] Konfiguracijas failā [.env] pievienot **TV_API_KEY**:
   TV_API_KEY=T7P1dBaxuhQXJyxCiDBOEfBRTyyYuK3Jkl2hXFqBvfeFmH0CksFNYP7iaOiBKNx5
      - Jus varat noģenerēt atslegu patstāvīgi, bet tad pievienota postman kolekcija nestrādās<br />(Šajā gadījumā vajadzēs samainīt x-api-key in header).
4. [x] Konfiguracijas failā samainīt datu bāzes piekļuvi:<br />
      DB_HOST=mysql<br />
      DB_USERNAME=sail<br />
   DB_PASSWORD=password<br />
5. [x] Palaist dokeri savā datorā
6. [x] Projeka saknē uzinstallet nepieciesamas pakotnes: **composer install** <br />(komposerim jābūt instalētam datorā)
7. [x] Izpildīt **docker-compose up -d** , lai palaist konteinerus
8. [x] Palaist: **docker exec -it ltv-laravel.test-1 php artisan migrate:fresh --seed**
   9. Tas noinstalles nepieciešamas tabulas un aizpildīs channel tabulu. (Uzdevuma es ieraudzēju attiecibas one-> to many tāpēc man ir 2 tabulas, un vienai ir jābūt aizpildītaj)
9. [x] Sākt sadarbību ar API - http:/localhost:80

# Darbs ar datu bāzi
Izmantota datubāze: mysql Ver 8.0.32

Sadarboties ar datu bāzi iespejams iekša konteinerī ltv-mysql-1:
**docker exec -it ltv-mysql-1 mysql -uroot -p**;  parole: password.

Darbam ar tabulām jāizvēlas datubāzi example_app: **USE example_app;**

# Darbs ar API
API piemēri ir aprakstīti Postman kolekcijas failā: **LTV_test_task.postman_collection.json**

Notice: When testing an API locally, you need to use the Postman Desktop Agent. Safari doesn’t support the desktop agent.

**Apraksts:** 

/api/addProgram - ļauj pievienot jaunu programmas ierakstu.

/api/guide/{channel_nr}/{date} - kurš atgriež visu TV programmu konkrētajām kanāla nummuram un datumam sakārtotu no sākuma laika līdz beigu laikam augošā secībā.

/api/on-air/{channel_nr} - kurš atgriež vienu ierakstu kurš šobrīd ir ēterā konkrētajā kanālā.

/api/upcoming/{channel_nr} - kurš atgriež tuvākos 10 programmas ierakstus konkrētajām kanāla nummuram, ieskaitot to, kurš šobrīd ir ētērā.

P.S. visiem pieprasījumiem jānorāda api key

# Testu palaišana
Palaist testu var ar sekojošo komandu: **docker exec -it ltv-laravel.test-1 php artisan test**

# Izmantotas versijas:
Laravel Version - 10.41.0

PHP Version - 8.3.1

# Izmantotas pakotnes:
-phpstan
