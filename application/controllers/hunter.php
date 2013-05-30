<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hunter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'file', 'form','security'));
		$this->load->model(array('hunter_model', 'photos_model','castings_model', 'casting_categories_model', 'user_model', 'applies_model', 'videos_model','skills_model','custom_questions_model','custom_options_model'));
		$this->load->library(array('upload', 'image_lib', 'form_validation'));
		
	}
	
	function index()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id= $hunter_id['id'];
			$args["castings"]= $this->castings_model->get_castings($hunter_id, null, null, 0);

			$args["castings_dash"]= $this->_dashboard($hunter_id);
	
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_profile";
			$args["inner_args"]=$inner_args;
			$this->load->view('template',$args);
		}
		else
			redirect(HOME);
	}
	
	

	function verifylogin()
 	{
	   $this->load->library('form_validation');

	   $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
	   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
	   $this->form_validation->set_message('required', 'El campo es obligatorio');

	   if($this->form_validation->run() == FALSE)
	   {
			$args['content'] = 'home/login_hunter';
			$args['inner_args'] = NULL;
			
			$this->load->view('template', $args);
	   }
	   else
	   {
		   redirect(HOME."/hunter");
	   }
    }

	function check_database($password)
	{
	   $email = $this->input->post('email');
	   $result = $this->hunter_model->login($email, $password);

	   if($result)
	   {
	   		$hunter = "hunter";
	   		$this->session->set_userdata('logged_in', $result);
	   		$this->session->set_userdata('type', $hunter);

	   		return TRUE;
	   }
	   else
	   {
	     $this->form_validation->set_message('check_database', 'Email o contrase&ntildea inv&aacutelidos');
	     return FALSE;
	   }
	}

	function publish()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id= $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			
	   	 	$args['castings'] = $this->castings_model->get_castings($hunter_id);
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			
	   	 	$temp[-1]= "--  Seleccionar Todos  --";
			$temp[-2]= "--     Vaciar Campo    --";

			$args["skills"]=	$temp + $skills = $this->skills_model->get_skills();
			$args["filtros"] = array("-1" => "Todos","-2" => "Limpiar",1 => "Color de Pelo",2 =>"Color de Ojos",3 =>"Color de Piel",4 =>"Edad",5 =>"Estatura",6 =>"Contextura");
				
			$args["hunters"]= $temp + array("hunter1","hunter2","hunter3","hunter4");
			$args["age_list"] = $temp + array(0=>"10 a&ntildeos o menos",1=>"10-15 a&ntildeos",2=>"15-20 a&ntildeos",3=>"20-25 a&ntildeos",4=>"25-30 a&ntildeos",5=>"30-35 a&ntildeos",6=>"35-40 a&ntildeos",7=>"40-45 a&ntildeos o m&aacutes");	

			
	   	 	//Setear mensajes
			$this->form_validation->set_message('required', 
				'Este dato es requerido para publicar el casting.');

			//Setear reglas
			$this->form_validation->set_rules('title', 'Titulo', 'required');
			$this->form_validation->set_rules('description', 'Descripcion', 'required');
			$this->form_validation->set_rules('requirements', 'Requerimientos', 'required');
			$this->form_validation->set_rules('image', 'Imagen', 'callback_check_upload[logo]');
			$this->form_validation->set_rules('max_applies', 'Meta Postulantes', 'required|numeric');

			if ($this->form_validation->run() == FALSE)
			{
				//No paso todas las validaciones
			}
			
			else
			{
				if($this->input->post())
				{
					//Guardar los datos a la BD
					$casting['title'] = $this->input->post('title');
					$casting['start_date'] = $this->input->post('start-date');
					$casting['end_date'] = $this->input->post('end-date');
					$casting['description'] = $this->input->post('description');
					$casting['requirements'] = $this->input->post('requirements');
					
					$casting['skills'] = "";
					$flag = FALSE;
					foreach ($this->input->post('skills') as $skill) {
						if($flag)
							$casting['skills']=$casting['skills']."-";//le pego el guion
						$casting['skills'] = $casting['skills'].$skill;
						$flag =TRUE;
					}
					
					
					$casting['category'] = $this->input->post('category');
					//convierto la "categoria a su id correspondiente"
					$casting['category'] = $this->casting_categories_model->get_id_by_name($casting['category']);
					$casting['max_applies'] = $this->input->post('max_applies');

					/*
					
					$casting['eyes-color'] = $this->input->post('eyes-color');
					$casting['hair-color'] = $this->input->post('hair-color');
					$casting['skin-color'] = $this->input->post('skin-color');
					$casting['height'] = $this->input->post('height');
					$casting['age'] = $this->input->post('age');
					$casting['sex'] = $this->input->post('optionsRadios');
					*/
					$casting['entity_id'] = $hunter_id;

					$casting_id = $this->castings_model->insert($casting);
					
					
					//Procesan/insertan las preguntas
					$question_head= "question_";
					//var_dump($this->input->post($question.''.$i));
					
					for($i=0;isset($_POST[$question_head."$i"]);$i++)//POR CADA PREGUNTA
					{
						$question_data = array(); //el que se le pasará a la función para insertar la pregunta
						//caracteres separadores
						// |$   -> equivale a ":" Separa las partes
 						// |*   -> equivale a " " Separa atributo-valor
 						// *#   -> equivale a "," Separa opciones
 						 
						var_dump($_POST[$question_head."$i"]);
						$partes_pregunta = explode("|*", $_POST[$question_head."$i"]);
						foreach($partes_pregunta as $parte) //obtiene el arreglo elemento->valor
						{
							$valores_pregunta = explode("|$",$parte);
							
							switch($valores_pregunta[0])//sobre el nombre del valor
							{
								case 'type':
									$question_data['tipo'] = $valores_pregunta[1];
									break;
									
								case 'title':
									$question_data['texto'] = $valores_pregunta[1];
									break;
									
								case 'valores':
									$question_data['options'] = $valores_pregunta[1];
									break;
							}
						}
						//ya está armado el arreglo $question_data
						$id_pregunta_insertada = $this->custom_questions_model->insert($casting_id,$question_data); //se inserta la pregunta
						
						//si tiene valores(opciones)
						if($question_data['options'] != '')
						{
							$opciones = explode("@#",$question_data['options']);
							foreach($opciones as $opcion)
							{
								$this->custom_options_model->insert($id_pregunta_insertada,$opcion); 
							}
						}
						
					}
					 
 
					//Por ultimo subir la foto
					$form_file_name = 'logo';
					$images = array(
						array(
							'path' => realpath(APPPATH.'..'.CASTINGS_PATH),
							'width'=> 230,
							'height' => 230
						),
						array(
							'path' => realpath(APPPATH.'..'.CASTINGS_FULL_PATH),
							'width'=> 600,
							'height' => 300
						)
					);

					$filename = $this->_upload_image($casting_id, $images, $form_file_name);

					$this->castings_model->insert_image($casting_id, $filename);
					redirect('hunter/casting_list');
				}
			}

			$args['categories'] = $this->casting_categories_model->get_casting_categories();
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/publish_view";
			$args["inner_args"]=$inner_args;
			
			$this->load->view('template', $args);

		}
		else
			redirect(HOME);
	}
	
	function casting_list($page=1,$casting_state=0)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			
			$args["casting_state"] = $casting_state;
			$args["chunks"]=ceil($this->castings_model->count_castings($hunter_id,$casting_state)/5);						
			$args["castings"]= $this->castings_model->get_castings($hunter_id, 5, $page, $casting_state);
			
			$args["status"]=array(0=>"Activo",1=>"Revisi&oacute;n",2=>"Finalizado",3=>"Todos");
			$args["page"]=$page;
			
			$args["casting_state"]=$casting_state;
	   	 	//Rescatar las personas que postularon a cada uno de los castings
	   	 	foreach ($args['castings'] as &$casting) {
	   	 		$casting['applies'] = $this->applies_model->get_applies_cant($casting['id']);
	   	 	}

	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/list_view";
			$args["inner_args"]=$inner_args;
			
			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(HOME);
	}
	
	private function _physical_filter($casting_id, $id_applicants, $sex=NULL, $eyes_color=NULL, $hair_color=NULL, $build=NULL, $skin_color=NULL, $height_range=NULL, $age_range=NULL, $page=NULL)
	{
		$filtered_user_ids = array();
		foreach($id_applicants as $aplicante)
		{
			$filtered_user_ids[] = $aplicante['user_id'];//guardo sólo los id de cada usuario
		}
		return $this->applies_model->get_filtered_user_applies_by($filtered_user_ids, $casting_id, $sex, $eyes_color, $hair_color, $build, $skin_color, $height_range, $age_range, $page);
		
	}

	private function _word_filter($casting_id, $id_applicants,$words=NULL,$page=NULL)
	{
		$filtered_user_ids = array();
		foreach($id_applicants as $aplicante)
		{
			$filtered_user_ids[] = $aplicante['user_id'];//guardo sólo los id de cada usuario
		}
		return $this->applies_model->get_filtered_user_applies_by_word($filtered_user_ids, $casting_id, $words, $page);
		
	}

	function casting_detail($id=NULL)
	{
		if($this->session->userdata('logged_in') && isset($id) && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args["casting"] = $this->castings_model->get_full_casting($id);
			$args["casting"]["applies"] = $this->applies_model->get_applies_cant($id);
			if($args["casting"]["applies"] < $args["casting"]["max_applies"])
					$args["casting"]['target_applies'] = round($args["casting"]["applies"]/$args["casting"]["max_applies"],2) * 100;
			else 
				$casting['target_applies'] = 100;
								
			if($args["casting"]['applies'] != 0)
				$args["casting"]['reviewed'] = round(($args["casting"]['applies'] - $this->applies_model->count_casting_applies($args["casting"]['id'],0))/$args["casting"]['applies'],2)*100;
			else 
				$args["casting"]['reviewed']= 0;					   
			$args["casting"]['target_applies_color'] = $this->_color_bar((int) $args["casting"]['target_applies']);
			$args["casting"]['reviewed_color'] = $this->_color_bar((int) $args["casting"]['reviewed']);
			
			
			if(isset($args["casting"]["skills"]))//skills guardadas del casting
			{
				$args['tags'] = explode("-",$args['casting']['skills']);//convierto a arreglo el string de números ej: 1-3-2
				
				$textual_tags = array(); //array paralelo textual
				foreach($args['tags'] as $num_tag)
				{
					$textual_tags[] = $this->skills_model->get_name($num_tag); //saca el nombre(texto) de cada numero y lo agrega al nuevo arreglo
				}
				$args['tags'] = $textual_tags;//intercambia los arreglos para enviarlos textualmente
			}
			
			$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_casting_detail";
			$args["inner_args"]=$inner_args;
			
			//Obtengo los ID de los usuarios(5) todos y los seleccionados
			$args["postulantes"] = $this->applies_model->get_short_user_applies($id);
			$args["seleccionados"] = $this->applies_model->get_short_user_applies($id,1);
			
			//se transforman en arreglo de usuarios
			if($args["postulantes"] != 0)
			{
				$postulantes_textual = array();
				foreach($args["postulantes"] as $postulante_numerico)
				{
			
					$postulantes_textual[] = $this->user_model->select_applicant($postulante_numerico['user_id']);
					if($postulantes_textual[count($postulantes_textual)-1]['image_profile']!=0)
						$postulantes_textual[count($postulantes_textual)-1]['image_profile'] = $this->photos_model->get_name($postulantes_textual[count($postulantes_textual)-1]['image_profile']);
				}
				$args["postulantes"] = $postulantes_textual;
			}
			else $args["postulantes"] = NULL;
			
			if($args["seleccionados"] != 0)
			{
				$seleccionados_textual = array();			
				foreach($args["seleccionados"] as $postulante_numerico)
				{
					$seleccionados_textual[] = $this->user_model->select_applicant($postulante_numerico['user_id']);
					if($seleccionados_textual[count($seleccionados_textual)-1]['image_profile']!=0)
						$seleccionados_textual[count($seleccionados_textual)-1]['image_profile'] = $this->photos_model->get_name($seleccionados_textual[count($seleccionados_textual)-1]['image_profile']);				
				}
				$args["seleccionados"] = $seleccionados_textual;
			}
			else $args["seleccionados"] = NULL;
					
			$this->load->view('template', $args);
		}
		else
			redirect(HOME);

	}


	function custom_form($casting_id=NULL)
	{
		if($this->session->userdata('logged_in') && isset($id) && $this->session->userdata('type') == "hunter")
		{
			if(!is_null($casting_id))
			{
				//cargo las preguntas existentes
				
				
				//cargo la vista
				
			}
		}
		else redirect(HOME);
	}
	
	function edit_casting($id=NULL)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id= $hunter_id['id'];
	   	 	$args["castings_dash"]= $this->_dashboard($hunter_id);
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			
			$temp[-1]= "--  Seleccionar Todos  --";
			$temp[-2]= "--     Vaciar Campo    --";
			
			$args["hunters"]= $temp + array("hunter1","hunter2","hunter3","hunter4");
			$args["skills"]= $temp + $this->skills_model->get_skills();		
			$args["age_list"] = $temp + array(0=>"10 a&ntildeos o menos",1=>"10-15 a&ntildeos",2=>"15-20 a&ntildeos",3=>"20-25 a&ntildeos",4=>"20-30 a&ntildeos",5=>"30-35 a&ntildeos",6=>"35-40 a&ntildeos",7=>"40-45 a&ntildeos o m&aacutes");	


			$args['categories'] = $this->casting_categories_model->get_casting_categories();
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]= "castings/edit_hunter_casting";
			$args["inner_args"]= $inner_args;
			
			//$args["update_values"]=$this->castings_model->select($id);
			$args['update_values'] = $this->castings_model->get_full_casting($id);
			$args['actual_category'] = $this->casting_categories_model->get_name($args['update_values']['category']);
			$args['actual_skills'] = explode("-",$args['update_values']['skills']);
						
			
			//--------------------------------------->
			//Setear mensajes
			$this->form_validation->set_message('required', 
				'Te falta este dato, es importante para tus postulantes');

			//Setear reglas
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('requirements', 'Requirements', 'required');
			$this->form_validation->set_rules('image', 'Image', 'callback_check_upload[casting_image]');

			//$this->form_validation->set_rules('logo', 'Logo', 'callback_check_upload');
			
			 
			 /*
			if(!(isset($hunter_id) && !(is_numeric($hunter_id))))
			
			$this->form_validation->set_rules('logo', 'Logo', 'callback_check_upload');
			 */

			//_____________________________________________________________________________________________ 
			if ($this->form_validation->run())
			{
			
				if($this->input->post())
				{
					//Guardar los datos a la BD
					$casting['title'] = $this->input->post('title');
					$casting['start_date'] = $this->input->post('start-date');
					$casting['end_date'] = $this->input->post('end-date');
					$casting['description'] = $this->input->post('description');
					$casting['requirements'] = $this->input->post('requirements');
					
					$casting['skills'] = "";
					$flag = FALSE;
					foreach ($this->input->post('skills') as $skill) {
						if($flag)
							$casting['skills']=$casting['skills']."-";//le pego el guion
						$casting['skills'] = $casting['skills'].$skill;
						$flag =TRUE;
					}
					
					
					$casting['category'] = $this->input->post('category');
					//convierto la "categoria a su id correspondiente"
					$casting['category'] = $this->casting_categories_model->get_id_by_name($casting['category']);
					$casting['eyes-color'] = $this->input->post('eyes-color');
					$casting['hair-color'] = $this->input->post('hair-color');
					$casting['skin-color'] = $this->input->post('skin-color');
					$casting['height'] = $this->input->post('height');
					$casting['age'] = $this->input->post('age');
					$casting['sex'] = $this->input->post('optionsRadios');
					$casting['entity_id'] = $hunter_id;


					//UPDATE
					$this->castings_model->update($casting,$id);

					//Por ultimo subir la foto
					$form_file_name = 'casting_image';
					$images = array(
						array(
							'path' => realpath(APPPATH.'..'.CASTINGS_PATH),
							'width'=> 230,
							'height' => 230
						),
						array(
							'path' => realpath(APPPATH.'..'.CASTINGS_FULL_PATH),
							'width'=> 600,
							'height' => 300
						)
					);
					
					$filename = $this->_upload_image($id, $images, $form_file_name);

					$this->castings_model->insert_image($id, $filename);
					//redirect(HOME.'/hunter/edit_casting/'.$id);
					redirect(HOME.'/hunter/casting_detail/'.$id);
				}			 
			 
			
			}
			
			//------------------------------>
			$this->load->view('template', $args);	
		}
		else
			redirect(HOME);
	}
	

	function applicants_list($id=NULL,$page=1)
	{
		if($this->session->userdata('logged_in') && isset($id))
		{
		
			$args["id_casting"]=$id;
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			
		 	$hunter_id= $args['user_data']['id'];
	   	 	
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			

			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/applicants_list";
			$args["inner_args"]=$inner_args;
			$args["skills"]= $this->skills_model->get_skills();
 	 	
 	 		$temp[-1]= "--  Seleccionar Todos  --";
			$temp[-2]= "--     Vaciar Campo    --";
 	 		$args["skills"] = $temp + $args["skills"];


			$args["status"]= array(0=>"Sin Revisar",1=>"Aceptados",2=>"Rechazados",3=>"Todos");
			
			$args["sex_list"]= $temp + array(0=>"Femenino",1=>"Masculino");
	
			$args["age_list"] = $temp + array(0=>"10 a&ntildeos o menos",1=>"10-15 a&ntildeos",2=>"15-20 a&ntildeos",3=>"20-25 a&ntildeos",4=>"20-30 a&ntildeos",5=>"30-35 a&ntildeos",6=>"35-40 a&ntildeos",7=>"40-45 a&ntildeos o m&aacutes");	

			$temp = $this->castings_model->get_full_casting($id);
			$args["name_casting"]= $temp["title"];
			
			$unfiltered_applicants= $this->applies_model->get_castings_applies($id,null,0);
			$args["get_uri"] = null;

			if(isset($_GET["status"]))
			{
				$id_applicants= $this->applies_model->get_castings_applies($id,null,$_GET["status"]);
				
				$args["applies_state"] = $_GET["status"];
				$args["name_p"] = $_GET["name"];
				
				$args["get_uri"] = "/?status=".$_GET["status"]."&name=".str_replace(' ', '+', $_GET["name"]);

				if(isset($_GET["skills"]))
				{
					$args["filter_skills"] = $_GET["skills"];
					foreach ($args["filter_skills"] as $value)
						$args["get_uri"] = $args["get_uri"]."&skills%5B%5D=".$value;
				}
				else
					$args["filter_skills"] = null;

				if(isset($_GET["sex"]))
				{
					$args["filter_sex"] = $_GET["sex"];
					foreach ($args["filter_sex"] as $value)
						$args["get_uri"] = $args["get_uri"]."&sex%5B%5D=".$value;
				}
				else
					$args["filter_sex"] = null;
				
				if(isset($_GET["age"]))
				{
					$args["age_range"] = $_GET["age"];
					foreach ($args["age_range"] as $value)
						$args["get_uri"] = $args["get_uri"]."&age%5B%5D=".$value;
				}
				else
					$args["age_range"] = null;

					
 


				if($id_applicants!=0)				
				{
					$all_data_postulation_data= $id_applicants;

					if(!is_null($args["filter_skills"]))
					{
						$id_applicants = $this->user_model->filter_user($id_applicants,$args["filter_sex"],$args["age_range"],$args["name_p"]);
						
						
						$args["chunks"]=ceil(count($this->skills_model->filter_user_categories($id_applicants,$args["filter_skills"]))/5);	

						$id_applicants = $this->skills_model->filter_user_categories($id_applicants,$args["filter_skills"],$page);
					}
					else
					{
						$args["chunks"]=ceil(count($this->user_model->filter_user($id_applicants,$args["filter_sex"],$args["age_range"],$args["name_p"]))/5);	
						$id_applicants = $this->user_model->filter_user($id_applicants,$args["filter_sex"],$args["age_range"],$args["name_p"],$page);
					}

					if($id_applicants != 0)
					{
						$temp = array();
						foreach ($all_data_postulation_data as $value) 
							if(isset($id_applicants[$value["user_id"]]))
								array_push($temp, $value);
						$id_applicants = $temp;
					}

				}
				else
					$args["chunks"]=0;
			
			}
			else
			{
				$args["chunks"]=ceil($this->applies_model->count_casting_applies($id,0)/5);					
				$id_applicants= $this->applies_model->get_castings_applies($id,$page,0);
				$args["applies_state"] = 0;
				$args["name_p"] = null;
				$args["filter_skills"] = null;
				$args["filter_sex"] = null;
				$args["age_range"] = null;

			}
			$args["page"] = $page;
			if($id_applicants!= 0)
			{
				//define si se puede finalizar el casting o no(toma el array anterior(sin filtrar) como parametro)
				$args["allowed_to_finalize"] = $this->applies_model->verify_castings_applies_status($unfiltered_applicants);
				
				$args["applicants"]=array();
				
				foreach($id_applicants as $id)
				{
					$applicant_info = $this->user_model->select_applicant($id['user_id']);
					
					if($this->user_model->has_main_video($id['user_id']))//Si tiene seteado el video principal
					{
						$video_info = $this->videos_model->get_applied_video_applicant($id['user_id'],$args["id_casting"]);//obtiene el video con el que se postuló
					}
					else //sino carga el primer video de los agregados
					{
						$video_info = $this->videos_model->get_video_applicant($id['user_id']);//saca primer video que tenga registrado
					}

					if($applicant_info['image_profile']!=0)
						$applicant_info['image_profile'] = $this->photos_model->get_name($applicant_info['image_profile']);
				
					$applicant_info["apply_id"]= $id["id"]; 
					$applicant_info["apply_state"]= $id["state"];
					$applicant_info['tags'] = $this->skills_model->get_user_skills($id['user_id']);
					$applicant_info['video_id'] =array_pop($video_info);
					array_push($args["applicants"],$applicant_info);
				}				
			}

			$this->load->view('template', $args);
		}
		else
			redirect(HOME);

	}
	
	function accept_apply($apply_id,$casting_id)
	{
		if($this->session->userdata('logged_in'))
		{
			$this->applies_model->set_accepted($apply_id,$this->input->post('observation'));
			redirect(HOME."/hunter/applicants_list/".$casting_id);
		}
		else
			redirect(HOME);	
	}
	
	function reject_apply($apply_id,$casting_id)
	{
		if($this->session->userdata('logged_in'))
		{
			$this->applies_model->set_rejected($apply_id);
			redirect(HOME."/hunter/applicants_list/".$casting_id);
		}
		else
			redirect(HOME);	
	}
	
	function accepted_list($id)
	{
		if($this->session->userdata('logged_in')&& isset($id) && $this->session->userdata('type') == "hunter")
		{
			$args['user_data'] = $this->session->userdata('logged_in');
			
			$hunter_id= $args['user_data']['id'];	   	 	
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/accepted_list";
			$args["inner_args"]=$inner_args;
			$temp = $this->castings_model->get_full_casting($id);
			$args["name_casting"]= $temp["title"];
			$id_applicants= $this->applies_model->get_castings_applies_selected($id);
			$args["id_casting"]= $id;
			$args["mailto_all"]="";
			if($id_applicants!= 0)
			{
				$args["applicants"]=array();
				
				foreach($id_applicants as $id)
				{
					$applicant_info=$this->user_model->select_applicant($id['user_id']);
					$applicant_info["observation"]=$id["observation"];
					if($applicant_info['image_profile']!=0)
						$applicant_info['image_profile'] = $this->photos_model->get_name($applicant_info['image_profile']);
				
					array_push($args["applicants"],$applicant_info);
					$args["mailto_all"]=$args["mailto_all"].$applicant_info["email"].";";
				}				
			}
		
			$this->load->view('template', $args);	
		}
		else
			redirect(HOME);
	}

	function finalize_casting($id_casting)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
				$this->castings_model->finalize_casting($id_casting);	
				redirect(HOME."/hunter/casting_list");
		}
		else
			redirect(HOME);
	}

	function edit()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id= $hunter_id['id'];
			
			$args["castings_dash"]= $this->_dashboard($hunter_id);
	   	 	$args['castings'] = $this->castings_model->get_castings($hunter_id);
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_edit";
			$args["inner_args"]=$inner_args;
			
			
			$args["update_values"]=$this->hunter_model->select($hunter_id);
			
			
			
			//--------------------------------------->
			//Setear mensajes
			$this->form_validation->set_message('required', 
				'Te falta este dato, es importante para tus postulantes');

			//Setear reglas
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('about_us', 'About_us', 'required');
			$this->form_validation->set_rules('we_look_for', 'We_look_for', 'required');
			

			if ($this->form_validation->run() == FALSE)
			{
				//No paso todas las validaciones
			}
			
			else
			{
				//Guardar los datos de hunter
				$profile['id'] = $hunter_id;
				$profile['name'] = $this->input->post('name');
				$profile['email'] = $this->input->post('email');
				$profile['address'] = $this->input->post('address');
				$profile['about_us'] = $this->input->post('about_us');
				$profile['we_look_for']  = $this->input->post('we_look_for');
				//$profile['logo']  = $this->input->post('logo');

				//print_r($profile);
				//ingresar los datos a la base de datos
				$this->hunter_model->update($profile);

				//Por ultimo subir la foto
			

				if($this->check_upload('','hunter_profile') == TRUE && (isset($hunter_id) && is_numeric($hunter_id)))
					$this->_upload_image_hunter($profile['id'],'hunter_profile');


				redirect(HOME.'/hunter/edit');
			}
			
			//------------------------------>
			$this->load->view('template', $args);	
		}
		else
			redirect(HOME);
	}


	function manage_hunters()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_manager";
			$args["inner_args"]=$inner_args;

			$args["hunters"] = $this->hunter_model->retrieve_sub_hunters($hunter_id);
			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}

	function assign_workload()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_assign_workload";
			$args["inner_args"]=$inner_args;

			$args["castings"] = array(array("casting_name" => "Mundos Opuestos","quantity"=> 30000,"default"=> 1000));
			
			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}


	function check_workload()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_check_workload";
			$args["inner_args"]=$inner_args;

			$args["castings"] = array(array("casting_name" => "Mundos Opuestos","quantity"=> 3000,"check"=> 1000));
			
			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}

	function create_sub_hunter()
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter" && isset($_POST["hunter_name"]))
		{

			$this->form_validation->set_rules('hunter_name', 'Nombre Hunter','trim|required|max_length[20]|xss_clean');
			$this->form_validation->set_rules('email', 'Correo', 'trim|required|valid_email|callback_check_unique');
			$this->form_validation->set_rules('pass1', 'Contrase&ntildea', 'trim|required|matches[pass2]|md5');
			$this->form_validation->set_rules('pass2', 'Confirmar Contrase&ntildea', 'trim|required');
			$this->form_validation->set_rules('image_sub_hunter', 'Imagen Hunter', 'callback_check_upload[image_sub_hunter]');

			$hunter_id = $this->session->userdata('logged_in');
			$hunter_id = $hunter_id['id'];

			if ($this->form_validation->run() == FALSE)
			{
				
				$args["castings_dash"]= $this->_dashboard($hunter_id);
				
				$args['user_data'] = $this->session->userdata('logged_in');
				$args["content"]="castings/hunter_template";
				$inner_args["hunter_content"]="castings/hunter_manager";
				$args["inner_args"]=$inner_args;
				$args["show"]=true;
				$args["hunters"] = $this->hunter_model->retrieve_sub_hunters($hunter_id);

				
				$this->load->view('template', $args);
			}
			else
			{
				$data['name'] = $this->input->post('hunter_name');
				$data['email'] = $this->input->post('email');
				$data['password'] = $this->input->post('pass1');
				$data['super_hunter_id'] = $hunter_id;
				
				$this->_upload_image_hunter($this->hunter_model->insert_sub_hunter($data),'image_sub_hunter');

				redirect(HOME."/hunter/manage_hunters");
			}
		}
		else
			redirect(HOME);

	}

	function edit_sub_hunter($id_sub_hunter)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter" && isset($_POST["hunter_name".$id_sub_hunter]))
		{

			$this->form_validation->set_rules('hunter_name'.$id_sub_hunter, 'Nombre Hunter','trim|required|max_length[20]|xss_clean');
			$this->form_validation->set_rules('email'.$id_sub_hunter, 'Correo', 'trim|required|valid_email|callback_check_unique_update['.$id_sub_hunter.']');
			if($_POST['pass1'.$id_sub_hunter]!="" || $_POST['pass2'.$id_sub_hunter]!="")
			{
				$this->form_validation->set_rules('pass1'.$id_sub_hunter, 'Contrase&ntildea', 'trim|required|matches[pass2'.$id_sub_hunter.']|md5');
				$this->form_validation->set_rules('pass2'.$id_sub_hunter, 'Confirmar Contrase&ntildea', 'trim|required');
			}

			if(file_exists($_FILES['image_sub_hunter'.$id_sub_hunter]['tmp_name']) && is_uploaded_file($_FILES['image_sub_hunter'.$id_sub_hunter]['tmp_name']))
				$this->form_validation->set_rules('image_sub_hunter'.$id_sub_hunter, 'Imagen Hunter', 'callback_check_upload[image_sub_hunter'.$id_sub_hunter.']');

			$hunter_id = $this->session->userdata('logged_in');
			$hunter_id = $hunter_id['id'];

			if ($this->form_validation->run() == FALSE)
			{
				
				$args["castings_dash"]= $this->_dashboard($hunter_id);
				
				$args['user_data'] = $this->session->userdata('logged_in');
				$args["content"]="castings/hunter_template";
				$inner_args["hunter_content"]="castings/hunter_manager";
				$args["inner_args"]=$inner_args;
				$args["show_edit"][$id_sub_hunter]=true;
			    
			    $args["hunters"] = $this->hunter_model->retrieve_sub_hunters($hunter_id);

				
				$this->load->view('template', $args);
			}
			else
			{
				$data['name'] = $this->input->post('hunter_name'.$id_sub_hunter);
				$data['email'] = $this->input->post('email'.$id_sub_hunter);
				
				if($_POST['pass1'.$id_sub_hunter]!="")
					$data['password'] = $this->input->post('pass1'.$id_sub_hunter);
				
				$this->hunter_model->update_sub_hunter($data,$id_sub_hunter,$hunter_id);
				
				if(file_exists($_FILES['image_sub_hunter'.$id_sub_hunter]['tmp_name']) && is_uploaded_file($_FILES['image_sub_hunter'.$id_sub_hunter]['tmp_name']))
					$this->_upload_image_hunter($id_sub_hunter,'image_sub_hunter'.$id_sub_hunter);

				redirect(HOME."/hunter/manage_hunters");
			}
		}
		else
			redirect(HOME);

	}

	function delete_sub_hunter($id_sub_hunter)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			
			$this->hunter_model->delete_sub_hunter($id_sub_hunter,$hunter_id);
			redirect(HOME."/hunter/manage_hunters");

		}
		else
			redirect(HOME);
	}

	/* truco para validar que se suba imagen, estas funciones trabajan con post, pero como la imagen
	llega de otra forma, se aprovecha el parametro extra para mandar el nombre de la variable*/
	function check_upload($dump,$image)
	{
		if($_FILES[$image]['error'] == 4)
		{
			$this->form_validation->set_message('check_upload', 'Debes subir un archivo antes de continuar.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function check_unique($mail)
	{
		if($this->hunter_model->validate_mail($mail))
		{
			$this->form_validation->set_message('check_unique', 'Correo ya existe.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function check_unique_update($mail,$id)
	{
		if($this->hunter_model->validate_mail_update($mail,$id))
		{
			$this->form_validation->set_message('check_unique', 'Correo ya existe.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	private function _resize_image($images_path, $form_file_name, $width, $height)
	{
		$image = $this->upload->data($form_file_name);

		$config = array(
			'image_library' => 'gd2',
			'source_image' => $image['full_path'],
			'new_image' => $images_path,
			'maintain_ratio' => TRUE,
			'width' => $width,
			'height' => $height
		);
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	private function _upload_image($id, $images, $form_file_name)
	{
		$upload_path = realpath(APPPATH.UPLOAD_DIR);
		
		//obtener la extension del archivo
		$type = explode('/', $_FILES[$form_file_name]['type']);
		
		$filename = $id. '.' .$type[1];
		
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $upload_path,
			'file_name' => $filename,
			'overwrite' => TRUE,
			'max_size' => 2048,
			'remove_spaces' =>TRUE
		);
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($form_file_name))
		{
			print_r($this->upload->display_errors());
		}

		//ahora ajustar la imagen de lista
		foreach($images as $image)
		{
			$this->_resize_image($image['path'], $form_file_name, $image['width'], $image['height']);
		}
		
		unlink(realpath(APPPATH.UPLOAD_DIR.'/'.$filename));

		return $filename;
	}
	
	private function _upload_image_hunter($id,$file)
	{
		$images_path = realpath(APPPATH.UPLOAD_DIR);
		//$images_path = realpath(APPPATH.HUNTER_PROFILE_IMAGE);
		
		//obtener la extension del archivo
		$type = explode('/', $_FILES[$file]['type']);
		
		$filename = "hunter_".$id. '.' .$type[1];

		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $images_path,
			'file_name' => $filename,
			'overwrite' => TRUE,
			'max_size' => 2048,
			'remove_spaces' =>TRUE
		);
		

		//actualizar la imagen del usuario en la bd
		$this->db->where('id', $id);
		$this->db->set('logo',$filename);
		$this->db->update('entities');
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($file))
		{
			print_r($this->upload->display_errors());
		}
		
		//ahora ajustar la imagen
		$image = $this->upload->data($file);

		$config = array(
			'image_library' => 'gd2',
			'source_image' => $image['full_path'],
			'new_image' => realpath(APPPATH.HUNTER_UPLOAD_IMAGE),
			'maintain_ratio' => TRUE,
			'width' => '230',
			'height' => '230'
		);
		
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	private function _dashboard($hunter_id)
	{
	   	
		 	$castings = $this->castings_model->get_castings($hunter_id,4,1,0);	   	 			
			$numberc_review = 8 - count($castings);
						
			if($numberc_review == 4 && count($this->castings_model->get_castings($hunter_id,$numberc_review,1,1)) < 4)
			{
				$numberc_active = 8 - count($this->castings_model->get_castings($hunter_id,$numberc_review,1,1));
				$castings = $this->castings_model->get_castings($hunter_id,$numberc_active,1,0);	   	 
			}
			
		
			
			$castings = array_merge($castings,$this->castings_model->get_castings($hunter_id,$numberc_review,1,1));
			
			
			
	   	 	foreach ($castings as &$casting) {
	   	 		$casting['applies'] = $this->applies_model->get_applies_cant($casting['id']);
				
				if($casting["applies"] < $casting["max_applies"])
					$casting['target_applies'] = round($casting["applies"]/$casting["max_applies"],2) * 100;
				else 
					$casting['target_applies'] = 100;
								
				if($casting['applies'] != 0)
					$casting['reviewed'] = round(($casting['applies'] - $this->applies_model->count_casting_applies($casting['id'],0))/$casting['applies'],2)*100;
				else 
					$casting['reviewed']= 0;				
				
				
				   
				$casting['target_applies_color'] = $this->_color_bar((int) $casting['target_applies']);
				$casting['reviewed_color'] = $this->_color_bar((int) $casting['reviewed']);
				
				
	   	 	}	
 		return $castings;
	}	

	private function _color_bar($percent)
	{
		
		$return = "";
		switch (TRUE) {
			case (in_array($percent, range(0,20))):
				
				$return= "bar-danger";
				break;
			
			case (in_array($percent, range(21,80))):
				
				$return= "bar-warning";
				break;
				
			case (in_array($percent, range(81,100))):
				
				$return= "bar-success";
				break;
			default:
				
				break;
		}
		
		return $return;
	}

}