<?php
//TODO: check every function
class Users extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function getAll()
		{
			$query = "SELECT * from user";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getPoints($userID)
		{
			$query = "SELECT SUM(points) as points FROM userpoints WHERE userID = '".$userID."'";
			$answer = $this->db->query($query);
			
			$points = $answer->row();
			$points = $points->points;
			
			return $points;
			
		}
		
		public function exist($username)
		{
			$query = "SELECT * FROM user WHERE username='".$username."'";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows()==0)
				return false;
			else
				return true;
		}
		
		public function mail_exist($mail)
		{
			$query = "SELECT * FROM user WHERE mail='".$mail."'";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows()==0)
				return false;
			else
				return true;
		}
		
		public function login($username, $password)
		{
			$query = "SELECT * FROM user WHERE username='".$username."' AND password=BINARY('".$password."')";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows()==0)
				return -1;
			else
				return $answer->row()->userID;
		}
		
		public function register($username, $password, $mail, $shared, $avatar)
		{
			$lastConnection = date('Y-m-d H:i:s',time());
			$data["username"] = $username;
			$data["password"] = $password;
			$data["mail"] = $mail;
			$data["created"] = $lastConnection;
			$data["lastconnection"] = $lastConnection;
			$data["shared"] = $shared;
			$data["mailing"] = 1;
			$data["avatar"] = $avatar;
			
			$this->db->insert('user', $data);
			$id = $this->db->insert_id();
			
			$achievementsData["userID"] = $id;
			$this->db->insert('badgesprogress', $achievementsData);
		}
		
		public function updatePassword($userID, $password)
		{
			$query = "UPDATE user SET password='".$password."' WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function getIDFromMail($mail)
		{
			$query = "SELECT userID from user WHERE mail='".$mail."'";
			$answer = $this->db->query($query);
			
			return $answer->row()->userID;
		}
		
		public function getUsernameByID($id)
		{
			$username = '';
			$query = "SELECT * FROM user WHERE userID='".$id."'";
			$answer = $this->db->query($query);
			
			if($answer->num_rows() != 0)
			{
				$user = $answer->row();
				$username = $user->username;
			}
			
			return $username;
		}
		
		public function getUserIDByName($name)
		{
			$userID = -1;
			$query = "SELECT * FROM user WHERE username='".$name."'";
			$answer = $this->db->query($query);
			
			if($answer->num_rows() != 0)
			{
				$user = $answer->row();
				$userID = $user->userID;
			}
			
			return $userID;
		}
		
		public function getUserInfo($id)
		{
			$query = "SELECT * FROM user WHERE userID='".$id."'";
			$answer = $this->db->query($query);
			
			return $answer->row();
		}
		
		public function getActiveChallenges($id)
		{
			$query = "SELECT challengeID FROM userchallenge WHERE userID = ".$id." AND completed = 0";
			
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getFinishedChallenges($id)
		{
			$query = "SELECT challengeID FROM userchallenge WHERE userID = ".$id." AND completed = 1";
			
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getDistinctFinishedChallenges($id)
		{
			$query = "SELECT DISTINCT(challengeID) FROM userchallenge WHERE userID = ".$id." AND completed = 1";
			
			$answer = $this->db->query($query);
			
			return $answer->num_rows();
		}
		
		public function getBadges($id)
		{
			$query = "SELECT * FROM userbadges, badges WHERE userbadges.userID = ".$id." AND userbadges.badgeID = badges.badgeID";
			
			$answer = $this->db->query($query);
			
			return array($answer->num_rows(), $answer);
		}
		
		public function getBadgeById($userID, $badgeID)
		{
			$query = "SELECT * FROM userbadges, badges WHERE userbadges.userID = '".$userID."' AND userbadges.badgeID = badges.badgeID AND userbadges.badgeID='".$badgeID."'";
			
			$answer = $this->db->query($query);
			
			return $answer->row();
		}
		
		public function getUnwonBadges($id)
		{
			$query = "SELECT * FROM badges WHERE badgeID NOT IN (SELECT badgeID FROM userbadges WHERE userID='".$id."')";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getUnfinishedChallenge($userID)
		{	
			$select = "SELECT challenges.points as points, challenges.challengeID as challengeID, challenges.duration as duration, userchallenge.started as started, challenges.finalmssg as finalmssg, challenges.title as title";
			$query = $select ." FROM userchallenge, challenges WHERE userchallenge.challengeID = challenges.challengeID AND userID = ".$userID." AND completed = 0";
			
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function finishChallenge($userID, $challengeID, $started)
		{
			$query = "UPDATE userchallenge SET completed = 1 WHERE challengeID = '".$challengeID."' AND userID = '".$userID."' AND started = '".$started."'";
			$this->db->query($query);
		}
		
		public function addChallengeOpinion($userID, $challengeID, $started, $opinion)
		{
			$query = "UPDATE userchallenge SET opinion = '".$opinion."' WHERE challengeID = '".$challengeID."' AND userID = '".$userID."' AND started = '".$started."'";
			$this->db->query($query);
		}
		
		public function changeAvatar($avatar, $userID)
		{
			$query = "UPDATE user SET avatar='".$avatar."' WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function changeSharedStatus($shared, $userID)
		{
			$query = "UPDATE user SET shared=".$shared." WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function changeMailingStatus($mailing, $userID)
		{
			$query = "UPDATE user SET mailing=".$mailing." WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function changeMail($mail, $userID)
		{
			$query = "UPDATE user SET mail='".$mail."' WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function getLastConnection($userID)
		{
			$query = "SELECT lastconnection FROM user WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			$answer = $answer->row();
			
			return $answer->lastconnection;
		}
		
		public function updateLastConnection($userID, $time)
		{
			$query = "UPDATE user SET lastconnection='".$time."', inactivityNotified=0 WHERE userID='".$userID."'";
			$this->db->query($query);
		}
		
		public function awardPoints($userID, $points)
		{
			$data["userID"] = $userID;
			$data["points"] = $points;
			$this->db->insert('userpoints', $data);
			
			$query = "SELECT * FROM totalpoints WHERE userID='".$userID."'";
			$answer = $this->db->query($query);
			
			if ($answer->num_rows() == 0)
			{
				$data["userID"] = $userID;
				$data["points"] = $points;
				$this->db->insert('totalpoints', $data);
			}
			else
			{
				$query = "UPDATE totalpoints set points=points+'".$points."' WHERE userID='".$userID."'";
				$this->db->query($query);
			}
		}
		
		/**
		* Private functions
		**/

}
?>