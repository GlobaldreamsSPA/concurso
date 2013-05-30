		  			<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
				    		<div class="space4"></div>
				    		
				    		<div class="span9 offset1">
					    		<ul class="nav nav-pills nav-stacked orange">
									<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
									<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
									<li class="active"><a> <i class="icon-edit"></i> Edici&oacute;n Concurso</a></li>
									<li><a  href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Concursos</a></li>
									<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
								</ul>
							</div>
				    	</div>
					    
					    <div class="span8 offset1 user-profile-right">
					    		
							<div class="space1"></div>
							<div class="space1"></div>
							
					
							 <?php 
						
						
						echo form_open_multipart('hunter/edit_casting/'.$update_values["id"],array('class' => 'form-horizontal')); 
						?>
								<legend><h3 class="profile-title"> Editar Concurso </h3></legend>
								<div style="margin-left:15px;">
									<h5>T&iacutetulo</h5>
									<input type="text" name="title" class="span5" placeholder="T&iacute;tulo del Concurso" value="<?php if(isset($update_values)) echo $update_values["title"]; else echo set_value('title');?>">
									<?php echo form_error('title'); ?>
	
									
									<?php $today = new DateTime(date('Y-m-d')); ?>
									
									
									<h5>Fecha de inicio</h5>
									<input type="text" class="span3" value="<?php if(isset($update_values)) echo $update_values["start_date"]; else echo $today->format('Y-m-d');?>" id="dp1" data-date-format="yyyy-mm-dd" name="start-date">
									<h5>Fecha de t&eacutermino</h5>
									<input type="text" class="span3" value="<?php if(isset($update_values)) echo $update_values["end_date"]; else echo $today->format('Y-m-d');?>" id="dp2" data-date-format="yyyy-mm-dd" name="end-date">
									
									<h5>Meta Postulantes</h5>
									<input type="text" name="max_applies" class="span5" placeholder="Ingresa Cantidad" value="<?php if(isset($update_values)) echo $update_values["max_applies"]; else echo set_value('max_applies');?>">
									<?php echo form_error('max_applies'); ?>
	

									<h5>Categor&iacutea</h5>
									<select class="span5" name="category">
										<?php
											foreach($categories as $cat)
											{
												$selected = "";
												if(isset($actual_category) && $cat==$actual_category) $selected = "selected='true'";
												echo "<option ".$selected." value='".$cat."'>".$cat."</option>";
											}
										?>
									</select>
									
									<h5>Imagen para mostrar</h5>
									<?php echo form_upload(array('name' => 'casting_image','class'=> 'file')); ?>
									<?php
										echo form_hidden('image','');
										echo form_error('image');
									?>

									<h5>Descripci&oacuten o llamado a postular</h5>
									<textarea class="rich_textarea" name="description"><?php if(isset($update_values)) echo $update_values["description"]; else echo set_value('description');?></textarea>
									<?php echo form_error('description'); ?>
	
									
									<div class="space1"></div>

									<button type="submit" class="btn btn-primary">Guardar Cambios</button>

								</div>

							</form>
						</div>
						
					</div>
					<div class="row-fluid">	
						<div class="space4"></div>	
					</div>