<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<div class="row">
				    		<?php 
				    		
								echo "<a href= '".HOME."/user/photo_gallery/'>";
				    			
				    			if(isset($update_values) && file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
				    				echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
				    			else
				    				echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
				    			
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
				    		<div class="row">
					    		<div class="span10 offset1">
					    			<ul class="nav nav-pills nav-stacked orange">
										<li><a href="<?php echo HOME."/user";?>"> <i class="icon-user"></i> Perfil</a>
										</li>
										<li class="active"><a> <i class="icon-pencil"></i> Editar Datos</a></li>
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
				    	</div>
				    
				    
					    <div class="space2"></div>
						<?php 
						
						echo form_open_multipart(); ?>
		
						<!-- Texto -->
						<div class="span8 offset1">
							<legend><h3>Cu&eacutentanos Sobre T&iacute</h3></legend>
							<div style="margin-left:15px;">
								<div class="row">
									<div class="span6">								
										<h5>Nombres</h5>
										<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["name"]; else echo set_value('name');?>" name="name">
									</div>
								</div>
								<div class="row">
								<?php echo form_error('name'); ?>
								</div>
								<div class="row">
									<div class="span6">								
										<h5>Apellidos</h5>
										<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["last_name"]; else echo set_value('last_name');?>" name="last_name">
									</div>
								</div>
								<div class="row">
								<?php echo form_error('last_name'); ?>
								</div>
								<div class="row">
									<div class="span6">								
										<h5>Correo</h5>
										<input type="text" style="width:100%;" placeholder="Escribe tu Nombre Aqui" value="<?php if(isset($update_values)) echo $update_values["email"]; else echo set_value('email');?>" name="email">
									</div>
								</div>
								<div class="row">
								<?php echo form_error('email'); ?>
								</div>
								<div class="space2"></div>														
								
								
							</div>
							<legend>Informaci&oacute;n P&uacute;blica</legend>
							
							<div style="margin-left:5px;">
								<h5>Selecciona tus habilidades</h5>
									<?php 
									
									echo form_multiselect('skills[]', $skills, $update_user_skills,"class='chzn-select' style='width:245px' data-placeholder='Selecciona los tags...'");
									?>
								<?php echo form_error('skills'); ?>

								<h5>Campo Con&oacute;ceme</h5>
									<textarea class="rich_textarea" name="bio"><?php if(isset($update_values)) echo $update_values["bio"]; else echo set_value('bio');?></textarea>
									<?php echo form_error('bio'); ?>
								<div class="space2"></div>
									<button class="btn btn-primary" type="submit"> Guardar Datos </button>
								</form>
								<div class="space4"></div>
							</div>
						</div>
					
					</div>
				