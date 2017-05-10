<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Badge extends CI_Controller {
	
	public function index($user='')
	{
		if (empty($user))
		{
			//TODO: show available
		}
		else
		{
			//TODO: show achieved
		}
	}
	
	public function manage()
	{
		$this->load->view('add_badges');
	}
	
	public function admin()
	{
		
	}
	
	public function add()
	{
		$name = $this->input->post("name");
		$description = $this->input->post("description");
		$image = $this->input->post("src");
		$maxlvl = $this->input->post("maxlvl");
		$continue = $this->input->post("continue");
		$image = base_url($image);
		
		if ($name != NULL && $description && $image != NULL)
		{
			$this->load->model('badges');
			$this->badges->add($name, $description, $maxlvl, $image);

			if ($continue)
			{
				unset($_POST);
				$this->callMenu();
				$data["active"] = 'badge';
				$this->load->view('cms_welcome', $data);
			}
			else{
				$this->callMenu();
				$data["mssg"] = "Badges added, correctly";
				$data["active"] = '';
				$this->load->view('cms_welcome', $data);
			}
		}
		else
		{
			$this->callMenu();
			$data["error"] = 'Por favor, rellena todos los campos';
			$data["active"] = 'badge';
			$this->load->view('add_badge', $data);
		}
	}
	
	public function modify($tagID)
	{
		
	}
	
	///Private functions
	private function callMenu()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1)
		{
			$this->load->view('top_menu.php');
			return;
		}
		
		$this->load->model("users");
		$data["username"] = $this->users->getUsernameByID($id);
		$this->load->view('top_menu', $data);
	}
}
?>
