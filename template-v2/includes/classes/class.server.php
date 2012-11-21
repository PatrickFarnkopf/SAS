<?php
	class Server
	{
		private $server_id;
		private $server_host;
		private $server_user;
		private $server_pass;

		private $server_mysql_host;
		private $server_mysql_port;
		private $server_mysql_user;
		private $server_mysql_pass;

		function setServerHost ($host)
		{
			$this->server_host = $host;
		}

		function setServerUser ($user)
		{
			$this->server_user = $user;
		}

		function setServerPass ($pass)
		{
			$this->server_pass = $pass;
		}

		function getServerID ()
		{
			$result = mysql_query("SELECT id FROM sas_server_data WHERE host = '$this->server_host' AND user = '$this->server_user'");

			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_object($result);
				$this->server_id = $row->id;
			} else $this->server_id = -1;
		}

		function isInstalled ($package)
		{
			$result = mysql_query("SELECT * FROM sas_server_data WHERE id = $this->server_id");

			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_object($result);

				switch ($package)
				{
					case 'mysql': if ($row->mysql == "1") return true; break;
					case 'postfix': if ($row->postfix == "1") return true; break;
					case 'ftp': if ($row->ftp == "1") return true; break;
					case 'samba': if ($row->samba == "1") return true; break;
					case 'apache': if ($row->apache == "1") return true; break;
					default: return false;
				}
			}

			return false;
		}

		function getMySQLData ()
		{
			if ($this->isInstalled("mysql"))
			{
				$result = mysql_query("SELECT * FROM sas_server_mysql WHERE id = $this->server_id");

				if (mysql_num_rows($result) > 0)
				{
					$this->server_mysql_host = $row->host;
					$this->server_mysql_port = $row->port;
					$this->server_mysql_user = $row->username;
					$this->server_mysql_pass = $row->password;
					return true;
				}
			}
			
			return false;
		}
	}
?>