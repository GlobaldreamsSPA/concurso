<style>

.chzn-container,
.chzn-container .chzn-drop,
.chzn-container .default {
    width: 100% !important;
}
</style>

<script>
$(document).ready(function(){
	$('.upvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes').html(votes[0]);
			$('#downvotes').html(votes[1]);

		}) 
	})
});

$(document).ready(function(){
	$('.downvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes').html(votes[0]);
			$('#downvotes').html(votes[1]);

		}) 
	})
});

</script>

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
				<li class="active"><a> <i class="icon-user"></i> Perfil</a>
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
		</div>
	</div>
	<?php } ?>
</div>

<div class="span8 offset1 user-profile-right">
		
	<div class="space1"></div>
	
	<?php if($public) { ?>
		<div class="row">
			<div class="span9">
	<?php } ?>
				<h2 class="profile-title"> <?php echo $name." ".$last_name; ?></h2>
	<?php if($public) { ?>
			</div> 
			<div style="margin-top: 3%" class="span3">
				<a href="<?php echo HOME.'/user/video_gallery/'.$user_id?>" style="width:70% !important;"class="btn btn-primary" type="submit" name="apply">
					<i class="icon-film"></i> Galeria
				</a>
			</div>
		</div>
	<?php } ?>

	<div style="margin-left: 10px;" class="fb-like" data-href="<?php echo HOME.'/user/index/'.$user_id; ?>" data-send="true" data-width="450" data-show-faces="false"></div>				
		<?php
			echo '<ul class="skills-list">';
			foreach ($tags as $tag) {
				echo '<li> <a href="#">'.$tag.'</a></li>';
			}
			echo '</ul>';
		?>
		<div class="space1"></div>
		<h3 id="profile">Con&oacute;ceme</h2>
		<div class="justify profile-content"><?php echo $bio;?></div>
		<div class="space1"></div>
				

		<legend style="font-weight: bold;">Video Principal</legend>
		<?php if(isset($video_ID)){?>
			<div class="video-title">
				
				<?php if(!$public) { ?>
				<div class="span9">
				<?php } ?>

				<label style="font-size: 110%;"id="profile" ><?php echo $video_title;?></label>
				
				<?php if(!$public) { ?>
				</div>
				<div style="margin-top: -1%" class="span3">

						<a href="<?php echo HOME.'/user/video_gallery/'?>" style="width:70% !important;"class="btn btn-primary" type="submit" name="apply">
							<i class="icon-film"></i> Galeria
						</a>
				</div>
				<?php } ?>
		

			</div>


			<iframe style="margin-top: 5px;" width="100%" height="300" src="http://www.youtube.com/embed/<?php echo $video_ID."?rel=0";?>" frameborder="0" allowfullscreen></iframe>
			<div class="space05"></div>
			<div style="padding-left:2%; padding-top:2%;">
				<div class="span5">
					<a class="upvote vote" href="<?php echo HOME.'/home/vote/1/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/upgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/upwhite.png" ?>'/> <p id="upvotes" style="display:inline;"><?php echo $upvotes;?></p></a>  
					<a class="downvote vote" href="<?php echo HOME.'/home/vote/0/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/downgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/downwhite.png" ?>'/> <p id="downvotes" style="display:inline;"><?php echo $downvotes;?></p></a>  
				</div>
				<div class="span7" style="text-align: right">
					<p style="font-weight:bold;">Reproducciones: <?php echo $video_reproductions; ?></p>
				</div>
			</div>
			<div style= "overflow-y: scroll; min-height: 110px;"class="justify"><?php echo $video_description;?></div>
					
		<?php 
		} 
		else
		{?>
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
									
			<div style="padding-left: 38%; background-color: black; padding-top: 30%; padding-bottom: 30%;  border: 1px solid #d0d0d0;">
				<?php if(!$public) {?> <button data-toggle="modal"  href="#add_video" class="btn btn-primary">Agregar Video</button> <?php } ?>
			</div>
			<div class="space2"> </div>
		<?php
		/*
		<form id="video_upload_form" action="" method="post">
			 

			<div>
					
				<input name="url_ytb" class="input-xlarge" type="text" placeholder="Dirección Video" value="">
				<input name="name_ytb" class="input-xlarge" type="text" placeholder="Nombre Video">
				<div class="space1"></div>	
				<textarea class="rich_textarea" name="description_ytb" rows="8" placeholder="Descripción Video"></textarea>
				<div class="space1"></div>	
				<button type="submit" class="btn btn-primary">Guardar</button>					
			
			</div>
		</form>
		*/
		}

		?>			
		<div class="fb-comments" style="width: 100% !important;"  data-href="<?php echo HOME."/user/index/".$user_id; ?> "  data-num-posts="10"></div>													
	</div>		
</div>
