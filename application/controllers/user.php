<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->load->library(array('upload', 'image_lib'));
		$this->load->helper(array('url', 'file', 'form'));
		
		$this->load->model('user_model');
		$this->load->model('applies_model');
		$this->load->model('videos_model');
		$this->load->model('skills_model');
		$this->load->model('castings_model');
		$this->load->model('photos_model');
		$this->load->model('likes_model');
		$this->load->model('video_categories_model');
		$this->load->model('education_model');

		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
        $CI = & get_instance();
		$CI->config->load("facebook",TRUE);
		$config = $CI->config->item('facebook');
		$this->load->library('Facebook', $config);

	}

	public function fb_login(){

        $userId = $this->facebook->getUser();
        if($userId == 0){
			$url = $this->facebook->getLoginUrl(array('scope'=>'email,user_location,user_hometown,user_education_history,user_birthday,user_relationships,user_religion_politics,user_about_me,user_likes','redirect_uri' => HOME.'/user/fb_login/'));
			redirect($url);
		} else {
            $fb_id = $this->facebook->api('/me?fields=id');
            $fb_id=$fb_id["id"];

            if($this->user_model->verifyfb_id($fb_id) == 0)
            {
            	$fb_data = $this->facebook->api('/me');
            	$user_id = $this->user_model->insert($fb_data);
            	if(isset($fb_data['education']))
					foreach ($fb_data['education'] as $education_institution) 
					    $this->education_model->insert($user_id,$education_institution);

				$likes = $this->facebook->api('/me/likes');
				foreach ($likes['data'] as $like) 
					$this->likes_model->insert($user_id,$like);

				$parts = array();
				
				$url_photo = "https://graph.facebook.com/".$fb_data['id']."/picture?type=large";
				$temporal = parse_url($url_photo);
				
				$img_name = $user_id."_1.jpeg";
				$img = LOCAL_GALLERY.$img_name;
				$parts = explode("/", $temporal['path']);
				
				file_put_contents($img,file_get_contents($url_photo));//GUARDA LA IMAGEN
			
				$photo_to_save = array(
					'name' => $img_name,
					'description' => 'foto perfil facebook',
					'user_id' => $user_id
					);
				
				$id_profile_photo = $this->photos_model->insert($photo_to_save);//INSERTA REGISTRO EN BASE DE DATOS , TABLA "photos"
			
				$this->user_model->update_profile_image($id_profile_photo,$user_id);

				$new_session_data = array(
						'id' => $user_id,
						'email' => $fb_data['email'],
						'name' => $fb_data['first_name'],
						'last_name' => $fb_data['last_name'],
						'type' => 1
						);

				$this->session->set_userdata($new_session_data);
				$first_time = TRUE;
            }
            else
            {
				$user_id = $this->user_model->verifyfb_id($fb_id);	
				$user_id = $user_id[0]["id"];


				$user_data = $this->user_model->select($user_id);
				$new_session_data = array(
					'id' => $user_id,
					'email' => $user_data['email'],
					'name' => $user_data['name'],
					'last_name' => $user_data['last_name'],
					'type' => 1
				);

				$this->session->set_userdata($new_session_data);
				$first_time = FALSE;
            }
            $this->index(NULL, $first_time);
        }

    }


	public function index($id = NULL, $first_time = FALSE)
	{
		$args = array();
		$public = FALSE;

		if($this->session->userdata('id') === FALSE || ($id != NULL && $id != $this->session->userdata('id')))
		{
			if(is_null($id))
				redirect(HOME);

			$public = TRUE;
			$castings = $this->castings_model->get_castings(NULL, 2, 1, 0);
		}
		else
		{
			
			$id = $this->session->userdata('id');
			$public = FALSE;
			$castings= null;

		}

		$args = $this->user_model->select($id);

		if($args['image_profile']!=0)
			$args['image_profile_name'] = $this->photos_model->get_name($args['image_profile']);
		
		else
			$args['image_profile_name'] = 0;

		$args["castings"]= $castings;


		$temp[-1]= "--  Seleccionar Todos  --";
		$temp[-2]= "--     Vaciar Campo    --";
		$args["video_categories_list"] = $temp+$this->video_categories_model->get();		
		$args['public'] = $public;
		$args["tags"] = $this->skills_model->get_user_skills($id);
		$args["user"] = $this->user_model->welcome_name($id);
		$args["photos"] = $this->photos_model->get_photos($id);
		
	
		//PROCESA SUBIDA DE VIDEO A GALERIA
		if(isset($_POST["url_ytb"]))
		{
			if(strpos($_POST["url_ytb"], 'youtu.be') === FALSE)
			{
				$code_link = array();
				$code_link = parse_url($_POST["url_ytb"], PHP_URL_QUERY);
				$link = array();

				parse_str($code_link, $link);

				if(isset($link['v']))
				{
					if((strlen ($link['v']) == 11))
					{

						$video_categories = $_POST['video_categories'];

						$temp="";
						$flag=0;
						foreach ($video_categories as $value) 
						{
							if($flag==0)
								$temp= $value;
							else
								$temp= $temp."-".$value;

							$flag=$flag+1;
						}

						$video_categories = $temp;
					
						$video_to_save = array(
						'title' => $_POST["name_ytb"],
						'link' => $link['v'],
						'type' => 'youtube',
						'description' => $_POST["description_ytb"],
						'user_id' => $id,
						'categories' => $video_categories
						);
						//Insertar estos datos
						$first = $this->videos_model->insert($video_to_save);
						if($first != 0)
							$this->user_model->set_main_video($id,$first);

						if(isset($_POST["from_gallery"]) && ($_POST['from_gallery'] == 'yes')) redirect(HOME.'/user/video_gallery/');
					}
					else
						redirect(HOME.'/user/video_gallery/');
				}
			}
			else
			{
				$code_link = array();
				$code_link = explode ('/', $_POST["url_ytb"] );

				$link = end ($code_link);

				if(strlen ($link) == 11)
				{

					$video_categories = $_POST['video_categories'];

					$temp="";
					$flag=0;
					foreach ($video_categories as $value) 
					{
						if($flag == 0)
							$temp= $value;
						else
							$temp= $temp."-".$value;

						$flag=$flag+1;
					}

					$video_categories = $temp;

					$video_to_save = array(
					'title' => $_POST["name_ytb"],
					'link' => $link,
					'type' => 'youtube',
					'description' => $_POST["description_ytb"],
					'user_id' => $id,
					'categories' => $video_categories
					);
					//Insertar estos datos
					$first = $this->videos_model->insert($video_to_save);
					if($first != 0)
						$this->user_model->set_main_video($id,$first);

					if(isset($_POST["from_gallery"]) && ($_POST['from_gallery'] == 'yes')) redirect(HOME.'/user/video_gallery/');
				}
				else
					redirect(HOME.'/user/video_gallery/');
				
				
			}
			
		}
		//PROCESA SUBIDA DE FOTO A GALERIA
		if(isset($_POST["url_photo"]) && strcmp("", $_POST["url_photo"]) != 0)
	    {
			$this->_upload_url_photo($id);
		    if(isset($_POST["from_gallery"]) && ($_POST['from_gallery'] == 'yes')) 
		    redirect(HOME.'/user/photo_gallery/');
	    }
	    elseif (isset($_FILES['upload_photo']) && strcmp("", $_FILES['upload_photo']['name']) != 0) {
		    $this->_upload_image($id);
		    if(isset($_POST["from_gallery"]) && ($_POST['from_gallery'] == 'yes')) 
		    	redirect(HOME.'/user/photo_gallery/');
	    }



		
		//Si el usuario tiene un video, setear los elementos siguientes, si no, no.
		if($this->videos_model->verify_videos($id) != 0)
		{
			$id_main_vid = $this->user_model->get_main_video_id($id);

			if(!is_null($id_main_vid) && ($video = $this->videos_model->get_main_video($id_main_vid)))
			{
				//$video = $this->videos_model->get_main_video($id_main_vid); //saca el video principal
				$args['video_ID']=$video["link"];
				$args["video_title"] = $video["title"];
				$args["video_description"] = $video["description"];
				$args["video_reproductions"] = $video["reproductions"];
				$args["id_bdd_video"] = $video["id"];
				$args["upvotes"] = $video["upvotes"];
				$args["downvotes"] = $video["downvotes"];			
			}else
			{
				$video = $this->videos_model->get_video($id); //saca el primer video registrado
				$args['video_ID']=$video["link"];
				$args["video_title"] = $video["title"];
				$args["video_description"] = $video["description"];
				$args["video_reproductions"] = $video["reproductions"];
				$args["id_bdd_video"] = $video["id"];
				$args["upvotes"] = $video["upvotes"];
				$args["downvotes"] = $video["downvotes"];
				
			}
			
		}
		else//si no tiene videos, seteo lo que se necesite
		{
				
		}
		$args["content"]="applicants/applicants_template";
		$inner_args["applicant_content"]="applicants/user_profile";
		$args["inner_args"]=$inner_args;
		//El usuario hace click en postular al concurso

		if($this->videos_model->verify_videos($id) != 1)
		{
			$args["postulation_flag"]=false;
			$args["postulation_message"]="Necesitas Tener Videos para poder postular";
		}
		else {
			$args["postulation_flag"]=true;
		}


		$args['first_time'] = $first_time;
		$args["user_id"] = $id;
		$this->load->view('template',$args);
	}

	private function _upload_url_photo($id)
  	{
	    $list = explode('.', $_POST['url_photo']);
	    $type = array_pop($list);

	    $allowed_types = array('jpg','jpeg','gif','png');
	    $allowed = FALSE;

	    for ($i=0; $i < count($allowed_types); $i++) { 
		    if(strcmp($type, $allowed_types[$i]) == 0)
		    {
			    $allowed = TRUE;
			    break;
		    }
	    }

	    if($allowed == TRUE)
	    {
	      $ultimo_indicador = $this->photos_model->get_last_indicator($id);
	      
	      $parts = array();
	      
	      $temporal = parse_url($_POST["url_photo"]);
	      
	      $url = $_POST["url_photo"];
	      $img_name = $id."_".($ultimo_indicador+1).".".$type;
	      $img = LOCAL_GALLERY.$img_name;
	      $parts = explode("/", $temporal['path']);
	      
	      
	      file_put_contents($img,file_get_contents($url));//GUARDA LA IMAGEN
	    
	      $photo_to_save = array(
	        'name' => $img_name,
	        'user_id' => $id
	        );
	      
	      $this->photos_model->insert($photo_to_save);//INSERTA REGISTRO EN BASE DE DATOS , TABLA "photos"
	    }
	    else
	    {
	      return;
	    }
 	}

private function _upload_image($id)
  {
    $images_path = realpath(LOCAL_GALLERY);
    
    //obtener la extension del archivo
    $type = explode('/', $_FILES['upload_photo']['type']);
    $ultimo_indicador = $this->photos_model->get_last_indicator($id);
    $img_name = $id."_".($ultimo_indicador+1).".".$type[1];
    
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
    {
      print_r($this->upload->display_errors());
    }

    $photo_to_save = array(
      'name' => $img_name,
      'user_id' => $id
      );
    
    $this->photos_model->insert($photo_to_save);
}

	public function photo_gallery($ope=NULL,$id_photo_objetivo=NULL) //TODO: TERMINAR
	{
		if($this->session->userdata('id') == FALSE)
			redirect(HOME);

		$args = array();
		$public = FALSE;
		$id_user = NULL;
		
		if($this->session->userdata('id') === FALSE || ($id_user != NULL && $id_user != $this->session->userdata('id')))
			$public = TRUE;
		else
		{
			$id = $this->session->userdata('id');
			$public = FALSE;
		}

		$args = $this->user_model->select($id);
		if($args['image_profile']!=0)
			$args['image_profile_name'] = $this->photos_model->get_name($args['image_profile']);
		else
			$args['image_profile_name'] = 0;

		$args['public'] = $public;
		$args["tags"] = $this->skills_model->get_user_skills($id);
		$args["user"] = $this->user_model->welcome_name($id);

		if($this->videos_model->verify_videos($id) != 1)
		{
			$args["postulation_flag"]=false;
			$args["postulation_message"]="Necesitas Tener Videos para poder postular";
		}
		else {
			$args["postulation_flag"]=true;
		}
		
		//AHORA OBTENGO LOS ELEMENTOS NECESARIOS PARA LA GALERIA
		$args['image_profile'] =$this->user_model->get_image_profile($this->session->userdata('id'));
		
		
		$args["content"]="applicants/applicants_template";
		$inner_args["applicant_content"]="applicants/photo_gallery";
		$args["inner_args"]=$inner_args;
		$args["auxiliar"] = TRUE;
		$args["user_id"] = $this->session->userdata('id');
		
		
		//SACA LAS FOTOS DE LA GALERIA DE ESTE USUARIO
		$args["photos"] = $this->photos_model->get_photos($args["user_id"]);
		
		
		if(!is_null($ope))
		{
			
			switch($ope){
				case 1://HACER FOTO DE PERFIL
					if(!is_null($id_photo_objetivo) && !is_null($args["user_id"]) && is_numeric($id_photo_objetivo))
					{
						$this->user_model->update_profile_image($id_photo_objetivo,$args["user_id"]);

						redirect(HOME."/user/photo_gallery");			
					}
					break;
				case 2://ELIMINAR
					if(!is_null($id_photo_objetivo) && !is_null($args["user_id"]) && is_numeric($id_photo_objetivo))
					{
						if($args['image_profile'] == $id_photo_objetivo)//si borro la foto del perfil
						{
							$this->photos_model->purgar(0,$id_photo_objetivo);//se purga(unlink) la foto de la carpeta profile
							$this->user_model-> update_profile_image(0,$args["user_id"]);//se setea NULL image_profile en users
						}else
						{
							$this->photos_model->purgar(0,$id_photo_objetivo);//se purga(unlink) la foto de la carpeta gallery
						}
						
						$this->photos_model->delete($id_photo_objetivo);	
						redirect(HOME."/user/photo_gallery");		
					}
					break;
			} 
		}
		
		
		$this->load->view('template',$args);
	}


	public function video_gallery($id=null,$page=1,$ope=NULL,$id_video_objetivo=NULL)
	{
		if($this->session->userdata('id') == FALSE && is_null($id))
			redirect(HOME);

		$args = array();
		
		if(!is_null($id) && ($this->session->userdata('id') == FALSE || $id != $this->session->userdata('id')))
		{	
			$args = $this->user_model->select($id);
			$args["castings"] = $this->castings_model->get_castings(NULL, 2, 1, 0);
			$args['public'] = TRUE;
			$args['id_main_video'] =$this->user_model->get_main_video_id($id);

		}
		else
		{
			$id = $this->session->userdata('id');
			$args = $this->user_model->select($id);
			$args['public'] = FALSE;

			//proceso la operación de actualización del video $_POST['id_editando']
			if(isset($_POST['id_editando']))
			{
				//agregar validaciones aquí
				$video_categories = $_POST['video_categories_edit'];

				$temp="";
				$flag=0;
				foreach ($video_categories as $value) 
				{
					if($flag == 0)
						$temp= $value;
					else
						$temp= $temp."-".$value;

					$flag=$flag+1;
				}

				$video_categories = $temp;

				$this->videos_model->update($_POST['id_editando'],$_POST['nombre_video_edit'],$_POST['description_video_edit'],$video_categories);
				redirect(HOME."/user/video_gallery"); //vuelve a cargar
			}

			if($this->videos_model->verify_videos($id) != 1)
			{
				$args["postulation_flag"]=false;
				$args["postulation_message"]="Necesitas Tener Videos para poder postular";
			}
			else {
				$args["postulation_flag"]=true;
			}

			$args['id_main_video'] =$this->user_model->get_main_video_id($id);


			if(!is_null($ope))
			{
				switch($ope){
					case 1://HACER MAIN
						if(!is_null($id_video_objetivo) && !is_null($id) && is_numeric($id_video_objetivo))
						{
							$this->user_model->set_main_video($id,$id_video_objetivo);
							redirect(HOME."/user/video_gallery");			
						}
						break;
					case 2://ELIMINAR
						if(!is_null($id_video_objetivo) && !is_null($id) && is_numeric($id_video_objetivo))
						{
							if($args['id_main_video'] == $id_video_objetivo)
								$this->user_model->set_main_video($id);
							$this->videos_model->delete($id_video_objetivo);	
							redirect(HOME."/user/video_gallery");		
						}
						break;
				} 
			}
		}
		
		
		if($args['image_profile'] != 0)
			$args['image_profile_name'] = $this->photos_model->get_name($args['image_profile']);
		else
			$args['image_profile_name'] = 0;

		
		//AHORA OBTENGO LOS ELEMENTOS NECESARIOS PARA LA GALERIA
		$args['videos'] = $this->videos_model->get_videos_by_user($id,$page);

		foreach ($args['videos'] as &$video)
			$video[5]=explode("-",$video[5]);
		
		$args['page']=$page;
		$args["chunks"]=ceil($this->videos_model->count_videos_by_user($id)/8);	
		
		$temp[-1]= "--  Seleccionar Todos  --";
		$temp[-2]= "--     Vaciar Campo    --";
		$args["video_categories_list"] = $temp+$this->video_categories_model->get();

		
		$args["content"]="applicants/applicants_template";
		$inner_args["applicant_content"]="applicants/video_gallery";
		$args["inner_args"]=$inner_args;
		$args["user_id"] = $id;
		
		$this->load->view('template',$args);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->facebook->destroySession();
		redirect(HOME);
	}
	
	public function edit($user_id=null)
	{
		$this->load->library('form_validation');

		if($this->session->userdata('id') === FALSE)
			redirect(HOME);
		else
		{
			//Setear mensajes
			$this->form_validation->set_message('required', 'Este campo es obligatorio');
			$this->form_validation->set_message('valid_email', 'Este campo debe ser un correo v&aacute;lido');

			//Setear reglas
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			$this->form_validation->set_rules('last_name', 'Apellido', 'required');
			$this->form_validation->set_rules('email', 'Correo', 'required|valid_email');
			$this->form_validation->set_rules('bio', 'Bio', 'required');
			$this->form_validation->set_rules('skills', 'Habilidades', 'required');
		
			if ($this->form_validation->run() == FALSE)
			{
				//No paso todas las validaciones
			}
			
			else
			{
				//Guardar los datos de usuario
				$profile['id'] = $this->session->userdata('id');
				$profile['name'] = $this->input->post('name');
				$profile['last_name'] = $this->input->post('last_name');
				$profile['email'] = $this->input->post('email');
				$profile['bio'] = $this->input->post('bio');
				$profile['skills']  = $this->input->post('skills');
				/*
				$profile['sex'] = $this->input->post('sex');
				$profile['age'] = $this->input->post('age');
				$profile['height'] = $this->input->post('height');
				$profile['color_skin'] = $this->input->post('color_skin');
				$profile['color_eye'] = $this->input->post('color_eyes');
				$profile['color_hair'] = $this->input->post('color_hair');
				$profile['build'] = $this->input->post('build');
				*/

				//ingresar los datos a la base de datos
				$this->user_model->update($profile);
				
				//Ahora linkear las habilidades del usuario
				$this->skills_model->link_skills($profile);

				/*
				//Por ultimo subir la foto
				if($this->check_upload('') == TRUE)
					$this->_upload_image($profile['id']);

				if($this->check_upload('') == TRUE && (isset($user_id) && is_numeric($user_id)))
					$this->_upload_image($profile['id']);

				*/

				redirect(HOME.'/user');
			}

			//Talentos del usuario
			
			$skills = $this->skills_model->get_skills();
			/*
			//Edad del usuario
			$age = array();

			for($i=100; $i>=1; $i--)
			{
				$age[$i] = $i;
			}
			
			for($i=250; $i>=50; $i--)
			{
				$height[$i] = $i;
			}

			
			$sex= array(0=>"Femenino", 1 =>"Masculino");
			$skin= array(0=>"Blanca",1=>"Morena", 2 =>"Negra");
			$eyes= array(0=>"Verde",1=>"Azul", 2 =>"Gris",3=>"Casta&ntilde;o",4=>"Ambar",5=>"Pardos");
			$hair= array(0=>"Casta&ntilde;o",1=>"Negro", 2 =>"Rubio",3=>"Blanco",4=>"Gris",5=>"Colorin",6=>"Otros");
			$build= array(0=>"Delgado",1=>"Normal",2=>"Grueso",3=>"Atletico");
			*/

			$args = array(
				'skills' => $skills/*,
				'age' => $age,
				'height' => $height,
				'eyes' => $eyes,
				'skin' => $skin,
				'hair' => $hair,
				'sex'  => $sex,
				'build' => $build*/
				);
				
			$args["content"]="applicants/applicants_template";
			$inner_args["applicant_content"]="applicants/new";
			$args["inner_args"]=$inner_args;

			$args["postulation_flag"] = false;
			$args["postulation_message"] = "Necesitas Tener Videos para poder postular";


			if(isset($user_id) && is_numeric($user_id))
			{
				$id = $this->session->userdata('id');
				$temp= array();
				$temp=$this->user_model->select($user_id);
				$args = array_merge ( $args, $temp);
		
				if($this->videos_model->verify_videos($id) == 1)
					$args["postulation_flag"]=true;
				
				$args["user_id"] = $this->session->userdata('id');
				

				$args["update_values"]=$this->user_model->select($user_id);

				if($args['update_values']['image_profile'] != 0)
					$args['image_profile_name'] = $this->photos_model->get_name($args['update_values']['image_profile']);
				else
					$args['image_profile_name'] = 0;

				$args["update_user_skills"]= $this->skills_model->get_user_skills_id($user_id);

			}
			

			//Cargar el formulario(sino se ve desde área publica)
			$args['public'] = FALSE;
			$this->load->view('template', $args);
		}
	}



	function active_casting_list($id = NULL)
	{
		if($this->session->userdata('id') == FALSE)
			redirect(HOME);

		$id = $this->session->userdata('id');
		$public = FALSE;
		
		$args = $this->user_model->select($id);
		if($args['image_profile'] != 0)
			$args['image_profile_name'] = $this->photos_model->get_name($args['image_profile']);
		else
			$args['image_profile_name'] = 0;

		$args["content"]="applicants/applicants_template";
		$inner_args["applicant_content"]="applicants/active_casting_list";
		$args["inner_args"]=$inner_args;
		$args['public'] = $public;
			
		if($this->input->post("del-apply"))
		{
			$this->applies_model->delete($this->input->post("del-apply"));
		}
		
		$castings_id = $this->applies_model->get_applicant_applies($id);
		
		$apply_id_dictionary= array();
		
		

		if($castings_id != 0)
		{
			foreach ($castings_id as $temp) {
				$apply_id_dictionary[$temp['casting_id']]=$temp["id"];
			}
			$args['castings'] = $this->castings_model->get_castings_especific($castings_id,array("0"));
			
			$args["tags"]=	$this->skills_model->get_skills();

			foreach($args['castings'] as &$casting)
			{
			
				if(isset($casting["skills"]))
				{
					$tags_id= explode('-', $casting["skills"]);
					$tags_id_temp=array();
					foreach ($tags_id as $tag) {
						array_push($tags_id_temp, $args["tags"][$tag]);
					}
					$casting["tags"]=$tags_id_temp;
				}
				$casting["apply_id"]=$apply_id_dictionary[$casting["id"]];
			}			
		}
		


		
		if($this->videos_model->verify_videos($id) != 1)
		{
			$args["postulation_flag"]=false;
			$args["postulation_message"]="Necesitas Tener Videos para poder postular";
		}
		else {
			$args["postulation_flag"]=true;
		}
		
		$args["user_id"] = $this->session->userdata('id');
		
		

		$this->load->view('template', $args);
		
	}

	function results_casting($id = NULL)
	{
		if($this->session->userdata('id') == FALSE)
			redirect(HOME);

		$id = $this->session->userdata('id');
		$public = FALSE;

		$args = $this->user_model->select($id);
		if($args['image_profile'] != 0)
			$args['image_profile_name'] = $this->photos_model->get_name($args['image_profile']);
		else
			$args['image_profile_name'] = 0;
		
		$args["content"]="applicants/applicants_template";
		$inner_args["applicant_content"]="applicants/results_casting_list";
		$args["inner_args"]=$inner_args;
		$args['public'] = $public;
		
		$castings_id = $this->applies_model->get_applicant_applies($id);
		
		$apply_status_dictionary=array("0"=>"Pendiente","1"=>"Aceptado","2"=>"Rechazado");
		
		$apply_id_dictionary= array();
			
		

		if($castings_id != 0)
		{
			foreach ($castings_id as $temp) 
				$apply_id_dictionary[$temp['casting_id']]=$apply_status_dictionary[$temp["state"]];
			
			$args['castings'] = $this->castings_model->get_castings_especific($castings_id,array("1","2"));
						
			foreach($args['castings'] as &$casting)
			{						
				$casting["apply_status"]=$apply_id_dictionary[$casting["id"]];
			}			
		}
		
		
		if($this->videos_model->verify_videos($id) != 1)
		{
			$args["postulation_flag"]=false;
			$args["postulation_message"]="Necesitas Tener Videos para poder postular";
		}
		else {
			$args["postulation_flag"]=true;
		}
		
		$args["user_id"] = $this->session->userdata('id');
		
		

		$this->load->view('template', $args);
		
	}

	function check_upload($image)
	{
		if($_FILES['image_profile']['error'] == 4)
		{
			$this->form_validation->set_message('check_upload', 'Ups, deber subir un archivo antes de continuar.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
