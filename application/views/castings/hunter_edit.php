		  			<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<?php 
				    			if(isset($update_values) && file_exists(APPPATH.'/../img/logo_hunter/'.$update_values['logo']) == TRUE)
				    				echo "<img class='user_image' src='".HOME.'/img/logo_hunter/'.$update_values['logo']."'/>";
				    			else
				    				echo "<img class='user_image' src='".HOME."/img/logo_hunter/talent.jpg'/>";
				    		?>
				    		<div class="space4"></div>
				    		
				    		<div class="span9 offset1">
					    		<ul class="nav nav-pills nav-stacked orange">
								  	<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
								  	<li class="active"><a> <i class="icon-pencil"></i> Editar Datos</a></li>
									<li><a href="<?php echo HOME."/hunter/manage_hunters/";?>"> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>
								  	<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Casting</a></li>
									<li><a href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Castings</a></li>
									<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
								</ul>
							</div>
				    	</div>
					    
					    <center>
					    </center>
					    
					    <div class="space2"></div>
						<?php 
						if (isset($update_values)) $flag="/upd666";
						else 
							$flag = "";
						
						echo form_open_multipart('hunter/edit'.$flag); 
						?>
					    
					    
					    
					    <div class="span8 offset1 user-profile-right">

							<div class="space1"></div>
								<Legend><h3>Identificaci&oacuten Empresa/Agencia</h3></Legend>
								<div  style="margin-left: 20px;">
								<h5>Nombre Empresa</h5>
								<div class="space05"></div>
								<input type="text" class="span5" name="name" placeholder="Nombre Empresa/Agencia" value="<?php if(isset($update_values)) echo $update_values["name"]; else echo set_value('name');?>">
								<?php echo form_error('name'); ?>
								<h5>Correo de Contacto</h5>
								<div class="space05"></div>
								<input type="text" class="span5" name="email" placeholder="Correo Contacto" value="<?php if(isset($update_values)) echo $update_values["email"]; else echo set_value('email');?>">
								<?php echo form_error('email'); ?>
								<h5>Ubicación</h5>
								<div class="space05"></div>
								<input type="text" class="span5" name="address" placeholder="Dirección de la empresa" value="<?php if(isset($update_values)) echo $update_values["address"]; else echo set_value('address');?>">
								<?php echo form_error('address'); ?>
															
								<div style="margin-left: -15px; margin-top: -20px;" id="image_upload">
									<h5>Logo Corporativo</h5>
									<div class="space05"></div>
									<?php echo form_upload(array('name' => 'hunter_profile','class'=> 'file')); ?>
									<?php 
										  echo form_hidden('image','');
										  echo form_error('image'); 
									?>
								</div>
								
								<div class="space2"></div>
								
								<h5>Nosotros</h5>
								<div class="space05"></div>
								<textarea class="rich_textarea" name="about_us"><?php if(isset($update_values)) echo $update_values["about_us"]; else echo set_value('about_us');?></textarea>
								<?php echo form_error('about_us'); ?>
								
								<h5>Buscamos</h5>
								<div class="space05"></div>
								<textarea class="rich_textarea" name="we_look_for"><?php if(isset($update_values)) echo $update_values["we_look_for"]; else echo set_value('we_look_for');?></textarea>
								<?php echo form_error('we_look_for'); ?>
								<div class="space2"></div>
									<button class="btn btn-primary" type="submit"> Guardar Datos </button>
								</form>
								<div class="space4"></div>
							</div>
						</div>
					</div>
					<div class="row-fluid">	
						<div class="space4"></div>	
					</div>
