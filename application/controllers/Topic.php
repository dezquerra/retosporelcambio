<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends CI_Controller {
	
	public function index()
	{
		$this->load->view('show_topics');
	}
	
	public function admin()
	{
		
	}
	
	public function add()
	{
		$name = $this->input->post("name");
		$color = $this->input->post("color");
		$image = $this->input->post('image');
		$continue = $this->input->post("continue");
		
		if ($name != NULL && $color != NULL)
		{
			$this->load->model('topics');
			$this->topics->add($name, $color, $image);

			if ($continue)
			{
				unset($_POST);
				$this->callMenu();
				$data["active"] = 'topic';
				$this->load->view('cms_welcome', $data);
			}
			else{
				unset($_POST);
				$data["mssg"] = "Topics added, correctly";
				$data["active"] = '';
				$this->callMenu();
				$this->load->view('cms_welcome', $data);
			}
		}
		else
		{
			unset($_POST);
			$data["error"] = 'Por favor, rellena todos los campos';
			$data["active"] = 'topic';
			$this->callMenu();
			$this->load->view('cms_welcome', $data);
		}
	}
	
	public function modify($topicID)
	{
		
	}
	
	/// Private functions

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
