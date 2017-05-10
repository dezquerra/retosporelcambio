<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function index()
	{
	}
	
	public function changeSharedStatus($shared)
	{
		$this->load->model('users');
		$user = $this->sessions->checkSession();
		$shared = ($shared == 0) ? 1 : 0; 
		$this->users->changeSharedStatus($shared, $user);
	}
	
	public function changeMailingStatus($mailing)
	{
		$this->load->model('users');
		$user = $this->sessions->checkSession();
		$mailing = ($mailing == 0) ? 1 : 0; 
		$this->users->changeMailingStatus($mailing, $user);
	}
	
	public function changeMail()
	{
		$mail = $this->input->get('mail');
		$newMail = rawurldecode($mail);
		$this->load->model('users');
		$user = $this->sessions->checkSession();
		$this->users->changeMail($newMail, $user);
	}
	
	public function changePassword()
	{
		$password = $this->input->get("pass");
		$userID = $this->input->get("userID");
		
		//Decode base64
		$password = base64_decode($password);
		//Encode to SHA 256
		$password = hash('SHA256', $password);
		$this->load->model('users');
		$this->users->updatePassword($userID, $password);
	}
	
	public function addBookDownload()
	{
		$this->load->model('badges');
		$this->load->model('bibliographies');
		
		$id = $this->input->get("id");
		$user = $this->sessions->checkSession();
		$this->badges->addBookDownload($user);
		$this->bibliographies->addDownload($id);
	}
	
	public function addFilmDownload()
	{
		$this->load->model('badges');
		$this->load->model('filmographies');
		
		$id = $this->input->get("id");
		$user = $this->sessions->checkSession();
		$this->badges->addFilmDownload($user);
		$this->filmographies->addDownload($id);
	}
	
	//This function is for a specific situation. The Badge added is always the blog badge
	// For this reason the id of the badge is always 6. 
	public function blogBadge()
	{
		$this->load->model('badges');
		
		$id = $this->input->get("id");
		if ($this->badges->owned($id, 6))
		{
			echo "0";
			return;
		}
		else
		{
			$this->badges->giveBadge($id,6);
			echo "1";
			return;
		}
		
	}
	
	public function changeAvatar()
	{
		$avatar = $this->input->get("avatar");
		$this->load->model("users");
		
		$user = $this->sessions->checkSession();
		$this->users->changeAvatar($avatar, $user);
	}
	
	public function updateShareStats()
	{
		$this->load->model('badges');
		$user = $this->sessions->checkSession();
		$this->badges->increaseShared($user);
	}
	
	public function deleteComment($commentID)
	{
		$this->load->model('statistics');
		$this->statistics->deleteComment($commentID);
	}
}
?>
