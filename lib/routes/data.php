<?php
$router = new Router(BASE_URL . 'data');

$router
    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

    /*INSIDE TEMPERATURE*/

    ->post('/insideTemp:request', function(Response $res, $args) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getGateway()->getName() : "";
        $table = '.nodes.ambientSensor-1.objects.temperature.attributes.datapoint';
        $sqlFrom = "\"$dbName$table\"";

        $interval = empty($_POST["time"]) ? 0 : $_POST["time"];
        $range = empty($_POST["range"]) ? 0 : $_POST["range"];
        $offset = empty($_POST["offset"]) ? 0 : $_POST["offset"];
        $start = empty($_POST["start"]) ? 0 : $_POST["start"];
        $end = empty($_POST["end"]) ? 0 : $_POST["end"];

        $result = [$args];
        switch ($args["request"]) {
            case "Limit" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC LIMIT 100000 OFFSET '.$offset.';');
                break;
            case "All" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
            case "Speed" :
                $result = $database->query('SELECT LAST("value") FROM '.$sqlFrom.';');
                break;
            case "Date" :
                $result = $database->query('SELECT DISTINCT("value") FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' GROUP BY time('.$interval.') fill(null) ORDER BY time DESC ;');
                break;
            case "HistoryDate" :
                $result = $database->query('SELECT round(mean("value")) as "distinct" FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' AND value < 50 AND value >= 0 GROUP BY time('.$interval.') fill(none) ORDER BY time DESC tz(\'Europe/Zurich\');');
                break;
            case "Spec" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.$table.'" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
                break;
            case "SpecAll" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.$table.'" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
        }
        $res->send($result->getPoints());

        exit();
    })

    ->post('/insideTemp', function(Response $res) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT value FROM "'.$dbName.'.nodes.ambientSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    /* CONSUMPTION ELECT */

    ->post('/consumptionElect:request', function(Response $res, $args) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getGateway()->getName() : "";
        $table = '.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint';
        $sqlFrom = "\"$dbName$table\"";

        $interval = empty($_POST["time"]) ? 0 : $_POST["time"];
        $range = empty($_POST["range"]) ? 0 : $_POST["range"];
        //$offset = empty($_POST["offset"]) ? 0 : $_POST["offset"];
        $start = empty($_POST["start"]) ? 0 : $_POST["start"];
        $end = empty($_POST["end"]) ? 0 : $_POST["end"];

        $result = [$args];
        switch ($args["request"]) {
            case "All" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' GROUP BY time(7d) fill(none) ORDER BY time DESC ;');
                break;
            case "Speed" :
                $result = $database->query('SELECT LAST("value") FROM '.$sqlFrom.';');
                break;
            case "Date" :
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' GROUP BY time('.$interval.') fill(null) ORDER BY time DESC ;');
                break;
            case "HistoryDiff" :
                $result = $database->query('SELECT round(max(value)-min(value))/1000 as "distinct" FROM (SELECT last(value) as value FROM '.$sqlFrom.' WHERE time >= '.$start.' AND time <= '.$end.' GROUP BY time(1m) fill(linear) tz(\'Europe/Zurich\')) GROUP BY time('.$interval.') fill(none) ORDER BY time DESC tz(\'Europe/Zurich\');');
                break;
            case "Spec" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
                break;
            case "SpecAll" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
        }
        $res->send($result->getPoints());

        exit();
    })

    ->post('/consumptionElect', function(Response $res) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $offset = $_POST["offset"];
        $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_1_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC LIMIT 100000 OFFSET '.$offset.';');
        $res->send($result->getPoints());
    })

    /* PRODUCTION ELECT */

    ->post('/productionElect:request', function(Response $res, $args) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getGateway()->getName() : "";
        $table = '.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint';
        $sqlFrom = "\"$dbName$table\"";

        $interval = empty($_POST["time"]) ? 0 : $_POST["time"];
        $range = empty($_POST["range"]) ? 0 : $_POST["range"];
        $offset = empty($_POST["offset"]) ? 0 : $_POST["offset"];
        $start = empty($_POST["start"]) ? 0 : $_POST["start"];
        $end = empty($_POST["end"]) ? 0 : $_POST["end"];

        $result = [$args];
        switch ($args["request"]) {
            case "All" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
            case "Limit" :
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM '.$sqlFrom.' where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC LIMIT 100000 OFFSET '.$offset.';');
                break;
            case "Speed" :
                $result = $database->query('SELECT LAST("value") FROM '.$sqlFrom.';');
                break;
            case "Date" :
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' GROUP BY time('.$interval.') fill(null) ORDER BY time DESC ;');
                break;
            case "HistoryDiff" :
                $result = $database->query('SELECT round(max(value)-min(value))/1000 as "distinct" FROM (SELECT last(value) as value FROM '.$sqlFrom.' WHERE time >= '.$start.' AND time <= '.$end.' GROUP BY time(1m) fill(linear) tz(\'Europe/Zurich\')) GROUP BY time('.$interval.') fill(none) ORDER BY time DESC tz(\'Europe/Zurich\');');
                break;
            case "Spec" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
                break;
            case "SpecAll" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
        }
        $res->send($result->getPoints());

        exit();
    })

    ->post('/productionElect', function(Response $res) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.'.nodes.SmartMeterTechnical.objects.obis_1_0_2_7_0_255_2.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
        $res->send($result->getPoints());
    })

    /* CONSUMPTION HEAT PUMP */

    ->post('/consumptionHeatPump:request', function(Response $res, $args) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getGateway()->getName() : "";
        $powerMeter = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getHeatPowerMeter() : Installation::getByGateway($_POST['idGateway'])->getHeatPowerMeter();
        $table = ".nodes.powerMeter-$powerMeter.objects.wattsTotal.attributes.datapoint";
        $sqlFrom = "\"$dbName$table\"";

        $interval = empty($_POST["time"]) ? 0 : $_POST["time"];
        $range = empty($_POST["range"]) ? 0 : $_POST["range"];
        $offset = empty($_POST["offset"]) ? 0 : $_POST["offset"];
        $start = empty($_POST["start"]) ? 0 : $_POST["start"];
        $end = empty($_POST["end"]) ? 0 : $_POST["end"];

        $result = [$args];
        switch ($args["request"]) {
            case "All" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
            case "Speed" :
                $result = $database->query('SELECT LAST("value") FROM '.$sqlFrom.';');
                break;
            case "Date" :
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' GROUP BY time('.$interval.') fill(null) ORDER BY time DESC ;');
                break;
            case "Spec" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
                break;
            case "SpecAll" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value")/1000 FROM "'.$dbName.$table.'" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
        }
        $res->send($result->getPoints());

        exit();
    })

    ->post('/consumptionHeatPump', function(Response $res) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $powerMeter = getHeatPowerMeter($_SESSION["User"]);
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $offset = $_POST["offset"];
        $result = $database->query('SELECT DISTINCT("value")/1000 as "distinct" FROM "'.$dbName.'.nodes.powerMeter-'.$powerMeter.'.objects.wattsTotal.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(0) ORDER BY time DESC LIMIT 100000 OFFSET '.$offset.';');
        $res->send($result->getPoints());
    })

    /* HOTWATER */

    ->post('/hotwaterTemperature:request', function(Response $res, $args) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getRole()->getId() == 4 ? $_SESSION["User"]->getInstallations()[0]->getGateway()->getName() : "";
        $table = '.nodes.boilerSensor-1.objects.temperature.attributes.datapoint';
        $sqlFrom = "\"$dbName$table\"";

        $interval = empty($_POST["time"]) ? 0 : $_POST["time"];
        $range = empty($_POST["range"]) ? 0 : $_POST["range"];
        $offset = empty($_POST["offset"]) ? 0 : $_POST["offset"];
        $start = empty($_POST["start"]) ? 0 : $_POST["start"];
        $end = empty($_POST["end"]) ? 0 : $_POST["end"];

        $result = [$args];
        switch ($args["request"]) {
            case "Limit" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC LIMIT 100000 OFFSET '.$offset.';');
                break;
            case "All" :
                $result = $database->query('SELECT DISTINCT value FROM '.$sqlFrom.' GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
            case "Speed" :
                $result = $database->query('SELECT LAST("value") FROM '.$sqlFrom.';');
                break;
            case "Date" :
                $result = $database->query('SELECT DISTINCT("value") FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' GROUP BY time('.$interval.') fill(null) ORDER BY time DESC ;');
                break;
            case "HistoryDate" :
                $result = $database->query('SELECT round(mean("value")) as "distinct" FROM '.$sqlFrom.' where time >= '.$start.' AND time <= '.$end.' AND value < 120 AND value >= 30 GROUP BY time('.$interval.') fill(none) ORDER BY time DESC tz(\'Europe/Zurich\');');
                break;
            case "Spec" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.$table.'" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY "time" DESC ;');
                break;
            case "SpecAll" :
                $dbName = (new Gateway($_POST['idGateway']))->getName();
                $result = $database->query('SELECT DISTINCT("value") FROM "'.$dbName.$table.'" GROUP BY time(1d) fill(none) ORDER BY time DESC ;');
                break;
        }
        $res->send($result->getPoints());

        exit();
    })

    ->post('/hotwaterTemperature', function(Response $res) {
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $interval = $_POST["time"];
        $range = $_POST["range"];
        $result = $database->query('SELECT DISTINCT("value") as "distinct" FROM "'.$dbName.'.nodes.boilerSensor-1.objects.temperature.attributes.datapoint" where time >= now()-'.$range.' GROUP BY time('.$interval.') fill(none) ORDER BY time DESC ;');
        $res->send($result->getPoints());
    })

    /* Counter */

    ->post('/counterConsumption1', function (Response $res){
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_1_8_1_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterConsumption2', function (Response $res){
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_1_8_2_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterProduction1', function (Response $res){
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_2_8_1_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    })

    ->post('/counterProduction2', function (Response $res){
        $database = Configuration::InfluxDB();
        $dbName = $_SESSION["User"]->getInstallations()[0]->getGateway()->getName();
        $result = $database->query('SELECT LAST("value") FROM "'.$dbName.'.nodes.SmartMeterBilling.objects.obis_1_1_2_8_2_255_2.attributes.datapoint";');
        $res->send($result->getPoints());
    });