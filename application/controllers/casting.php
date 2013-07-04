<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once ("user.php");

class Casting extends User {

	function __construct()
	{
		parent::__construct();
		$this->load->model('applies_model');
		$this->load->helper('url');
	}

	function delete()
	{
		if($this->session->userdata('id'))
		{
			$apply_id = $this->input->post('apply_id');
			$response = $this->applies_model->delete($apply_id, $this->session->userdata('id'));

			if($response == TRUE)
			{
				$success_message = "Tu postulación al concurso se ha borrado satisfactoriamente";
				$this->index($this->session->userdata('id'), $success_message);
			}
			else
			{
				redirect(HOME);
			}
		}
		else
		{
			redirect(HOME);
		}
	}
}