<script>
	$(document).ready(function() {
		$('#rankingdatatable').dataTable( {
			"aaSorting": [[ 2, "desc" ]]
		} );
	} );

	var tag = document.createElement('script');

	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	var player;
	function onYouTubeIframeAPIReady() {
	  player = new YT.Player('spotiframe');
	}

</script>

<div class="modal fade hide" id="playermodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div style="padding: 0px;" class="modal-body">
	</div>
</div>

<div class="modal fade hide" id="playermodal_simple" tabindex="-1" role="dialog" aria-hidden="true">
	<div style="padding: 0px;" class="modal-body">
	</div>
</div>

<div class="modal fade hide" id="spotmodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div style="padding: 0px;" class="modal-body">
		<a class="close" style="margin-right:3%;" data-dismiss="modal"><i class="icon-remove"></i></a>  
		<div style="padding:5%; text-align: center">
			<iframe id="spotiframe" width="100%" height="300px" src="http://www.youtube.com/embed/HrtEzkemBgY?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe> 
		</div>
	</div>
</div>

<div class="content" id="content">
	<div class="space4"></div>
	<div class="space4"></div>

	<div class="container-fluid">
		<div class="row">
			<div class= "span8" id="variable">
		  		<div style="border-radius: 5px; margin-left:3%;"  class="row-fluid">
		  			<div style="padding-top:1.5%; border-top-left-radius: 5px; border-top-right-radius: 5px; padding-bottom:1.5%; background:url(<?php echo HOME."/img/bgslide.png" ?>)">
			  			<div style="margin-left: 1.5%; width: 97%; margin-bottom:0px;" id="myCarousel" class="carousel slide">
							<!-- Carousel items -->
							<div class="carousel-inner">
							    <div class="active item">
							    	<a href="#spotmodal" data-toggle="modal" onclick='player.playVideo()'>	
				  						<img style="height:100%; width:100%;" src="<?php echo HOME."/img/bgspot.jpg" ?>">
				  					</a>
								</div>
								<div class="item">
							    	<a href="<?php echo base_url().'user/fb_login'; ?>">	
				  						<img style="height:100%; width:100%;" src="<?php echo HOME."/img/home_viddon_graphic.jpg" ?>">
				  					</a>
								</div>
							</div>
							<!-- Carousel nav -->
							<a style="margin-top:2%;" class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
							<a style="margin-top:2%;" class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
						</div>
					</div>
				</div>

				<div class="space2"></div>

				<div style="border-radius: 5px; margin-left:3%;"  class="row-fluid">
					<div class="space05"></div>


					<ul  class="nav nav-tabs">
						<li class="active"><a class="home_tabs" href="#videos" data-toggle="tab">Video Talentos</a></li>
						<?php /* ?><li><a href="#ranking" class="home_tabs" data-toggle="tab">Artistas más populares</a></li> <?php*/ ?>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="videos">		
			  			<div style="margin-left:3%;" class="row">
				  			<?php echo form_open('home',array('method' => 'get', 'class' => 'form-inline')); ?>
			  					<div style="margin-top:15px;" class="span4">
									<input id='filter' style='width:95%;' placeholder="Busca por t&iacute;tulo" name="search_terms" value="<?php echo $search_values["search_terms"] ?>"></input>
								</div>
								<div class="span6" style="margin-top:15px; margin-left:0 !important;">
									
									<?php echo form_dropdown("order",$order_options,$search_values["order"],'data-placeholder="Ordenar por" class="chzn-select-deselect" style="width:45%;margin-right: 2%"') ?>
									
									<?php echo form_dropdown("category",$category_options,$search_values["category"],'data-placeholder="Categorías" class="chzn-select-deselect" style="width:35%;"') ?>

										
								</div>
								<div style="margin-top:15px; text-align:right;" class="span2">
									<input type="submit"  id="filter_button" class="btn btn-info" value="Buscar"/>
								</div>
							</form>
						</div>
					
						<?php
						$i=0; 
						foreach ($video_list as $video) {
							$i++;
							if(($i-1)%3 == 0 or $i==1) 
								echo "<div style='margin-left: 1px;' class='row'>";
							?>
							<div id="main_videos_list" class='span4'>
								<div class="space1"></div>
								<a href="<?php echo HOME.'/home/video?id='.urlencode($video[1]).'&id_bdd='. urlencode($video[4]).'&video_reproductions='. urlencode($video[5]).'&name='. urlencode($video[0]).'&iduser='.urlencode($video[2]).'&username='.urlencode($video[6]).'&description='.urlencode($video[3]).'&userlastname='.urlencode($video[8]).'&image='.urlencode($video[7]) ?>" data-target="#playermodal" data-toggle="modal">							
									<div class="image">
										<img class="fade_new" src="<?php echo 'http://img.youtube.com/vi/'.$video[1].'/0.jpg'; ?>" alt=""/>
									    <img class="hoverimage" src="<?php echo HOME.'/img/player_arrow.png'; ?>" alt="" />
									</div>
								</a>
								<span class="arrow"></span>
								<div class="container video_text_main span12">
									<div class="space1"></div>
									<div class="row row_text_main">
										<div class="span3 offset1">
										<a class="home-video-author" href="<?php echo HOME.'/user/index/'.$video[2]; ?>">
											<?php
											if(file_exists(APPPATH.'/../img/gallery/'.$video[7]) == TRUE)
												echo "<img class='user_image_main_page' src='".HOME.'/img/gallery/'.$video[7]."'/>";
											else
												echo "<img class='user_image_main_page' src='".HOME."/img/profile/user.jpg'/>";
											?>
										</a>
										</div>
										<div class="span7">
											<div style="margin-bottom: 7px;"class="home-video-title"><?php echo $video[0]; ?></div>
											<span class="home-video-author">por </span><a class="home-video-author" href="<?php echo HOME.'/user/index/'.$video[2]; ?>"><?php echo $video[6]; ?></a>								
										</div>
									</div>
									<div class="row">
										<div class="span5 offset1">
											<img src='<?php echo HOME."/img/upgrey.png" ?>'/>
											<p id="upvotes" style="display:inline;"><?php echo $video[9];?></p>  
											<img src='<?php echo HOME."/img/downgrey.png" ?>'/>											
											<p id="downvotes" style="display:inline;"><?php echo $video[10];?></p> 
										</div>
										<div class="span5" style="text-align: right;">
											<p style="font-weight:bold;"><i class="icon-play"></i> <?php echo $video[5]; ?></p>
										</div>
									</div>
								</div>
							</div>
						<?php 
							if($i%3 == 0 || $i == count($video_list)) 
								echo "</div>"; 
						}

						if(count($video_list)==0)
						{
							?>
								<div style='margin-left:3%;' class="row">
									<div class="space4"></div>
									No se encontraron resultados.
									<div class="space4"></div>
								</div>
						
							<?php
						}

						?>
						<div class="row">
							<div class="space1"></div>
							<div class="pagination">  
							  <ul id="pagination_bt">
							    <li <?php if($page==1) echo "class=disabled";?>><a <?php if($page!=1) echo "href='".base_url()."home/index/".($page-1).$get_uri."'";?>>Prev</a></li>  
								<?php
								$pag_size = 16; 
								$margen = $pag_size/2;
								
								$begin_pag = $page - $margen;
								if($begin_pag < 0) $begin_pag = 1;
								
								$end_pag = $page + $margen;
								if($end_pag > $chunks) $end_pag = $chunks;
								
								for($i = $begin_pag; $i <= $end_pag; $i++){ 
									?>
									<li <?php if($page==$i) echo "class=disabled";?>><a <?php if($page!=$i) echo "href='".base_url()."home/index/".$i.$get_uri."'";?> > <?php echo $i; ?></a></li>  
								<?php 
								} 
								?>
							    <li <?php if($page==$chunks) echo "class=disabled";?>><a <?php if($page!=$chunks) echo "href='".base_url()."home/index/".($page+1).$get_uri."'";?>>Next</a></li>
							     
							  </ul>  
							</div>  
							<div class="space1"></div>	
						</div>	
					</div>

					<?php /*?>
			    	<div class="tab-pane" id="ranking">
			    		<div class="space1"></div>
		  				<div class="row" style="padding-right: 5%;padding-left: 4%">
		  					<table style="width: 100%;" width="100%" id="rankingdatatable" class="table">
			          			<thead>
						            <tr>
							            <th>Ficha del Artista</th>
							            <th>Video Principal</th>
							            <th>Likes Perfil</th>
						            </tr>
			          			</thead>
				          		<tbody>
				          	
					          	<?php
					          	 if(isset($ranking))
						          	foreach ($ranking as $applicant) {?>
										<tr>
								            <td style="max-width: 250px; min-width: 250px; vertical-align:middle;">
								            	<div class="row">
								            	<div class="span4">
									            	<a class="home-video-author" href="<?php echo HOME.'/user/index/'.$applicant['id'] ?>">
														<?php
														if(file_exists(APPPATH.'/../img/gallery/'.$applicant["image"]) == TRUE)
															echo "<img class='user_image_main_page' src='".HOME."/img/gallery/".$applicant['image']."'/>";
														else
															echo "<img class='user_image_main_page' src='".HOME."/img/profile/user.jpg'/>";
														?>
													</a>
												</div>

								            	<div style="position:relative; top: -20px;"class="span8">
									            	<a class="home-video-author" href="<?php echo HOME.'/user/index/'.$applicant['id'] ?>">
									            		<?php echo $applicant["first_name"]." ".$applicant["last_name"]?>
									            	</a>
									            	<br>
									            	<p style="text-align: justify">
										            	<?php echo substr(strip_tags($applicant['bio']),0,120)."..";?>
										            	<a href="<?php echo HOME.'/user/index/'.$applicant['id'] ?>">
										            		(ver m&aacute;s)
										            	</a> 
									            	</p>
								            	</div>
								            	</div>
								            	<?php
												echo '<ul class="skills-list">';
												foreach ($applicant["tags"] as $tag) {
													echo '<li> <a href="#">'.$tag.'</a></li>';
												}
													echo '</ul>';
												?>
								            </td>
								            <td style="max-width: 180px; min-width: 180px; padding-top:1%;padding-bottom:1%; vertical-align:middle;">
								            	<a href="<?php echo HOME.'/home/video_ranking?id='.urlencode($applicant["video_id_y"]).'&id_bdd='. urlencode($applicant["video_id"]).'&video_reproductions='. urlencode($applicant["video_reproductions"]).'&description='. urlencode($applicant["video_description"]).'&title='. urlencode($applicant["video_title"]).'&iduser='.urlencode($applicant['id']) ?>" data-target="#playermodal_simple" data-toggle="modal">							
													<div class="image">
														<img class="fade_new" src="<?php echo 'http://img.youtube.com/vi/'.$applicant["video_id_y"].'/0.jpg'; ?>" alt=""/>
													    <img class="hoverimage" src="<?php echo HOME.'/img/player_arrow.png'; ?>" alt="" />
													</div>
												</a>
								            </td>
								            <td style="max-width: 10px; min-width: 10px; color:#1097db; font-size:16px; font-weight:bold;vertical-align:middle; text-align:center"><?php echo $applicant["likes"]?></td>
							            </tr>    
					              	<?php }?>
				          		</tbody>
			        		</table>
			        		<div class="space2"></div>
			        		<div class="space2"></div>

			    		</div>
			  		</div>
			  		<?php */?>
				</div>
			</div>
		</div>
			<div class="span4">
			  	<div style="border-radius: 5px; margin-left:8%; text-align:center;" id="grow" class="row-fluid">
			  		<div class="space1"></div>
			  		<h2 id="profile"  style="font-weight:bold;">Casting Viddon</h3>
			  		<?php foreach($castings as $casting){ ?>
			  			<a href="<?php echo site_url("home/casting_detail/".$casting['id']); ?>">
		  					<img style="margin-top: 7%; width: 84%; " src="<?php echo $casting['image']; ?>">
		  				</a>
		  			<?php } ?>
					<div class= "space2"></div>
					
					<div class="social_container">
						<div class="space05"></div>
						<h4 id="profile"> Buscanos en Redes Sociales</h4>
					
						<div class="row">
							<div class="span3">
								<a href="https://twitter.com/ViddonCom" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_t.png"; ?>">
			  					</a>
			  				</div>
			  				<div class="span3">	
			  					<a  href="http://www.facebook.com/pages/Viddoncom/499177723428347?ref=hl" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_f.png"; ?>">
			  					</a>
			  				</div>
			  				<div class="span3">	
			  					<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_y.png"; ?>">
			  				</div>
			  				<div class="span3">	
			  					<a  href="http://www.viddon.com/blog" target=”_blank”>
			  						<img style="margin-top: 7%; width: 74%; " src="<?php echo HOME."/img/social_container_w.png"; ?>">
			  					</a>
			  				</div>
		  				</div>
					</div>

					<div class="space1"></div>


					<div style="margin-left: 5%; margin-right: 5%;">
						<a class="twitter-timeline" href="https://twitter.com/ViddonCom" data-widget-id="316343995661959169">Tweets por @ViddonCom</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>

					<div class= "space2"></div>


				</div>
			</div>	
		</div>
  	</div>
  	<div class="space4"></div> 	
</div>