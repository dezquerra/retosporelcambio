<?php
class Badges extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		/**
		*	Badge related functions
		**/
		public function add($name, $description, $maxlvl, $image)
		{
			$data["name"] = $name;
			$data["description"] = $description;
			$data["img"] = $image;
			$data["maxlvl"] = $maxlvl;
			
			$this->db->insert('badges', $data);
		}
		
		public function getNumberOfBadges()
		{
			$query = "SELECT SUM(maxlvl) as number FROM badges";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			
			return $row->number;
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM badges";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getID($badge)
		{
			$badgeID = -1;
			
			$query = "SELECT badgeID FROM badges WHERE name='".$badge."'";
			$answer = $this->db->query($query);
			$row = $answer->row();
			if (isset($row))
			{
				$badgeID = $row->badgeID;
			}
			
			return $badgeID;
		}
		
		/** 
		* Functions to check badges
		* Badges should be specified in a Document
		**/
		
		/// Helpers
		public function getBadgeLvl($userID, $badgeID)
		{
			$query = "SELECT lvl FROM userbadges WHERE userID='".$userID."' AND badgeID='".$badgeID."'";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows() == 0)
			{
				return 0;
			}	
			else
			{
				$row = $answer->row();
				return $row->lvl;
			}
				
		}
		
		public function giveBadge($userID, $badgeID)
		{
			$data["userID"] = $userID;
			$data["badgeID"] = $badgeID;
			$data["lvl"] = 1;
			
			$this->db->insert('userbadges', $data);
			
		}
		
		public function owned($userID, $badgeID)
		{
			$query = "SELECT * FROM userbadges WHERE userID = '".$userID."' AND badgeID = '".$badgeID."'";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows() > 0)
				return TRUE;
			else
				return FALSE;
		}
		
		public function upgradeBadge($userID, $badgeID)
		{
			$query = "UPDATE userbadges SET lvl=lvl+1 WHERE userID='".$userID."' AND badgeID='".$badgeID."'";
			$this->db->query($query);
		}
			
		public function addBookDownload($userID)
		{
			$query = "UPDATE badgesprogress SET booksDownloads=booksDownloads+1 WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public  function addFilmDownload($userID)
		{
			$query = "UPDATE badgesprogress SET filmsDownloads=filmsDownloads+1 WHERE userID='".$userID."'";
			$this->db->query($query);
		}

		public function increaseShared($userID)
		{
			$query = "UPDATE badgesprogress SET shared = shared+1 WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		/// Comprometido: se consigue al aceptar N retos
		public function getAcceptedChallenges($userID)
		{
			$query = "SELECT * FROM userchallenge WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		/// Aplicado: Se consigue al completar N retos
		public function getCompletedChallenges($userID)
		{
			$query = "SELECT * FROM userchallenge WHERE userID='".$userID."' AND completed=1";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		/// Patrocinador: Se obtiene al compartir en las redes sociales
		public function getTimesShared($userID)
		{
			$query = "SELECT shared FROM badgesprogress WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			return $row->shared;
		}
		
		/// Lector: Se obtiene al descargar un elemento de bibliografia
		public function getBooksDownloaded($userID)
		{
			$query = "SELECT booksDownloads FROM badgesprogress WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			return $row->booksDownloads;
		}
		
		
		/// Videoaficionado: Se obtiene al descargar N elementos de la filmoteca
		public function getFilmsDownloaded($userID)
		{
			$query = "SELECT filmsDownloads FROM badgesprogress WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			return $row->filmsDownloads;
		}
		
		
		/// Crítico: Se obtiene al dejar N opiniones
		public function getOpinions($userID)
		{
			$query = "SELECT * FROM userchallenge WHERE userID='".$userID."' AND completed=1 AND opinion!=''";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		/// Colaborador: Se obtiene al colaborar N veces
		public function getCollaborations($userID)
		{
			$query = "SELECT collaborate FROM badgesprogress WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			return $row->collaborate;
		}
		
		/**
		* Private functions
		**/

}
?>