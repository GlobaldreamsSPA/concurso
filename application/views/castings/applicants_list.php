		  			<div class="row-fluid">		
				    	<div class="span3 user-profile-left">
				    		<img class='user_image' src="<?php echo HOME."/img/logo_hunter/".$user_data['logo'] ?>"/>
				    		<div class="space4"></div>
				    		
				    		<div class="span11">
					    		<ul class="nav nav-pills nav-stacked orange">
								  	<li><a href="<?php echo HOME."/hunter";?>"> <i class="icon-user"></i> Perfil</a> </li>
								  	<li><a href="<?php echo HOME."/hunter/edit/";?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
									<li><a href="<?php echo HOME."/hunter/manage_hunters/";?>"> <i class="icon-list-alt"></i> Gesti&oacute;n Hunters</a></li>								  	
								  	<li><a href="<?php echo HOME."/hunter/publish";?>"> <i class="icon-edit"></i> Nuevo Casting</a></li>
									<li class="active"><a> <i class="icon-list"></i> Mis Castings</a></li>
									<li><a href="<?php echo HOME."/hunter/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
								</ul>
							
								
								<?php

				  				echo form_open(HOME."/hunter/applicants_list/".$id_casting."/1",array('method' => 'get'));

								echo "<label style='font-size:15px;'> Estado Postulaci&oacute;n </label>"; 
								echo form_dropdown('status', $status,$applies_state,"id='apply_status' style='width:100%'");
								
								echo "<label style='font-size:15px;'> Nombre Postulante </label>"; 
								echo form_input('name', $name_p,"class='filter_input_a1' style='width:92%; border: 1px solid #aaa;'");

								echo "<label style='font-size:15px;'> Habilidades </label>";
								echo form_multiselect('skills[]', $skills, $filter_skills,"class='chzn-select chosen_filter' style='width:100%;' data-placeholder='Elige los tags...'");
								
								echo "<label style='font-size:15px;'> Sexo </label>";
								echo form_multiselect('sex[]', $sex_list, $filter_sex,"class='chzn-select chosen_filter' style='width:100%' data-placeholder='Elige sexo ...'");
								
								echo "<label style='font-size:15px;'> Edad </label>";
								echo form_multiselect('age[]', $age_list, $age_range,"class='chzn-select chosen_filter' style='width:100%' data-placeholder='Elige rango edad ...'");
								

								?>
								<div class="space1"> </div>
								<input class="btn btn-info" value="Actualizar" type="submit" />
								</form>
               				</div>
					    </div>
					    
					    <div class="span8 offset1 user-profile-right">
					    		
					    	<div class="row">
								<div class="span11">
									<h3 class="profile-title"><a href="<?php echo HOME.'/hunter/casting_list' ?>">Castings/</a><a href="<?php echo HOME.'/hunter/casting_detail/'.$id_casting; ?>"><?php echo $name_casting."/"; ?></a> Lista Postulantes </h3>
								</div>
								<div class="span1">
									
									<?php							
									if(isset($allowed_to_finalize) AND $allowed_to_finalize){
									?>
										<a href="<?php echo HOME."/hunter/finalize_casting/".$id_casting; ?>" style="height: 34px;" class="btn" title="Cerrar Casting">
										<i style="margin-top: 8px;" class="icon-off"></i>
										</a>
									<?php
									}
									else{
									?>
									<a data-toggle="modal" href="#modal_finalize" style="height: 34px; text-align: right;" class="btn" title="Cerrar Casting">
									<i style="margin-top: 8px;" class="icon-off"></i>
									</a>
									
									<!-- Definicion del modal-->
									<div id="modal_finalize" class="modal hide fade in">
									<div class="modal-header">
									<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a>  
									</div>
									<div class="modal-body">
									<h4>Aviso</h4>
									<p>Debe Aprobar o Rechazar a cada uno de los postulantes para cerrar el casting.</p>              
									</div>
									<div class="modal-footer">
									<a href="#" class="btn" data-dismiss="modal">Volver</a>
									</div>
									</div>
									<?php
									}
									?>							
								</div>
								<legend></legend>
							</div>
							<?php 
							if(isset($applicants))
								foreach ($applicants as $applicant) {
							?>

							<div class="row" style="margin-left:1px; width: 100%; height: 180px;"> 
					    		<div class="span7">
					    		<iframe width="100%" height="110%" src="http://www.youtube.com/embed/<?php echo $applicant['video_id']."?rel=0"?>" frameborder="0" allowfullscreen></iframe>
					    		</div>
					    		<div class="span5">
						    		<row>
							    		<div class="span3">
							    			<img style="max-width: 75%; max-height: 75%;" src="<?php echo HOME.'/img/gallery/'.$applicant["image_profile"] ?>"/>
										</div>
										<div class="span6">
											<p style="font-size: 12px;">
												<?php echo $applicant['name']; ?>
											</p>
										</div>
										<div class="span1">
											<a class="btn" target="_blank" href="<?php echo HOME.'/user/index/'.$applicant["id"] ?>">
												<i class="icon-search"></i>
											</a>
										</div>
									</row>
									<row>
										<div class="space2"></div>
										<?php
											if(isset($applicant['tags'])&& !empty($applicant['tags']) )
												{
											  		echo '<ul style="font-size: 8px;" class="skills-list">';
											  		foreach ($applicant['tags'] as $tag) {
													echo '<li> <a href="#">'.$tag.'</a></li>';
												}
												echo '</ul>';
											}
											else
												echo '<div class="space1"></div>'
										?>
									</row>
									
									<row>
							    		<p style="font-size: 12px; text-align:justify;">
											<?php echo substr(strip_tags($applicant['bio']),0,140)."...";?>
							    		</p>
									</row>
									
									<row style="float: right;">
										
										<a data-toggle="modal" <?php if($applicant["apply_state"]!=1){ echo "href='#modal".$applicant["id"]."'"; echo 'class="btn btn-success"';} else echo 'class="btn btn-success disabled"'; ?> style="text-align: right;"  title="Aprobar">
											<i class="icon-ok"></i>
										</a>
										
										<a <?php if($applicant["apply_state"]!=2){ echo "href='".HOME."/hunter/reject_apply/".$applicant['apply_id']."/".$id_casting."'"; echo 'class="btn btn-danger"';} else echo 'class="btn btn-danger disabled"'; ?> style="text-align: right;" title="Rechazar">
											<i class="icon-remove"></i>
										</a>
										
									</row>
									
									<div id="<?php echo "modal".$applicant["id"]; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <form action="<?php echo HOME."/hunter/accept_apply/".$applicant['apply_id']."/".$id_casting; ?>" method="post">
										  <div class="modal-header">
										    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
										    <h3 id="myModalLabel">Observaciones</h3>
										  </div>
										  <div class="modal-body">
											<input name="observation" type="text" value="" placeholder="campo no obligatorio">
										  </div>
										  <div class="modal-footer">
										    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
										    <button type="input" class="btn btn-primary">Guardar</a>
										  </div>
									  </form>
									</div>
								</div>
							</div>
				
							<div class="space4"></div>
							
							<?php } ?>
						
						<div class="row-fluid">
			                <div class="space1"></div>
			                <div class="pagination">  
				                <ul id="pagination_bt">
					                <li <?php if($page==1) echo "class='disabled'";?> ><a <?php if($page!=1) echo "href= '".base_url()."hunter/applicants_list/".($id_casting)."/".($page-1).$get_uri."'"; ?>>Prev</a></li>  
					                <?php 
					                
					                $pag_size = 6; //se puede fijar una constante que lo maneje
									$margen = $pag_size/2;
									
									$begin_pag = $page - $margen;
									if($begin_pag <= 0) $begin_pag = 1;
									
									$end_pag = $page + $margen;
									if($end_pag > $chunks) $end_pag = $chunks;
								 
					                for($i = $begin_pag; $i <= $end_pag; $i++) 
					                { ?>
					                	<li <?php if($page==$i) echo "class='disabled'";?> ><a <?php if($page!=$i) echo "href= '".base_url()."hunter/applicants_list/".($id_casting)."/".$i.$get_uri."'"; ?> > <?php echo $i; ?></a></li>  
					                <?php } ?>
					                <li <?php if($page==$chunks) echo "class='disabled'";?> ><a <?php if($page!=$chunks) echo "href= '".base_url()."hunter/applicants_list/".($id_casting)."/".($page+1).$get_uri."'"; ?> >Next</a></li>
				                </ul>  
			                </div>  
			                <div class="space1"></div>  
         			    </div>    

								
						</div>
					</div>
					<div class="row-fluid">	
						<div class="space4"></div>	
					</div>