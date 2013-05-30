<div class="row-fluid">		
  	<div class="span3 user-profile-left">
				    		<div class="row">
				    		<?php 

				    			echo "<a href= '".HOME."/user/photo_gallery/'>";

				    			if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
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
										<li><a  href="<?php echo HOME."/user"?>"> <i class="icon-user"></i> Perfil</a>
										</li>
										<li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
										<li>
											<a data-toggle="collapse" href="#collapseOne">
												<i class="icon-star-empty"></i> Postulaciones
											</a>
											<div id="collapseOne" class="collapse in">
												<ul style="padding-left: 30px;" class="nav nav-pills nav-stacked orange">
													<li class="active"><a>Activas</a></li>	
													<li><a href="<?php echo HOME."/user/results_casting"?>">Resultados</a></li>	
												</ul>
											</div>
										</li>	
										<li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>					
									</ul>
								</div>
				    		</div>
				    	</div>
				    			    
					    <div class="span8 offset1 user-profile-right">
					    		
							<legend> <h2>Postulaciones Activas</h2></legend>
							
							<?php 							
							if(isset($castings))
								foreach($castings as $casting){ ?>
								
									<div class="row">
										<div class="span1">
											<img src="<?php echo $casting['logo'] ?>"/>
										</div>
										<div class="span5">
											<h4><?php echo $casting['title'] ?></h4>
										</div>
										<div style="margin-top:2%;" class="span3">
											<i class="icon-time"></i> <?php echo $casting['days'] ?> d&iacute;as
										</div>
										<div class="span1">
											<a class="btn" href="mailto:contacto@viddon.com">
												<i class="icon-envelope"></i>                                            
											</a>
										</div>
										
										<div class="span1">
											<form action="" method="POST">
												<button class="btn" type="submit"><i class="icon-remove"></i></button>
												<input type="hidden" name="del-apply" value="<?php echo $casting["apply_id"] ?>"/>
											</form>										
										</div>
										
									</div>
									
									<div class="row">
										<div class="span6">
											<div class="space05"></div>
	
											<a href="<?php echo site_url("home/casting_detail/".$casting['id']); ?>">
												<img style='height:100%; width: 100%;' src="<?php echo $casting['image'] ?>"/>
											</a>
										</div>
										<div style="padding-left: 1%;" class="span6 list-view-applies-desc">
											<div class="space05"></div>
											<div class="row">
												<h4 id="profile">Descripci&oacuten:</h4>
												<div>
													<?php echo  substr(strip_tags($casting['description']),0,140)."..." ?>
												</div>
											</div>
											<div class="space1"></div>
											<div class="row">
													<h4 id="profile">Tags:</h4>
													<?php
																if(isset($casting['tags']))
													    		{
														    		echo '<ul class="skills-list">';
														    		foreach ($casting['tags'] as $tag) {
																		echo '<li> <a href="#">'.$tag.'</a></li>';
																	}
																	echo '</ul>';
																}
													?>
											</div>									
										</div>
									</div>
									
									<div class="space4"></div>
								
								
							<?php } ?>
						
							
						
							
							<div class="space4"></div>	
							<div class="space4"></div>						
						</div>					
					</div>
