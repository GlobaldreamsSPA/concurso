<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->load->library(array('upload', 'image_lib'));
		$this->load->helper(array('url', 'file', 'form'));

		//Modelos
		$this->load->model(array('share_apply_model','share_detail_model','prize_categories_model','contact_model','photos_model','user_model', 'hunter_model', 'castings_model','applies_model','casting_categories_model','custom_options_model','custom_questions_model', 'custom_answers_model'));
	
	}

	public function index($page=1)
	{
		if(!$this->input->get('success_message'))
			$success_message = NULL;
		else
			$success_message = $this->input->get('success_message');
		
		$args = array();
		$args["get_uri"] ="";
		
		if(isset($_GET["search_terms"]))
		{
			$args["get_uri"] = "/?search_terms=".str_replace(' ', '+', $_GET["search_terms"])."&prize=".$_GET["prize"]."&category=".$_GET["category"];
			$args["search_values"]=$_GET;
			$args["contest_list"] = $this->castings_model->get_castings_search($_GET, $page, 6);
			$args["chunks"]=ceil(count($this->castings_model->get_castings_search($_GET)) / 6);
		}
		else
		{
			$args["search_values"]["search_terms"] = NULL;
			$args["search_values"]["prize"] = NULL;
			$args["search_values"]["category"] = NULL;		
			$args["contest_list"]  = $this->castings_model->get_castings_search($args["search_values"],$page, 6);
			$args["chunks"] = ceil(count($this->castings_model->get_castings_search($args["search_values"])) / 6);
		}		
    	
		$args["page"]=$page;

		$prizes =  $this->prize_categories_model->select("name");
		$counter=0;

		foreach ($prizes as $prize) {
			$args["prizes"][$counter] = $prize["name"];
			$counter = $counter + 1;
		}

		$args["bottom_contest"] = $this->castings_model->get_castings(null,null,null,0,array(0));

		$args["prizes"] = array(""=>"Elige: tipo de premio") + $args["prizes"];
		$args['categories'] = array(""=>"Elige: tipo de concurso")+$this->casting_categories_model->get_casting_categories();
		
		if(!is_null($success_message))
			$args["success_message"] = $success_message;

		$args["ganando_promo"] = true;
		$args["inner_args"] = NULL;
		$args["content"] = "home/home_view";

		$this->load->view('template',$args);
	}

	public function company()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_message('required', 'Este campo es obligatorio');
		$this->form_validation->set_message('valid_email', 'Este campo debe ser un correo v&aacute;lido');

		$this->form_validation->set_rules('contact_name', 'Nombre', 'required|xss_clean');
		$this->form_validation->set_rules('contact_email', 'Correo', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('contact_message', 'Mensaje', 'required|xss_clean');

		if($this->form_validation->run() != FALSE)
		{
			$data= array();
			$data["nombre"] =$_POST["contact_name"];
			$data["email"] =$_POST["contact_email"];
			$data["mensaje"] =$_POST["contact_message"];

			$this->contact_model->insert($data);

			$args["flag"]=true;
		}

		$args["company"]=true; /*Se setea para hacer seo distinto a la pagina para empresas*/

		$args['content'] = 'home/login_hunter';
		
		$args["inner_args"] = NULL;

		
		$this->load->view('template',$args);
	}

	public function what_is()
	{
		$args['content'] = 'home/what_is';	
		$args["inner_args"]=NULL; /*Se setea para hacer seo distinto*/
		$args['about']= true;
		$this->load->view('template',$args);
	}

	public function contest()
	{
		if(isset($_GET['id']))
		{
			$categories = $this->casting_categories_model->get_casting_categories();
			
			$args['id_casting'] = $_GET['id'];		
			$args['title'] = $_GET['title'];		
			$args['entity'] = $_GET['entity'];
			$args['days'] = $_GET['days'];	
			$args['logo'] = $_GET['logo'];		
			$args['description'] = $_GET['description'];
			$args['steps'] = $_GET['steps'];	
			$args['prizes_description'] = $_GET['prizes_description'];	
			$args['bases'] = $_GET['bases'];		
			$args['full_image'] = $_GET['full_image'];
			$args['category'] = $categories[$_GET['category']];	
			$args['category_id'] = $_GET['category'];
			$args['d_photo_contest'] = $_GET['d_photo_contest'];
			$args['status'] = $_GET['status'];

			$args['logged_in'] = $this->session->userdata('id');

			$args['entity_id'] = $_GET['entity_id'];	
			$args['prizes'] = explode("-", $_GET['prizes']);	
			$prizes_id = $args['prizes'];
			
			$prizes =  $this->prize_categories_model->select("name");
			$prizes_temp= array();
			
			$counter=0;
			foreach ($prizes as $prize) {
				$prizes_temp[$counter] = $prize["name"];
				$counter = $counter +1 ;
			}

			foreach ($args['prizes'] as &$prize) 
				if($prize!="")
					$prize = $prizes_temp[$prize];

			$args['prizes'] = array_combine($prizes_id ,$args['prizes']);


			
			if ($args["status"]=="En Revisión") 
				$this->load->view('home/contest_modal_r',$args);
			elseif ($args["status"]=="Finalizado")
			{ 
				$args["contest_winner"]["id"] = $this->applies_model->get_selected($args['id_casting']);
				$args["contest_winner"]["id"] = $args["contest_winner"]["id"][0]["user_id"];
				$args["contest_winner"]["image"] = $this->user_model->get_image_profile($args["contest_winner"]["id"]);
				$args["contest_winner"]["image"] = $this->photos_model->get_name($args["contest_winner"]["image"]);
				$args["contest_winner"]["name"] = $this->user_model->get_name($args["contest_winner"]["id"]);
				$args["contest_winner"]["name"] = $args["contest_winner"]["name"][0]["name"]." ".$args["contest_winner"]["name"][0]["last_name"];
				$this->load->view('home/contest_modal_f',$args);
			}
			else
			{
				if( !in_array($args['category_id'],array(1,2,3,4)))
					$args['apply_url'] = $_GET['apply_url'];
				else
				{
					if($args['category_id']==2)
					{
						if($args['logged_in'])
						{
							$share_data= $this->share_detail_model->select('*',array('casting_id'=>$args['id_casting']));
							$share_data =$share_data[0];
							$args['apply_url'] = "https://www.facebook.com/dialog/feed?app_id=458089044282863&link=".HOME."/home/share_counter/".$_GET['id']."?url=".urlencode($_GET['apply_url'])."&picture=".urlencode(HOME.CASTINGS_SHARE_PATH.$share_data['image'])."&name=".urlencode($share_data['title'])."&caption=".$_GET['apply_url']."&description=".urlencode($share_data['description'])."&redirect_uri=".HOME."/home/apply_share/".$args['id_casting'];
							$args['target'] = true;
						}
						else
							$args['apply_url'] = "none";
					}
					elseif($args['category_id'] == 1)
					{
						if($args['logged_in'])
						{
							$args['apply_url'] = "photo";
						}
						else
							$args['apply_url'] = "none";
					}
					elseif($args['category_id'] == 3 || $args['category_id'] == 4)
					{
						if($args['logged_in'])
						{
							if($args['category_id'] == 3)
								$args['apply_url'] = "trivia";
							else
							{
								$args['apply_url'] = "video";
								$args['video_id'] = $_GET['apply_url'];
							}

							//Aca se recuperan las preguntas personalizadas
							$custom_questions = $this->custom_questions_model->getQuestionsBy($args['id_casting']);
							$custom_options = array();

							if($custom_questions != 0)
							{
								for($i =0; $i < count($custom_questions); $i++)
								{
									$custom_options[$i] = array('id' => $custom_questions[$i]['id'], 'type' => $custom_questions[$i]['type'], 'text' => $custom_questions[$i]['text'], 'options' => array());
									$opciones = $this->custom_options_model->getOptionsByQuestion($custom_questions[$i]['id']);

									if((!$opciones == 0))
									{
										//hay opciones
										foreach ($opciones as $option) {
											$custom_options[$i]['options'][] = array('id' => $option['id'], 'option' => $option['option']);	
										}
									}
								}

								$args['custom_options'] = $custom_options;
							}
						}
						else
							$args['apply_url'] = "none";
					}
					else
						$args['apply_url'] = "none";
				}	
				
				$this->load->view('home/contest_modal',$args);
			}
		}
	}

	public function share_counter($id)
	{
		//Guardar la visita en la BD
		$this->share_detail_model->increase_counter($id);

		//Redirigir al sitio apply_url
		redirect("http://".$_GET["url"]);
	}



	public function terms()
	{
		$args['content'] = 'home/terms';		
		$args["inner_args"] = NULL;
		$this->load->view('template',$args);
	}


	/* Funcion utilizada para guardar las postulaciones de concursos de trivia y video */
	public function apply_trivia($id)
	{
		if($this->session->userdata('id'))
		{	
			$has_participated = $this->applies_model->verify_apply($this->session->userdata('id'), $id);


			if(!$has_participated)
			{
				$apply_id = $this->applies_model->apply($this->session->userdata('id'), $id);

				$success_message = "¡Felicitaciones! Ya estás participando en el concurso";
				
				//Ahora guardas las preguntas custom
				foreach($this->input->post() as $post_data_name => $post_data_answ)
				{
					$data = explode("_", $post_data_name);
					
					if(strcmp($data[1], "text") == 0 || strcmp($data[1], "select") == 0)
					{
						$answers['custom_questions_id'] = $data[3];
						
						if(strcmp($post_data_answ, "") != 0)
							$answers['answer'] = $post_data_answ;
						else
							$answers['answer'] = "omite";

						$this->custom_answers_model->save($answers, $apply_id);
					}
					if(strcmp($data[1], "multiselect") == 0)
					{
						$answers['custom_questions_id'] = $data[3];
						$answers['answer'] = "";
						
						foreach ($post_data_answ as $answ) {
							if(strcmp($answ,"") != 0)
								$answers['answer'] = $answers['answer'].$answ.", ";
						}
						
						$answers['answer'] = substr($answers['answer'], 0, -2);
						$this->custom_answers_model->save($answers, $apply_id);
					}
				}

				redirect(HOME."/home?success_message=".$success_message);
			}
			else
			{
				$success_message = "Ya estás participado en el concurso, sólo puedes postular una vez";
				redirect(HOME."/home?success_message=".$success_message);
			}
		}
		else	
			redirect(HOME."/home");
	}

	public function apply_share($id)
	{
		if($this->session->userdata('id') && isset($_GET['post_id']))
		{
			$has_participated = $this->applies_model->verify_apply($this->session->userdata('id'), $id);

			if(!$has_participated)
			{
				$apply_id = $this->applies_model->apply($this->session->userdata('id'), $id);
				$this->share_apply_model->insert(array('apply_id'=>$apply_id,'post_id'=>$_GET['post_id']));
				$success_message = "¡Felicitaciones! Ya estás participando en el concurso";
				redirect(HOME."/home?success_message=".$success_message);
			}
			else
			{
				$success_message = "Ya estás participado en el concurso, sólo puedes postular una vez";
				redirect(HOME."/home?success_message=".$success_message);
			}
		}
		else
			redirect(HOME."/home");
	}



	public function apply_photo($id)
	{
		if($this->session->userdata('id') && $_FILES['upload_photo']['error'] != 4)
		{
			$has_participated = $this->applies_model->verify_apply($this->session->userdata('id'), $id);
 
			if(!$has_participated)
			{
				if($this->_upload_image($this->session->userdata('id'),$id,$_POST["foto_description"]))
				{
					$this->applies_model->apply($this->session->userdata('id'), $id);
					$success_message = "¡Felicitaciones! Ya estás participando en el concurso";
					redirect(HOME."/home?success_message=".$success_message);
				}
				else
				{
					$success_message = "Hay problemas con el archivo subido, intenta con otro";
					redirect(HOME."/home?success_message=".$success_message);
				}
			}
			else
			{
				$success_message = "Ya estás participado en el concurso, sólo puedes postular una vez";
				redirect(HOME."/home?success_message=".$success_message);
			}
		}
		else
			redirect(HOME."/home");
	}

	private function _upload_image($id_user,$id_casting,$description)
	{
	    $images_path = realpath(APPPATH.CONTEST_PHOTO_DIR);
	    
	    //obtener la extension del archivo
	    $type = explode('/', $_FILES['upload_photo']['type']);
	    $img_name = $id_user."_".$id_casting.".".$type[1];
	    
	    $config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $images_path,
			'file_name' => $img_name,
			'overwrite' => TRUE,
			'max_size' => 2048,
			'remove_spaces' =>TRUE
	    );
	    
	    $this->upload->initialize($config);
	    
	    if(!$this->upload->do_upload('upload_photo'))
	    	return false;
	    else
	    {
	    	$photo_to_save = array(
			'name' => $img_name,
			'description' => $description,
			'user_id' => $id_user,
			'casting_id' => $id_casting
			);

			$this->photos_model->insert($photo_to_save);
			return true;
	    }
	}
}