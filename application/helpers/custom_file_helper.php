<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('upload'))
{
	/*
		$images_path: la ruta donde se guardará el archivo: realpath(APPPATH.<UPLOAD_DIR>);
		$filename: el nombre del archivo mas la extension: file.jpg
		$type: extension del archivo: .jpg
		$allowed_types: los tipos aceptados: 'jpg|jpeg|gif|png'
		$form_file_name: el nombre del elemento file: name="image_profile"
	*/

	function upload_file($images_path, $id, $type, $allowed_types, $form_file_name)
	{
		$this->load->helper('file');

		$filename = $id. '.' .$type[1];
		
		$config = array(
			'allowed_types' => $allowed_types,
			'upload_path' => $images_path,
			'file_name' => $filename,
			'overwrite' => TRUE,
			'max_size' => 2048,
			'remove_spaces' => TRUE
		);
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload($form_file_name))
		{
			print_r($this->upload->display_errors());
		}
	}
}