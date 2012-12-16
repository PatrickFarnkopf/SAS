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


class SSH {

    private $_host;
    private $_port;
    private $_user;
    private $_pass;
    private $_connection;
    private $_out;

   /**
    * @param String Host
    * @param int Port
    * @param String Benutzername
    * @param String Passwort
    */
    public function __construct($host = '', $port = '', $user = '', $pass = '') {
        if (!empty($host))
            $this->_host = $host;
        if (!empty($port))
            $this->_port = $port;
        if (!empty($user))
            $this->_user = $user;
        if (!empty($pass))
            $this->_pass = $pass;
    }


   /**
    * Öffnet Verbindung zum SSH Daemon und authentifiziert sich
    * @param void
    */
    public function openConnection() {
        $this->_connection = ssh2_connect($this->_host, $this->_port);
        if (!$this->_connection)
            throw new Exception('SSH Connection failed');
        if (!ssh2_auth_password($this->_connection, $this->_user, $this->_pass))
            throw new Exception('SSH Autentication failed');
    }


   /**
    * Führt einen Befehl über die SSH Verbindung aus
    * @param String 
    * @param int
    * @return String/String[]
    */
    public function execute($command, $type = 0) {
        $output = "";
        if (!($os = ssh2_exec($this->_connection, $command, "bash")))
            throw new Exception('SSH command failed');

        stream_set_blocking($os, true);

        $data = array();

        if ($type == 2) {
            for ($i = 0; $line = fgets($os); $i++) {
                flush();
                $data[$i] = $line;
            }
            return $data;
        } else {
            while ($line = fgets($os)) {
                flush();
                $output .= $line . ($type == 1 ? '<br>' : '');
            }
        }

        return $output;
    }

}
?>
