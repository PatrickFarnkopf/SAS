<?php


/**
* Licensed under The Apache License
*
* @copyright Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
* @link https://github.com/pataga/SAS
* @since SAS v1.0.0
* @license Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt
* @author Patrick Farnkopf
*
*/

class Main {

    private $mysql_data, $mysql, $db, $result, $server, $ssh, $user, $tableaction, $loader, $logFile, $debugLevel;

    public function __construct($data=false, $debugLevel=2, $logFile='error.log') {
        $this->debugLevel = $debugLevel;
        $this->logFile = $logFile;
        if (!$data) {
            throw new Exception("Fehler in ./includes/config/config.mysql.php");
        } else {
            $this->mysql_data = $data;
            $this->initialisizeInstances();
        }
    }


    /**
     * Initialisiert Objekte der Hauptklassen
     */
    private function initialisizeInstances() {
        try {
            $this->debug = new Debug($this->debugLevel, $this->logFile);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        try {
            $this->mysql = new MySQL($this,$this->mysql_data[0], 
            $this->mysql_data[1], $this->mysql_data[2], 
            $this->mysql_data[3], $this->mysql_data[4]);    
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        try {
            $this->loader = new Loader($this);
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        try {
            $this->user = new User($this);
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        try {
            $this->server = new Server($this);
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        try {
            $this->database = new Database($this);
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        try {
            $this->cache = new Cache($this);
        } catch (Exception $e) {
            $this->debug->error($e);
        }

        $this->ssh = $this->setSSHInstance();
    }

    /**
     * Erstellt SSH Instanz
     * @return SSH ssh [SSH Instanz]
     */
    private function setSSHInstance() {
        try {
            if (isset($_SESSION['server_id'])) {
                $this->server->setID($_SESSION['server_id']);
                $data = $this->server->getServerData();

                if (!is_array($data))
                    throw new Exception("unable to find data of ssh daemon in Main::setSSHInstance()", 1);

                return new SSH($this,$data[0],22,$data[1],$data[2]);
            } else {
                return NULL;
            }
        } catch (Exception $e) {
            $this->debug->error($e);
        }
    }

    public function getServerInstance() { return $this->server; }
    public function getSSHInstance() { return $this->ssh; }
    public function getMySQLInstance() { return $this->mysql; }
    public function getUserInstance() { return $this->user; }
    public function getDatabaseInstance() { return $this->database; }
    public function getLoaderInstance() { return $this->loader; }
    public function getDebugInstance() { return $this->debug; }
    public function getCacheInstance() { return $this->cache; }


    public static function printLoadTime($startTime, $endTime) {
        try {
            if (!is_float($startTime) || !is_float($endTime)) {
                throw new Exception('', 5);
            } else {
                $totalTime = $endTime - $startTime;
                $outStr = sprintf('<p class="loadtime">Seite wurde in %s Sekunden generiert</p>',round($totalTime,3));
                print($outStr);
            }
        } catch (Exception $e) {
            //$this->debug->logInfo('Fehler beim Berechnen der Ladezeit');
        }
    }
}

?>