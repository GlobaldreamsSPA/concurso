		  			<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
				    		<div class="space4"></div>
				    		
				    		<div class="span9 offset1">
					    		<ul class="nav nav-pills nav-stacked orange">
									<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
									<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
			 						<li><a href="<?php echo HOME."/hunter/manage_hunters/";?>"> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>
									<li class="active"><a> <i class="icon-edit"></i> Editando Casting</a></li>
									<li><a  href="<?php echo HOME."/hunter/casting_list";?>"> <i class="icon-list"></i> Mis Castings</a></li>
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
								<legend><h3 class="profile-title"> Editar Casting </h3></legend>
								<div style="margin-left:15px;">
									<h5>T&iacutetulo</h5>
									<input type="text" name="title" class="span5" placeholder="T&iacute;tulo del Casting" value="<?php if(isset($update_values)) echo $update_values["title"]; else echo set_value('title');?>">
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
									
									<h5>Habilidades</h5>
									
									<?php 
										$skills_selected= array();
										/*
										for ($i=0; $i<sizeof($skills); $i++)
										{
											if(isset($actual_skills[$i]))
												$skills_selected[$i]=$actual_skills[$i];
										}*/
										
										foreach($actual_skills as $act_ski)
										{
											$skills_selected[]=$act_ski;
										}
										echo form_multiselect('skills[]', $skills,$skills_selected,"class='chzn-select' style='width:60%' data-placeholder='Selecciona los tags...'");
									
									?>	
									
									<h5>Hunters</h5>
									
									<?php 
									
									echo form_multiselect('hunters[]', $hunters,NULL,"class='chzn-select chosen_filter' style='width:60%' data-placeholder='Selecciona los hunters...'");
									?>

									<h5>Descripci&oacuten o llamado a postular</h5>
									<textarea class="rich_textarea" name="description"><?php if(isset($update_values)) echo $update_values["description"]; else echo set_value('description');?></textarea>
									<?php echo form_error('description'); ?>
	
									<h5>Requerimientos</h5>
									<textarea class="rich_textarea" name="requirements"><?php if(isset($update_values)) echo $update_values["requirements"]; else echo set_value('requirements');?></textarea>
									<?php echo form_error('requirements'); ?>
	
									
									<div class="space1"></div>

									<button type="submit" class="btn btn-primary">Guardar Cambios</button>

								</div>
								<?php /* ?>		
								<legend>Perfil del postulante a buscar</legend>
								<div>
									<div style="margin-left:15px;" class="row">
										<div class="span6">
										<h5>Color de ojos</h5>
										<select style="width: 100%;" name="eyes-color">
											<option value="Verde">Verde</option>
											<option value="Azul">Azul</option>
											<option value="Gris">Gris</option>
											<option value="Casta&ntildeo">Casta&ntildeo</option>
											<option value="&aacutembar">&Aacutembar</option>
											<option value="Avellana">Avellana</option>
											<option value="Todos">Todos</option>
										</select>
										</div>
										<div class="span6">
										<h5>Color de cabello</h5>
										<select style="width: 100%;" name="hair-color">
											<option value="Casta&ntildeo">Casta&ntildeo</option>
											<option value="Negro">Negro</option>
											<option value="Rubio">Rubio</option>
											<option value="Blanco">Blanco</option>
											<option value="Rojo">Rojo</option>
											<option value="Gris">Gris</option>
											<option value="Todos">Todos</option>
										</select>
										</div>
									</div>
									<div style="margin-left:15px;" class="row">
										<div class="span6">
											<h5>Color de piel</h5>
											<select style="width: 100%;" name="skin-color">
												<option value="Blanca">Blanca</option>
												<option value="Negra">Negra</option>
												<option value="Trigue&ntildea">Trigue&ntildea</option>
												<option value="Morena">Morena</option>
												<option value="Todos">Todos</option>
											</select>
										</div>
										
										<div class="span6">
											<h5>Estatura</h5>
											<select style="width: 100%;" name="height">
												<option value="150 cm o menos">150 cm o menos</option>
												<option selected="selected" value="150 cm">150 cm</option>
												<option value="160 cm">160 cm</option>
												<option value="170 cm">170 cm</option>
												<option value="180 cm">180 cm</option>
												<option value="190 cm">190 cm</option>
												<option value="200 cm">200 cm</option>
												<option value="200 cm o m&aacutes">200 cm o m&aacutes</option>
												<option value="Todos">Todos</option>
											</select>
										</div>
									</div>
									
									<div style="margin-left:15px;" class="row">
										<?php 
											echo form_multiselect('age[]', $age_list,NULL,"class='chzn-select chosen_filter' style='width:60%' data-placeholder='Selecciona las edades...'");
										 ?>
										<div class="span6">
											<h5>Contextura</h5>
											<select style="width: 100%;" name="build">
												<option value="0">Delgado</option>
												<option selected="1" value="normal">Normal</option>
												<option value="2">Grueso</option>
												<option value="3">Atletico</option>
												<option value="4">Obeso</option>
											</select>
										</div>
									</div>
									<div style="margin-left:15px;" class="row">	
										<h5>Sexo</h5>
										<label class="radio inline">
											<input type="radio" name="optionsRadios" id="optionsRadios1" value="2" checked>
											Femenino
										</label>
										<label class="radio inline">
											<input type="radio" name="optionsRadios" id="optionsRadios2" value="1">
											Masculino
										</label>
										<label class="radio inline">
											<input type="radio" name="optionsRadios" id="optionsRadios3" value="0">
											Ambos
										</label>
										<div class="space2"></div>
									</div>									
					  			</div>
					  			<php */ ?>

							</form>
						</div>
						
					</div>
					<div class="row-fluid">	
						<div class="space4"></div>	
					</div>