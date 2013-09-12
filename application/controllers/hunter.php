<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hunter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'file', 'form','security'));
		$this->load->model(array('hunter_model','share_detail_model', 'prize_categories_model' ,'photos_model','castings_model', 'casting_categories_model', 'user_model', 'applies_model','custom_questions_model','custom_options_model','custom_answers_model'));
		$this->load->library(array('upload','image_lib', 'form_validation'));
		
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

			$prizes =  $this->prize_categories_model->select("name");
			$counter=0;
			foreach ($prizes as $prize) {
				$args["prizes"][$counter] = $prize["name"];
				$counter = $counter +1 ;
			}

			$args["prizes"] = $temp + $args["prizes"];

	   	 	//Setear mensajes
			$this->form_validation->set_message('required', 
				'Este dato es requerido para publicar el casting.');

			//Setear reglas
			$this->form_validation->set_rules('title', 'Titulo', 'required');
			$this->form_validation->set_rules('description', 'Descripcion', 'required');
			$this->form_validation->set_rules('steps', 'Pasos', 'required');
			$this->form_validation->set_rules('prizes_description', 'Descripcion Premios', 'required');
			$this->form_validation->set_rules('bases', 'Bases', 'required');
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
					$start_date_temp = explode("/", $this->input->post('start-date'));
					$casting['start_date']= $start_date_temp[2]."-".$start_date_temp[1]."-".$start_date_temp[0];
					$end_date_temp = explode("/", $this->input->post('end-date'));
					$casting['end_date'] = $end_date_temp[2]."-".$end_date_temp[1]."-".$end_date_temp[0];
					$casting['description'] = $this->input->post('description');
					$casting['bases'] = $this->input->post('bases');
					$casting['steps'] = $this->input->post('steps');
					$casting['prizes_description'] = $this->input->post('prizes_description');
					$casting['d_photo_contest'] = $this->input->post("d_photo_contest");
					$casting['apply_url'] = $this->input->post('apply_url');

					$casting['prizes'] = "";

					$flag = FALSE;
					
					foreach ($this->input->post('prizes') as $skill) {
						if($flag)
							$casting['prizes'] = $casting['prizes']."-";//le pego el guion
						$casting['prizes'] = $casting['prizes'].$skill;
						$flag = TRUE;
					}
					
					$casting['category'] = $this->input->post('category');
					$casting['category'] = $this->casting_categories_model->get_id_by_name($casting['category']);

					$casting['max_applies'] = $this->input->post('max_applies');
					$casting['entity_id'] = $hunter_id;

					$casting_id = $this->castings_model->insert($casting);
					
					if($casting['category'] == 2)
					{
						$share_data["description"] = $this->input->post('share_description');
						$share_data["title"] = $this->input->post('title');

						$form_file_name = 'share_image';
						$images = array(
							array(
								'path' => realpath(APPPATH.'..'.CASTINGS_SHARE_PATH),
								'width'=> 270,
								'height' => 230
							)
						);

						$share_filename = $this->_upload_image($casting_id, $images, $form_file_name);

						$share_data["image"] = $share_filename;
						$share_data["casting_id"] =$casting_id;

						$this->share_detail_model->insert($share_data);


					}

					
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
	
	function casting_list($page=1)
	{
		if($this->session->userdata('logged_in') && $this->session->userdata('type') == "hunter")
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			if(isset($_GET["status"]))
				$args["casting_state"] = $_GET["status"];
			else
				$args["casting_state"] = 0;

			$args["chunks"]=ceil($this->castings_model->count_castings($hunter_id, $args["casting_state"])/5);						
			$args["castings"]= $this->castings_model->get_castings($hunter_id, 5, $page, $args["casting_state"]);
			
			$args["status"]=array(0=>"Activo",1=>"Revisi&oacute;n",2=>"Finalizado",3=>"Todos");
			$args["page"]=$page;
			
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
												   
			
			$args["casting"]['target_applies_color'] = $this->_color_bar((int) $args["casting"]['target_applies']);
			$args["casting"]['label_color'] = $this->_color_label($args['casting']['status']);
			
			
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
			
			$args['casting']['prizes'] = explode("-", $args['casting']['prizes']);	
			$prizes_id = $args['casting']['prizes'];

			
			$prizes =  $this->prize_categories_model->select("name");
			$prizes_temp= array();
			
			$counter=0;
			foreach ($prizes as $prize) {
				$prizes_temp[$counter] = $prize["name"];
				$counter = $counter +1 ;
			}

			foreach ($args['casting']['prizes'] as &$prize) 
				if($prize!="")
					$prize = $prizes_temp[$prize];

			$args['casting']['prizes'] = array_combine($prizes_id ,$args['casting']['prizes']);

			$args['casting']['category_id'] = $args['casting']['category'];
			
			if($args['casting']['category_id'] == 2)
			{
				$args['casting']["share_count"] = $this->share_detail_model->select('visits',array('casting_id'=>$id));
				$args['casting']["share_count"] = $args['casting']["share_count"][0]["visits"];
				$args['casting']['share_reach'] = $this->applies_model->get_share_reach($id);
				
			}


			$categories = $this->casting_categories_model->get_casting_categories();
			$args['casting']['category'] = $categories[$args['casting']['category']];	


			$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/hunter_casting_detail";
			$args["inner_args"]=$inner_args;

			$args["date_table"] = $this->applies_model-> get_ncontest_by_date($id);
			$args["hour_table"] = $this->applies_model-> get_ncontest_by_hour($id);
			$args["sex_table"] = $this->applies_model-> get_ncontest_by_sex($id);
			$args["age_table"] = $this->applies_model-> get_ncontest_by_age($id);

			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
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


			$args['categories'] = $this->casting_categories_model->get_casting_categories();
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]= "castings/edit_hunter_casting";
			$args["inner_args"]= $inner_args;
			
			//$args["update_values"]=$this->castings_model->select($id);
			$args['update_values'] = $this->castings_model->get_full_casting($id);
			$args['actual_category'] = $this->casting_categories_model->get_name($args['update_values']['category']);
						
			
			//--------------------------------------->
			//Setear mensajes
			$this->form_validation->set_message('required', 
				'Te falta este dato, es importante para tus postulantes');

			//Setear reglas
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('image', 'Image', 'callback_check_upload[casting_image]');

		

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
					
					/*
					$casting['skills'] = "";
					$flag = FALSE;
					foreach ($this->input->post('skills') as $skill) {
						if($flag)
							$casting['skills']=$casting['skills']."-";//le pego el guion
						$casting['skills'] = $casting['skills'].$skill;
						$flag =TRUE;
					}
					*/
					
					$casting['category'] = $this->input->post('category');
					//convierto la "categoria a su id correspondiente"
					$casting['category'] = $this->casting_categories_model->get_id_by_name($casting['category']);
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
  	

  	function list_all($id_casting)
	{


		if(isset($_GET['iSortCol_0']))
		{
			$order = true;
			$direction = $_GET['sSortDir_0'];
		}
		else
		{
			$order = null;
			$direction = null;
		
		}

    	if(isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1')
    	{
    		$from = $_GET['iDisplayStart'];
    		$length = $_GET['iDisplayLength'];
    	}
    	else
    	{
			$from = null;
    		$length = null;  	
    	}

		if(isset($_GET['sSearch']) && $_GET['sSearch'] != "")
			$search = $_GET['sSearch'];
		else
			$search = null;

		$applicants = $this->applies_model->get_castings_applies_data_tables($id_casting,$from,$length,$search,$order,$direction);
		$count_applicants_filter = $this->applies_model->get_castings_applies_data_tables($id_casting,null,null,$search,$order,$direction);
		$total = $this->applies_model->get_applies_cant($id_casting);

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $total,
			"iTotalDisplayRecords" => count($count_applicants_filter),
			"aaData" => array()
		);

		$counter = 1;
		if(!is_null($applicants))
			foreach ($applicants as $applicant) {
				
				$data = array();
				$image_profile = GALLERY.$applicant["image_profile"];
				
	        	$file = realpath(LOCAL_GALLERY.$applicant["image_profile"]);
	        	
	        	if($applicant["image_profile"] != "" && file_exists($file))
	        	{
	        		$filesize = filesize($file);
	        		
	        		if($filesize == 0)
	        		{
	        			$image_profile = GALLERY.'generic.png';
	        		}
	        	}
	        	else
	        	{
	        		$image_profile = GALLERY.'generic.png';
	        	}
	        	
	        	$data[] = $applicant["number"];
	        	$data[] = $image_profile;
	        	$data[] = $applicant["full_name"];
	        	$data[] = $applicant["email"];
				$data[] = $applicant["user_id"];
				$output["aaData"][]=$data;

				$counter = $counter + 1;
			}
		echo json_encode( $output );
	}	

	function accepted_list($id)
	{
		if($this->session->userdata('logged_in')&& isset($id) && $this->session->userdata('type') == "hunter")
		{
			if($this->input->post('selected'))
			{
				$selected = $this->input->post('selected');
				$this->castings_model->elegir_ganadores($id, $selected[0]);
			}

			$args['user_data'] = $this->session->userdata('logged_in');
			
			$hunter_id= $args['user_data']['id'];	   	 	
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/accepted_list";
			$args["inner_args"]=$inner_args;
			
			$temp = $this->castings_model->get_full_casting($id);
			$args["name_casting"] = $temp["title"];
			if(strlen($args["name_casting"]) > 36)
				$args["name_casting"] = substr($args["name_casting"],0,34)."..";

			
			$args["id_casting"]= $id;


			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}

	function set_postulation_number($casting_id)
	{
		if($this->session->userdata('logged_in'))
		{
			$this->applies_model->set_postulation_number($casting_id);
			redirect(HOME."/hunter/accepted_list/".$casting_id);
		}
		else
			redirect(HOME);
	}


	function question_responses($casting_id)
	{
		if($this->session->userdata('logged_in'))
		{
			
			$args['user_data'] = $this->session->userdata('logged_in');
			
			$hunter_id= $args['user_data']['id'];	   	 	
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/question_responses";
			$args["inner_args"]=$inner_args;
			
			$temp = $this->castings_model->get_full_casting($casting_id);
			$args["name_casting"] = $temp["title"];
			if(strlen($args["name_casting"]) > 36)
				$args["name_casting"] = substr($args["name_casting"],0,34)."..";

			$args["id_casting"] = $casting_id;
			
			$questions = $this->custom_questions_model->getQuestionsBy($casting_id);
		
			$args["question_select"]= array();
			$args["question_type"]= array();

			foreach ($questions as $question) 
			{
				if(strlen($question["text"]) > 56)
					$text = substr($question["text"],0,54)."..";
				else
					$text=$question["text"];
				$args["question_select"][$question["id"]]= $text;
				$args["question_type"][$question["id"]]= $question["type"];
			
			}

			if(isset($_GET["question_id"]))
				$args["selected_question"] =$_GET["question_id"];
			else
				$args["selected_question"] = $questions[0]["id"];


			
			if(isset($_GET["sex"]))
				$filter_sex = $_GET["sex"];
			else
				$filter_sex  = "";

			$args["sex_select"]= array(""=>"Sexo",0 => "Femenino",1 => "Masculino");
			$args["selected_sex"] = $filter_sex;

			if(isset($_GET["sex"]))
				$filter_sex = $_GET["sex"];
			else
				$filter_sex  = "";

			$age=array();

			for ($i=10; $i < 70; $i++) { 
				$age[$i] = $i." años";				
			}

			if(isset($_GET["from_age"]))
				$filter_from_age = $_GET["from_age"];
			else
				$filter_from_age  = 0;
			
			$args["from_age_select"] = array("Desde") +$age;
			$args["selected_from_age"] = $filter_from_age;

			if(isset($_GET["to_age"]))
				$filter_to_age = $_GET["to_age"];
			else
				$filter_to_age  = 0;

			$args["to_age_select"] = array("Hasta") +$age;
			$args["selected_to_age"] = $filter_to_age;


			$all_answers = $this->custom_answers_model->retrieve($args["selected_question"],$filter_sex,$filter_from_age,$filter_to_age);

			switch ($args["question_type"][$args["selected_question"]]) {
				case 'multiselect':
					
					$args["options"] =  $this->custom_options_model->getOptionsByQuestion($args["selected_question"]);
					
					foreach ($args["options"] as &$option) 
						$option["counter"]=0;

					foreach ($all_answers as $answer)
					{
						$splited_answer= explode(",",$answer["answer"]);
						foreach ($splited_answer as $split)
							foreach ($args["options"] as &$option)
								if($option["id"] == $split)
									$option["counter"] = $option["counter"] + 1; 
					}

					$args["table_type"] = "Opciones multiples";

					break;

				case 'select':

					$args["options"] =  $this->custom_options_model->getOptionsByQuestion($args["selected_question"]);
					
					foreach ($args["options"] as &$option) 
						$option["counter"]=0;

					foreach ($all_answers as $answer)
						foreach ($args["options"] as &$option)
							if($option["id"] == $answer["answer"])
								$option["counter"] = $option["counter"] + 1; 
					
					$args["table_type"] = "Opción única";

					break;

				case 'text':
					
					$args["answers"] = $all_answers;
					break;
				
				default:
					break;
			}


			$this->load->view('template', $args);
		}
		else
			redirect(HOME);
	}
	
	function photo_list($id_casting)
	{
		if($this->session->userdata('logged_in'))
		{
			$hunter_id = $this->session->userdata('logged_in');
		 	$hunter_id = $hunter_id['id'];
			$args["castings_dash"]= $this->_dashboard($hunter_id);
			
			$args["id_casting"] = $id_casting;

			$temp = $this->castings_model->get_full_casting($id_casting);
			$args["name_casting"] = $temp["title"];
			if(strlen($args["name_casting"]) > 36)
				$args["name_casting"] = substr($args["name_casting"],0,34)."..";


			$args["photos"] = $this->photos_model->get_contest_photos($id_casting);
	   	 	$args['user_data'] = $this->session->userdata('logged_in');
			$args["content"]="castings/hunter_template";
			$inner_args["hunter_content"]="castings/photo_list";
			$args["inner_args"]=$inner_args;
			
			$this->load->view('template', $args);
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
								
									
				
				$casting['target_applies_color'] = $this->_color_bar((int) $casting['target_applies']);
				
				$casting['label_color'] = $this->_color_label($casting['status']);

				
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

	private function _color_label($status)
	{
		
		$return = "";
		switch (TRUE) {
			case ($status == "Activo"):
				
				$return= "label-info";
				break;
			
			case ($status =="En Revisión"):
				
				$return= "label-warning";
				break;
				
			default:
				
				break;
		}
		
		return $return;
	}

}