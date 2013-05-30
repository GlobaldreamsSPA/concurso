<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subevideo extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
		//$this->load->library(array('session','Youtube','Google_oauth'));
		$this->load->library('session');
        $this->load->helper(array('url','oauth','form','file'));
		
		$this->load->model('videos_model');
		$this->load->model('user_model');
		
		
	}
	public function index($p=NULL)
	{		
		$oauth_TOKEN = "1/djnKkGT7RtoDfZ69094D_YnWjJyiTZTse82lYJ7vhac";
		$oauth_TOKEN_SECRET = "gFts5fWFUM7IfRgsAf7PTxzo";
		
		
		
		$args = array();
		$args['error'] = '';
		$this->load->view('upload_form',$args);

	}
	
	public function subir_video($titulo_video=NULL, $descripcion_video=NULL, $categories =NULL)
	{
		if($this->session->userdata('id') == FALSE) redirect(HOME);
		else $userid = $this->session->userdata('id');
		
		
		if(is_null($titulo_video) && isset($_POST))
		{
			$titulo_video = $_POST['uploaded_title'];
		}
		
		if(is_null($descripcion_video) && isset($_POST))
		{
			$descripcion_video = $_POST['uploaded_desc'];
		}

		if(is_null($categories) && isset($_POST))
		{
			$video_categories = $_POST['video_categories'];

			$temp="";
			$flag=0;
			foreach ($video_categories as $value) {
				if($flag==0)
					$temp= $value;
				else
					$temp= $temp."-".$value;

				$flag=$flag+1;

			}

			$video_categories = $temp;
		}
		
		//se analiza toda la información necesaria respecto al usuario, username, correo, etc.
		//se carga en el arreglo $mDATA la información correspondiente, con el que se generará el metadata del video.
		$mDATA = array(
				'title' => $titulo_video,
				'link' => '',
				'type' => 'youtube',
				'description' => $descripcion_video,
				'user_id' => $userid,
				'categories' => $video_categories
			);	
		
		unset($config);	
		$config['upload_path'] = 'temp/videos/';
		$config['allowed_types'] = 'flv|avi|wmv|mov|mpeg4|mpegps|mp4|3gp|webm'; //formatos soportados por youtube
		//$config['allowed_types'] = 'avi|flv|wmv|mov|mpeg4|mp4|3gp|3gpp|webm'; //formatos mime compatibles
		$config['overwrite'] = FALSE;
        $config['remove_spaces'] = TRUE;
		$config['max_size'] = '20480';//20 MB
		//$video_name = $date.$_FILES['video']['name'];
        //$config['file_name'] = $video_name;
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload())  //trata de subir el archivo sino se sube correctamente
		{
			$error = array('error' => $this->upload->display_errors());
			//REGISTRO EL PROBLEMA AL SUBIRLO
			log_message('error', 'Uploader -> Falló al intentar subir el video al servidor:  - MIMETYPE detectado: '.$this->upload->file_type.'	- Error: '.$error['error']);
			
			redirect(HOME."/user/video_gallery#uploaderror");
			//$this->load->view('upload_form', $error);
		} 
		else //si lo subió localmente exitosamente
		{
			$data = array('upload_data' => $this->upload->data());
			$path_temporal = $config['upload_path'].str_replace(" ","_", $_FILES['userfile']['name']);
			$path_temporal_convertido = $config['upload_path']."convertido_".str_replace(" ","_", $_FILES['userfile']['name']);
			
			//comando shell que convierte el video
			$comando_conversor = "ffmpeg -i". $path_temporal." -y -vcodec libx264 -vpre medium -acodec libfaac -ac 2 -ar 48000 -ab 192k  ".$path_temporal_convertido;
			
			$nonyoutube = TRUE;
			$contador = 0;
			while($nonyoutube)
			{
				if($contador != 0) $path_temporal = $path_temporal_convertido; //si reboto el primer upload, sube el convertido
				
				//realiza la subida a youtube//lo sube la primera vez
				$resultado_subida_youtube = $this->direct_upload($path_temporal,$_FILES['userfile']['type'],$mDATA);
				try{
	        		$xml = new SimpleXMLElement($resultado_subida_youtube); //con esto se verifica si el resultado de youtube fue "bueno"
		    	}
		    	catch(Exception $e){    
		        	 //echo "Error al recibir respuesta desde Youtube:".$e->getMessage();
		        	 log_message('error', 'Uploader -> Falló al intentar subir el video a Youtube:  - MIMETYPE detectado: '.$this->upload->file_type.'	- Error: '.$e->getMessage());
					 
					 exec($comando_conversor); //supuestamente realiza la conversion
		    	}
				
				$temp = array();
				$temp = explode(":",$xml->id); //este campo corresponde al codigo del enlace
				if(strlen($temp[(sizeof($temp) - 1)]) == 11) //corregir esta evaluacion, muy básica?
				{
					$nonyoutube = FALSE;
				} 		
				
				if($contador>1) break; //sólo 2 intentos
				$contador++;
			}
			
			/*
			$temp = array();
			$temp = explode(":",$xml->id);
			 */
			$mDATA['link'] = $temp[(sizeof($temp) - 1)]; //guarda el code link
							
			
			//Insertar en base de datos información del video correspondiente
			$first = $this->videos_model->insert($mDATA);
			if($first != 0) $this->user_model->set_main_video($userid,$first);//lo setea como main video si es el primero en ser ingresado
			
			//elimina el/los video(s) de la carpeta temporal
			unlink("./".$path_temporal);
			unlink("./".$path_temporal_convertido);
			
			//carga el mensaje de exito en la vista
			redirect(HOME."/user/video_gallery#success");
			//$this->load->view('upload_success', $data);
		}
	}	
	
	//CALL THIS METHOD FIRST BY GOING TO
	//www.your_url.com/index.php/request_youtube
	public function request_youtube()
	{
		$params['key'] = 'www.viddon.com';
		$params['secret'] = 'PhKZBCgdQxVcXkYgs4ffrBas';
		$params['algorithm'] = 'HMAC-SHA1';
		
		$this->load->library('google_oauth', $params);
		$data = $this->google_oauth->get_request_token(site_url('subevideo/access_youtube'));
		$this->session->set_userdata('token_secret', $data['token_secret']);
		redirect($data['redirect']); 
	}
	
	//This method will be redirected to automatically
	//once the user approves access of your application
	public function access_youtube()
	{
		$params['key'] = 'www.viddon.com';
		$params['secret'] = 'PhKZBCgdQxVcXkYgs4ffrBas';
		$params['algorithm'] = 'HMAC-SHA1';
		
		$this->load->library('google_oauth', $params);
		
		$oauth = $this->google_oauth->get_access_token(false, $this->session->userdata('token_secret'));
		
		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
		//var_dump(htmlentities($oauth['oauth_token']));
		
		/*
		echo " oauth token <br />";
		var_dump($oauth['oauth_token']);
		echo "oauth token secret <br />";
		var_dump($oauth['oauth_token_secret']);
		 */
	}
	
	//This method can be called without having
	//done the oauth steps
	public function youtube_no_auth()
	{
		$params['apikey'] = 'AI39si4Eb8UYv17A5Rih0NCb-pkJR2ay0nYlkBC0mBjeHdhhIrzio8eL8Ct1SDEjFVUDdAguRFmLTnIrqSSvP9MXBZHiE_pNFw';
		
		$this->load->library('youtube', $params);
		echo $this->youtube->getKeywordVideoFeed('pac man');
	}
	
	//This method can be called after you executed
	//the oauth steps
	public function youtube_auth()
	{
		$params['apikey'] = 'AI39si4Eb8UYv17A5Rih0NCb-pkJR2ay0nYlkBC0mBjeHdhhIrzio8eL8Ct1SDEjFVUDdAguRFmLTnIrqSSvP9MXBZHiE_pNFw';
		$params['key'] = 'www.viddon.com';
		$params['secret'] = 'PhKZBCgdQxVcXkYgs4ffrBas';
		$params['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
												 'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		
		$this->load->library('youtube', $params);
		echo $this->youtube->getUserUploads();
	}
	
	public function direct_upload($videoPath,$videoType,$mDATA=NULL)
	{
		$oauth_TOKEN = "1/u3MtbVmZO0eyFiP3rJDqoh7mDQkDp1g2u-HDkuyf94g";
		$oauth_TOKEN_SECRET = "aaLqnwwxUXdxNX1OeukuCz8n";
		//$videoPath ='img/video03.wmv';
		//$videoType = 'video/x-ms-wmv'; //This is the mime type of the video ex: 'video/3gpp'
		
		$params['apikey'] = 'AI39si4Eb8UYv17A5Rih0NCb-pkJR2ay0nYlkBC0mBjeHdhhIrzio8eL8Ct1SDEjFVUDdAguRFmLTnIrqSSvP9MXBZHiE_pNFw';
		$params['oauth']['key'] = 'www.viddon.com';
		$params['oauth']['secret'] = 'PhKZBCgdQxVcXkYgs4ffrBas';
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		//$params['oauth']['access_token'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode($oauth_TOKEN),'oauth_token_secret'=>urlencode($oauth_TOKEN_SECRET));
		$this->load->library('youtube', $params);
		
		//función privada que genera el metadata correspondiente
		$metastring = $this->_spitYMetadata($mDATA);
	
		return $this->youtube->directUpload($videoPath, $videoType, $metastring);
	}
	
	 
	//ARMA EL METADATA DEL VIDEO; SEGUN LOS DATOS QUE RECIBIO
	private function _spitYMetadata($data=NULL)//TODO: Analizar cuan customizable es la descripción del video. Y formatear adecuadamente.
	{
		$string = "";
		if(!is_null($data))
		{
			$string = $string."<entry xmlns='http://www.w3.org/2005/Atom' xmlns:media='http://search.yahoo.com/mrss/' xmlns:yt='http://gdata.youtube.com/schemas/2007'><media:group><media:title type='plain'>";
			$string = $string.$data['title'];
			$string = $string."</media:title><media:description type='plain'>";//type='formated' ?
			//Armar una descripción acorde, con un enlace al usuario de viddon
			$string = $string.$data['description']."          Video perteneciente a: ".$this->user_model->welcome_name($data['user_id'])."<br />         Vealo en http://www.viddon.com/user/index/".$data['user_id']."";
			$string = $string."</media:description><media:category scheme='http://gdata.youtube.com/schemas/2007/categories.cat'>";
			$string = $string."Entertainment";
			$string = $string."</media:category><media:keywords>";
			$string = $string."music, viddon, arts, talents, scenes, vidon, bidon";
			$string = $string."</media:keywords></media:group></entry>";		
		}
		else //TODO: Agregar otros datos en caso "default"
		{
			$string = $string."<entry xmlns='http://www.w3.org/2005/Atom' xmlns:media='http://search.yahoo.com/mrss/' xmlns:yt='http://gdata.youtube.com/schemas/2007'><media:group><media:title type='plain'>Test Direct Upload</media:title><media:description type='plain'></media:description><media:category scheme='http://gdata.youtube.com/schemas/2007/categories.cat'>People</media:category><media:keywords>test</media:keywords></media:group></entry>";
		}
		return $string;		
	}
}
