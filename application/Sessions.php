<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
Class defined in order to manage access to the page. Manage login, session and cookies
**/

class Sessions{
	
		public function __construct()
		{
			$this->CI =& get_instance();
			date_default_timezone_set('Europe/Madrid');
		}
		
		///Public		
		public function setSession($id)
		{
			set_cookie("loged_user", $id, 2592000);
			set_cookie("last_login", time(), 2592000);
			return $id;
		}
		
		public function renewSession($id){
			if ($id == -1)
				return;
			$lastLogin = get_cookie("last_login");
			if ($lastLogin > time() + 86400)
			{
				set_cookie("loged_user", $id, 2592000);
				set_cookie("last_login", time(), 2592000);
			}
		}
		
		public function checkCountry($ip)
		{
			///This variable is to define spanish countries. It can change
			$spanishCountries = "AD;AR;BO;CL;CO;CU;DO;DM;EC;GT;HN;MX;PA;PY;PE;PR;ES;VE;";
			///
			$error = -1;
			$from = get_cookie("from");
			if ($from === NULL)
			{
				//IP to numeric format
				$longIP = $this->ip2long($ip);
				print_r($longIP);
				//check database to know location
				$this->CI->load->model('frontends');
				$country = $this->CI->frontends->getCountry($longIP);
				//if spanish speaker country, set cookie
				if (strpos($spanishCountries,$country) !== FALSE)
				{
					set_cookie("from","ES",2592000);
					$error = 0;
				}
			}
			else
			{
				set_cookie("from","ES",2592000);
				$error = 0;
			}
			
			return $error;
		}
		
		public function checkSession()
		{
			$error = -1;
			$id = get_cookie("loged_user");
			if ($id != NULL)
			{
				return $id;
			}
			
			return $error;
		}
		
		public function destroySession()
		{
			$error = 1;
			delete_cookie("loged_user");
			delete_cookie("last_login");
		}

		///Private
		private function ip2long($IP)
		{
			$d = 0.0;
			$b = explode(".",$IP,4);
			if (count($b) <= 1)
			{
				$d = $this->IPv6ToLong($b[0]);
			}
			else
			{
				for ($i = 0; $i < 4; $i++) {
					$d *= 256.0;
					$d += $b[$i];
				};
			}
			return $d;
		}
		
		private function ExpandIPv6Notation($Ip) 
		{
			if (strpos($Ip, '::') !== false)
				$Ip = str_replace('::', str_repeat(':0', 8 - substr_count($Ip, ':')).':', $Ip);
			if (strpos($Ip, ':') === 0) $Ip = '0'.$Ip;
			return $Ip;
		}
		
		private function IPv6ToLong($Ip, $DatabaseParts= 2) 
		{
			$Ip = $this->ExpandIPv6Notation($Ip);
			$Parts = explode(':', $Ip);
			$Ip = array('', '');
			for ($i = 0; $i < 4; $i++) $Ip[0] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);
			for ($i = 4; $i < 8; $i++) $Ip[1] .= str_pad(base_convert($Parts[$i], 16, 2), 16, 0, STR_PAD_LEFT);

			if ($DatabaseParts == 2)
				return array(base_convert($Ip[0], 2, 10), base_convert($Ip[1], 2, 10));
			else   
				return base_convert($Ip[0], 2, 10) + base_convert($Ip[1], 2, 10);
		}
}
?>