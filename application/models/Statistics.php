<?php
//TODO: check every function
class Statistics extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function getRegisteredUsers()
		{
			$query = "SELECT * FROM user";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getCurrentChallenges()
		{
			$query = "SELECT * FROM userchallenge WHERE completed='0'";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getSharedChallenges()
		{
			$query = "SELECT * FROM userchallenge WHERE shared = 1";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getOpinions()
		{
			$query = "SELECT * FROM userchallenge WHERE opinion != ''";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getNumberOfChallenges()
		{
			$query = "SELECT * FROM challenges";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getBooks()
		{
			$query = "SELECT * FROM bibliography";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getBooksDownloads()
		{
			$query = "SELECT SUM(downloads) as downloads FROM bibliography";
			$answer = $this->db->query($query);
			
			$answer = $answer->row();
			return $answer->downloads;
		}
		
		public function getFilms()
		{
			$query = "SELECT * FROM filmography";
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getFilmsDownloads()
		{
			$query = "SELECT SUM(downloads) as downloads FROM filmography";
			$answer = $this->db->query($query);
			
			$answer = $answer->row();
			return $answer->downloads;
		}
		
		/**
		* Automated processes
		**/
		public function updateNotified($userID)
		{
				$query = "UPDATE user SET inactivityNotified = 1 WHERE userID='".$userID."'";
				$this->db->query($query);
		}
		
		public function getInactiveUsers($treshold)
		{
			$query = "SELECT * FROM user WHERE DATE(lastConnection) < '".$treshold."' AND inactivityNotified = 0";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getContactInfo()
		{
			$query = "SELECT * FROM contact";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getChallengesToNotify($timeTreshold, $challengeID, $endFlag)
		{
			$query = "SELECT user.mailing as mailing, user.mail as mail, userchallenge.started as started, user.userID as userID FROM user, userchallenge ";
			$query .= "WHERE user.userID=userchallenge.userID AND userchallenge.started < '".$timeTreshold."'";
			$query .= " AND userchallenge.completed=0";
			if ($endFlag)
			{
				$query .= " AND userchallenge.end_notified=0 AND userchallenge.challengeID='".$challengeID."'";
			}
			else
			{
				$query .= " AND userchallenge.middle_notified=0 AND userchallenge.challengeID='".$challengeID."'";
			}
			
			$answer = $this->db->query($query);
			return $answer;
		}
		
		public function removeOldPoints($treshold)
		{
			$query = "DELETE FROM userpoints WHERE date < '".$treshold."'";
			$this->db->query($query);
		}
		
		public function updateMiddleNotified($challengeID, $userID, $started)
		{
			$query = "UPDATE userchallenge SET middle_notified=1 WHERE challengeID='".$challengeID."' AND userID='".$userID."' AND started='".$started."'";
			$this->db->query($query);
		}
		
		public function updateEndNotified($challengeID, $userID, $started)
		{
			$query = "UPDATE userchallenge SET end_notified=1 WHERE challengeID='".$challengeID."' AND userID='".$userID."' AND started='".$started."'";
			$this->db->query($query);
		}
		
		public function deleteComment($commentID)
		{
			$query = "DELETE FROM contact WHERE contactID='".$commentID."'";
			$this->db->query($query);
		}
		
		/**
		* Private functions
		**/

}
?>