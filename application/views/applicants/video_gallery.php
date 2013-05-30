<style>
.glow {
 background-color: #FFF;
 -webkit-box-shadow: 3px 3px 2px rgba(50, 50, 50, 0.43); -moz-box-shadow:    3px 3px 2px rgba(50, 50, 50, 0.43); box-shadow:         3px 3px 2px rgba(50, 50, 50, 0.43);
 margin-bottom: 1%;
}

.chzn-container,
.chzn-container .chzn-drop,
.chzn-container .default {
    width: 100% !important;
}
</style>

<div class="modal fade hide"  style="padding-right: 1%; padding-left: 0.3%" id="playermodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div style="padding: 0px;" class="modal-body">
  </div>
</div>

<div class="row-fluid">		
	<div class="span3 user-profile-left">
		<div class="row">
		<?php 

			if(!$public)
				echo "<a href= '".HOME."/user/photo_gallery/'>";

			if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
				echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
			else
				echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
			
			if(!$public)
				echo "</a>";

		?>
		</div>
		<div class="space2"></div>
		<div class="row">
			<?php if(!$public) {?>
			<form action="" method="POST">
				<?php if($postulation_flag) {?>
				<a href="<?php echo HOME.'/home/casting_list'?>" class="btn btn-success" type="submit" name="apply">POSTULAR CASTINGS</a>
				<input type="hidden" name="validate" value="1"/>
				<?php } else{ ?>
				<button data-toggle="modal"  href="#error" class="btn btn-success">POSTULAR CASTINGS</button>
    			<?php } ?>
    		</form>
    		<?php } ?>
		</div>
		<?php if(!$public) {?>
		<div class="row">
    		<div class="span9 offset1">					    			
    			<ul class="nav nav-pills nav-stacked orange">
					<li class="active"><a href="<?php echo HOME."/user/";?>"> <i class="icon-user"></i> Perfil</a>
					</li>
					<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
					<li>
						<a data-toggle="collapse" href="#collapseOne">
							<i class="icon-star-empty"></i> Postulaciones
						</a>
						<div id="collapseOne" class="collapse">
							<ul style="padding-left: 30px;" class="nav nav-pills nav-stacked orange">
								<li><a href="<?php echo HOME."/user/active_casting_list"?>">Activas</a></li>	
								<li><a href="<?php echo HOME."/user/results_casting"?>">Resultados</a></li>	
							</ul>
						</div>
					</li>	
					<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
				</ul>
			</div><!--NAVEGACION LATERAL IZQUIERDA -->
		</div>
		<?php } ?>
	</div>

    <div class="span8 offset1 user-profile-right"> <!-- CARGAREMOS LOS DATOS DE LA GALERIA -->
		<div class="row">
			<div class="span8">
	    	<h2>
	    	<?php if(!$public) {?>
	    		<a href="<?php echo HOME."/user"?>">
	    	<?php } 
	    	else {?>
	    		<a href="<?php echo HOME."/user/index/".$user_id?>">
	    	<?php }?>
	    	Perfil</a> 
	    	
	    	/ Galeria de videos
	    	</h2>
			</div>
			<?php if(!$public) {?>

			<div style="margin-top:15px;" class="span4">
					<button data-toggle="modal"  href="#add_video" class="btn btn-primary">Agregar Video</button>
			</div>
			<?php } ?>
			<legend></legend>
		</div>

    	<!-- CARGO EL MODAL-->
			<div id="add_video" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="AgregaVideo" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Agregar video</h3>
					</div>
					<div class="modal-body">
							<ul class="nav nav-tabs">
							  <li class="active"><a href="#enlazar" data-toggle="tab">Desde Youtube</a></li>
							  <li><a href="#pc" data-toggle="tab">Desde tu PC</a></li>
							</ul>
							
							<div class="tab-content">
							  <div class="tab-pane active" id="enlazar">
							  	<form id="video_upload_form" action="<?php echo HOME.'/user/'?>" method="post">
							  		<div style="padding:2%;"class="row">
								  		<div class="span6">	
											<input name="url_ytb" style="width:96%" type="text" placeholder="Dirección - URL video" value="" required="required">											
											<input name="name_ytb" style="width:96%" type="text" placeholder="Titulo del video">
											<?php echo form_multiselect('video_categories[]', $video_categories_list, null,"class='chzn-select chosen_filter' data-placeholder='Selecciona las categorias...'"); ?>
											<div class="space1"></div>
											<div style="margin-top: 1%; font-size: 95%;"class="justify">
 												Debes pegar la dirección URL de tu video. La que se aprecia en la barra del navegador	Ej:   
 												<ul>
 													<li>http://www.youtube.com/watch?v=LautYzjYv3A</li>
 													<li>http://youtu.be/LautYzjYv3A</li>
 												</ul>
 											</div>	
										</div>
										<div class="span6">	
											<h4 style="line-height: 18px; margin: 0; margin-bottom: 2%;">Descripci&oacute;n</h4>
											<textarea class="rich_textarea_pop_up" name="description_ytb" rows="6" placeholder="Descripción"></textarea>
											<input type="hidden" name="from_gallery" value="yes" />
											<div class="space1"></div>	
											<button type="submit" class="btn btn-primary">Subir</button>
											<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							  			</div>
							  		</div>
							  	</form>
							  </div>
							  <div class="tab-pane" id="pc">
							  	<?php 
							  		$this->load->view('upload_form'); 
							  	?>
							  </div>
							</div>
							<div class="justify" style="-webkit-box-shadow: 3px 3px 2px rgba(50, 50, 50, 0.43); -moz-box-shadow:    3px 3px 2px rgba(50, 50, 50, 0.43); box-shadow:         3px 3px 2px rgba(50, 50, 50, 0.43);background-color:#e5e5e5; padding:1%; font-size:82%;">*Si tienes una cuenta de gmail te recomendamos intentar subir tu video utilizando Youtube, para luego enlazarlo (pestaña "desde youtube"), desde el siguiente enlace: <a href="http://www.youtube.com/upload" target="_blank">Youtube Upload</a>. Si tienes algún problema, <a href="mailto:contacto@viddon.com">Cont&aacutectanos</a>.</div>
					</div>
					<!-- 
					<div class="modal-footer" style="height: 30px;">
					</div>
					-->
			</div>    	
		<!-- MODAL-->
    	
    	<?php
    	//video[0] => titulo
    	//video[1]=> link
    	//video[2]=> descripcion
    	//video[3] => id del video
    	$i=0;
    	foreach($videos as $video){
    		
		?>	
    		<!-- CARGO EL MODAL PARA EDITAR EL VIDEO-->
			<div id="edit_video_<?php echo $video[3];?>" class="modal hide fade" style="width: 430px !important;" tabindex="-1" role="dialog" aria-labelledby="EditaVideo" aria-hidden="true">
				<form id="video_edit_form_<?php echo $video[3];?>" action="<?php echo HOME.'/user/video_gallery/'?>" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Editar video</h3>
					</div>
					<div class="modal-body">
							<div>	
								<input name="nombre_video_edit" style="width:96%" type="text" value="<?php echo $video[0];?>" placeholder="Nombre">
								<?php 
							
								echo form_multiselect('video_categories_edit[]', $video_categories_list, $video[5],"class='chzn-select chosen_filter' data-placeholder='Selecciona las categorias...'"); ?>
								<div class="space1"></div>	
								<textarea class="rich_textarea_pop_up" name="description_video_edit" rows="6" placeholder="Descripción"><?php echo $video[2];?></textarea>
								<input type="hidden" name="id_editando" value="<?php echo $video[3];?>" />
								<div class="space1"></div>	
							</div>
					</div>
					<div class="modal-footer" style="height: 30px;">
						<button type="submit" class="btn btn-primary">Actualizar</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					</div>
				</form>
			</div>    	
			<!-- MODAL EDICION-->
			
    	<?php
    		
    		$i++;
			if($i%2 == 0 )								
    			if($video[3] == $id_main_video) echo '<div style="padding:8px;" title="Video Principal" class="span6 glow">'; //carga el efecto de "brillo"
				else echo '<div style="padding:8px;" class="span6">';	
			else
				{
				echo '<div class="space1"></div>';
				echo '<div class="row">';
				if($video[3] == $id_main_video) echo '<div style="padding:8px;" title="Video Principal" class="span6 glow">';//carga el efecto de "brillo"
				else echo '<div style="padding:8px;" class="span6">';
				}		
				
    	?>
    			
    			<div style="margin-left:2%;" class="row">
						<div style="min-height: 15px !important;" class="span9">
							<label style="font-size: 120%;" id="profile" ><?php echo substr(strip_tags($video[0]),0,18).".."; ?></label>
						</div>
						<?php if(!$public) {?>
							<div class="span1">
								<a id="editing_tagevent" class="btn-del" title="Editar Información" data-toggle="modal"  href="#edit_video_<?php echo $video[3];?>" class="btn btn-primary"><i class="icon-edit"></i></a>
							</div>
							<div class="span1">
								<a class="btn-del" title="Establecer como principal" href="<?php echo HOME.'/user/video_gallery/'.$user_id.'/'.$page.'/1/'.$video[3];?>" class="btn btn-primary"><i class="icon-star-empty"></i></a>
							</div>
							<div style="visibility:hidden;" id="idvideo" value="<?php echo $video['3'];?>"></div>
							<div style="margin-left: 5px;" class="span1">
								<a class="btn-del" title="Eliminar video" href="<?php echo HOME.'/user/video_gallery/'.$user_id.'/'.$page.'/2/'.$video[3];?>" class="btn btn-primary"><i class="icon-remove"></i></a>
							</div>
							
						<?php } ?>
				</div>

				<a href="<?php echo HOME.'/home/video?id='.urlencode($video[1]).'&id_bdd='.urlencode($video[3]).'&video_reproductions='.urlencode($video[4]).'&name='. urlencode($video[0]).'&iduser='.urlencode($user_id).'&username='.urlencode($name).'&description='.urlencode($video[2]).'&userlastname='.urlencode($last_name).'&image='.urlencode($image_profile_name) ?>" data-target="#playermodal" data-toggle="modal">							
					<div class="image">
						<div>
						<img class="fade_new" src="<?php echo 'http://img.youtube.com/vi/'.$video[1].'/0.jpg'; ?>" alt=""/>
						</div>
						<img class="hoverimage" src="<?php echo HOME.'/img/player_arrow.png'; ?>" alt="" />
					</div>
				</a>
				
			</div>
	    <?php 
		if($i%2 == 0 )								
    			echo '</div>';	
		if($i%2 != 0 && $i == count($videos))
				echo '</div>';	
			
		}?>	
		<div class="row-fluid">
	        <div class="space1"></div>
		        <div class="pagination">  
		            <ul id="pagination_bt">
		                <li <?php if($page==1) echo "class='disabled'";?> ><a <?php if($page!=1) echo "href= '".base_url()."user/video_gallery/".$user_id."/".($page-1)."/'";?>>Prev</a></li>  
		                <?php 
		    	            
		                $pag_size = 6; //se puede fijar una constante que lo maneje
						$margen = $pag_size/2;
						
						$begin_pag = $page - $margen;
						if($begin_pag < 0) $begin_pag = 1;
						
						$end_pag = $page + $margen;
						if($end_pag > $chunks) $end_pag = $chunks;
						
					 
		                for($i = $begin_pag; $i <= $end_pag; $i++) 
		                { ?>
		                	<li <?php if($page==$i) echo "class='disabled'";?> ><a <?php if($page!=$i) echo "href= '".base_url()."user/video_gallery/".$user_id."/".$i."/'";?> > <?php echo $i; ?></a></li>  
		                <?php } ?>
		                <li <?php if($page==$chunks) echo "class='disabled'";?> ><a <?php if($page!=$chunks) echo "href= '".base_url()."user/video_gallery/".$user_id."/".($page+1)."/'";?>>Next</a></li>
		            </ul>  
		        </div>  
	        <div class="space1"></div>  
   		</div>    
	</div>
	
</div>
	
	

	
