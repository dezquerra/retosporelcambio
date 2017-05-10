<?php
class Frontends extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function getImportantFAQ()
		{
			$query = "SELECT * FROM faq WHERE important=1";
			$answer = $this->db->query($query);
			
			return $answer;              
		}
		
		public function getFAQ()
		{
			$query = "SELECT * FROM faq WHERE important=0";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function storeContact($name, $mail, $mssg)
		{
			$data["name"] = $name;
			$data["mail"] = $mail;
			$data["mssg"] = $mssg;
			
			$this->db->insert('contact', $data);
		}
		
		public function getThanks()
		{
			$say = FALSE;
			$query = "SELECT * FROM thanks";
			$answer = $this->db->query($query);
			
			if($answer->num_rows() > 0)
				$say = TRUE;
			
			return array($say, $answer);
		}
		
		public function setThanks($name, $reason)
		{
			$data["name"] = $name;
			$data["reason"] = $reason;
			
			$this->db->insert('thanks', $data);
		}
		
		public function getCountry($longIp)
		{
			$country_code = "ES";
			$query = "SELECT country_code FROM ipligence WHERE ip_from <= '".$longIp."' and ip_to >= '".$longIp."' LIMIT 1";
			$result = $this->db->query($query);
			
			if($result->num_rows > 0 )
			{
				$result = $result->row();
				$country_code = $result->country_code;	
			}
			
			return $country_code;
		}
		
}
?>