<script type="text/javascript">

$(document).ready(function() {
	
	
	var active = false;

	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();

		if (active) {
        	return;
    	}
		active = true;
		$("#load").css("display","");

		var url = $(this).attr('href');

		$.get(url, function(data) {
			$('<div id="contestmodal" style="max-height: 95% !important;" class="modal hide fade">' + data + '</div>').modal();
		}).success(function() { 
			$("#load").css("display","none");
			$('.modal-title').focus(); 
			$(".modal-backdrop").on("remove", function () {
			    active = false;
			});
		});


	});

	$( ".list_element" ).hover(function() {
		$(this).find("#hidden").removeClass("hidden");
	},function() {
		$(this).find("#hidden").addClass("hidden");
	});

});

</script>


<h1 style="display:none">Como ganar, solo concursa en Ganando .cl</h1>
<h1 style="display:none">Participa en los sorteos por premios en Ganando .cl</h1>

<img id="load" style="display: none; left: 50%; margin-left: -150px; top: 50%; margin-top: -30px; width:300px; position: fixed;  z-index: 10000" src="<?php echo HOME."/img/load.gif" ?>"/>

<div class="content home" id="content">		
	<div class="row">
		<div style="margin-left:1.2%; text-align:center;"  class="row-fluid">
			<div style="width: 80%; display: inline-block;">
				<div class="space2"></div>
				<?php /*
	  			<div style="margin-left:3%;" class="row">
		  			<?php echo form_open('home',array('method' => 'get', 'class' => 'form-inline')); ?>
	  					<div style="margin-top:15px;" class="responsive-search span3">
							<input type="text" id='filter' style='width:95%;' placeholder="Busca por t&iacute;tulo" name="search_terms" value="<?php echo $search_values["search_terms"] ?>"></input>
						</div>
						<div class="responsive-select span7" style="margin-top:15px; left:0 !important;">
							<div class="styled span5">										
								<?php echo form_dropdown("category",$categories,$search_values["category"],'data-placeholder="Categorías" id="category" style="width:100%;"') ?>
							</div>
							<div class="styled span5">
								<?php echo form_dropdown("prize",$prizes,$search_values["prize"],'data-placeholder="Premios" id="prize" style="width:100%;"') ?>
							</div>
						</div>
						<div style="margin-top:15px; right:2%;" class="responsive-button span2">
							<input type="submit"  id="filter_button" class="btn btn-primary" value="BUSCAR CONCURSOS"/>
						</div>
					</form>
				</div>
				*/?>

				<div class="space2"></div>

				<?php
				$i=0; 
				foreach ($contest_list as $contest) {
					$i++;
					if(($i-1)%3 == 0 or $i==1) 
						echo "<div style='margin-left: 1px;' class='row'>";
					?>
					<div style="position: relative;" id="main_videos_list" class='list_element responsive span4'>
						<div class="space1"></div>


						<?php
							if($contest["has_started"] == TRUE)
							{
						?>
								<a rel="nofollow" href="<?php echo HOME.'/home/contest?status='.urlencode($contest["status"]).'&id='.urlencode($contest["id"]).'&title='.urlencode($contest["title"]).'&entity='.urlencode($contest["entity"]).'&days='.urlencode($contest["days"]).'&logo='.urlencode($contest["logo"]).'&description='.urlencode($contest["description"]).'&steps='.urlencode($contest["steps"]).'&prizes_description='.urlencode($contest["prizes_description"]).'&bases='.urlencode($contest["bases"]).'&full_image='.urlencode($contest["full_image"]).'&category='.urlencode($contest["category"]).'&prizes='.urlencode($contest["prizes"]).'&apply_url='.urlencode($contest["apply_url"]).'&entity_id='.urlencode($contest["entity_id"]).'&d_photo_contest='.urlencode($contest["d_photo_contest"]) ?>" data-toggle="modal">							
									<div class="image">
									<?php
										if ($contest["status"]=="En Revisión") 
										{
									?>
											<img style="z-index: 1000; width:62%; margin-left:44%; margin-top: -5.5%; position: absolute;" src="<?php echo HOME."/img/etiqueta_revision.png"; ?>" alt=""/>
									<?php
										}
										elseif ($contest["status"]=="Finalizado") 
										{
									?>
											<img style="z-index: 1000; width:60%; margin-left:45.5%; margin-top: -5.3%; position: absolute;" src="<?php echo HOME."/img/etiqueta_finalizado.png"; ?>" alt=""/>

									<?php
										}
									?>


										<img class="fade_new" style="width:100%;" src="<?php echo $contest['full_image']; ?>" alt=""/>
									</div>
								</a>
						<?php
							}
							else
							{
						?>
								<div class="image">
									<img class="fade_new" style="width:100%;" src="<?php echo $contest['full_image']; ?>" alt=""/>
								</div>
						<?php
							} 
						?>
						<div class="contest_text_main">
							<div class="space05"></div>
							<div style="margin-left: 0;" class="row row_text_main">
								<div class="span12">
									<div style="margin-bottom: 0.5%;" class="home-contest-title"><?php echo $contest["title"]; ?></div>
									<div id="hidden" class="hidden">
										<span class="home-contest-author">Publicado por Ganando.cl</span>
										<div class="space025"></div>
										<?php
											if($contest["status"]=="Activo")
											{
										?>
												<div class="home-video-countdown">
													<div class="contest-countdown" id="<?php echo 'countdown'.$i; ?>">													
														<?php	
															if($contest["has_started"] == TRUE)
															{
																$date = explode("-", $contest["end_date"]); $date[1] = $date[1] -1;
																echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00), layout: \"<span>El concurso finaliza en {dnn} días, {hnn}:{mnn}:{snn}</span>\"}); </script>";
															}
															else
															{
																$date = explode("-", $contest["start_date"]); $date[1] = $date[1] -1;
																echo "<label>".$date."</label>";
																
																if($contest["interval"] >= 3600*24)
																	echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00), layout: '<span>Faltan {dnn} días para iniciar el concurso</span>'}); </script>";
																else
																{
																	$hours = intval($contest["interval"]/(3600));
																	echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00), layout: '<span>Faltan {hnn} horas para activarse</span>'}); </script>";

																}
															}
														?>
													</div>
												</div>
										<?php
											}
											elseif ($contest["status"]=="En Revisión") 
											{
											?>
												<div style="width: 104%; color: white; font-size: 14px;">
													<span class="home-video-title" style="color: #78EA78; text-shadow: -2px 0 #D35400, 0 2px #D35400, 2px 0 #D35400, 0 -2px #D35400;">Esperando sorteo</span>, atent@s a las redes sociales.
												</div>
										<?php
											}
											elseif ($contest["status"]=="Finalizado") 
											{
											?>
												<div style="width: 104%; color: white; font-size: 14px;">
													<span class="home-video-title" style="color: #FFF664; text-shadow: -2px 0 #D35400, 0 2px #D35400, 2px 0 #D35400, 0 -2px #D35400;" >Concurso finalizado</span>, felicitaciones al ganador(a).
												</div>
										<?php
											}
										?>
									</div>
									<div class="span1">
									<?php 
										if($contest["info_only"])
										{
									?>
											<img style="position:absolute; bottom:-33%; right:0; height:156%; width:30%;" src="<?php echo HOME.'/img/info.png'; ?>"/>
									<?php
										}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php 
					if($i%3 == 0 || $i == count($contest_list))
					{ 
						echo "</div>"; 
						echo "<div class='space4'></div>"; 
					}
				}

				if(count($contest_list)==0)
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
					<div style="text-align:center;">  
					  <ul id="pagination_bt">
					    <li class="previous <?php if($page==1) echo "disabled";?>"><a rel="nofollow" <?php if($page!=1) echo "href='".base_url()."home/index/".($page-1).$get_uri."'";?>></a></li>  
						<?php
						$pag_size = 16; 
						$margen = $pag_size/2;
						
						$begin_pag = $page - $margen;
						if($begin_pag < 0) $begin_pag = 1;
						
						$end_pag = $page + $margen;
						if($end_pag > $chunks) $end_pag = $chunks;
						
						for($i = $begin_pag; $i <= $end_pag; $i++){ 
							?>
							<li class="number <?php if($page==$i) echo "disabled";?>"><a rel="nofollow" <?php if($page!=$i) echo "href='".base_url()."home/index/".$i.$get_uri."'";?> > <?php echo $i; ?></a></li>  
						<?php 
						} 
						?>
					    <li class="next <?php if($page==$chunks) echo "disabled";?>"><a <?php if($page!=$chunks) echo "href='".base_url()."home/index/".($page+1).$get_uri."'";?>></a></li>
					     
					  </ul>  
					</div>  
					<div class="space4"></div>	
				</div>
			</div>
			<div style="position: relative; width: 15%; height: 20px; margin-left: 5%; margin-right: 5%; display: inline-block; background-color: #2c3e50; margin-bottom: -0.2%;">
				<div style="position: absolute; left: -20px; display: inline-block; width: 0px; height: 0px; border-style: solid; border-width: 0 0 20px 20px; border-color: transparent transparent #2c3e50 transparent;"></div>
				<span style="font-size: 16px; color: white;">Otros Concursos</span>
				<div style="position: absolute; right: -20px; display: inline-block; width: 0px; height: 0px; border-style: solid; border-width: 20px 0 0 20px; border-color: transparent transparent transparent #2c3e50;"></div>
			</div>
			<div style="width: 77.2%; display: inline-block; background-color: #2c3e50;">
				<?php
				$i=0; 
				foreach ($bottom_contest as $contest) {
					$i++;
					if(($i-1)% 6 == 0 or $i==1)
					{ 
						echo "<div style='margin-left: 1px;' class='row'>";
						echo "<div style='position: relative; width: 14.2%; margin-left:0; display: inline-block;' id='main_videos_list' class='list_element'>";
					}else
						echo "<div style='position: relative; width: 14.2%; display: inline-block;' id='main_videos_list' class='list_element'>";	
					
					?>
					<div class="space1"></div>

					<?php
						if($contest["has_started"] == TRUE)
						{
					?>
							<a rel="nofollow" href="<?php echo HOME.'/home/contest?status='.urlencode($contest["status"]).'&id='.urlencode($contest["id"]).'&title='.urlencode($contest["title"]).'&entity='.urlencode($contest["entity"]).'&days='.urlencode($contest["days"]).'&logo='.urlencode($contest["logo"]).'&description='.urlencode($contest["description"]).'&steps='.urlencode($contest["steps"]).'&prizes_description='.urlencode($contest["prizes_description"]).'&bases='.urlencode($contest["bases"]).'&full_image='.urlencode($contest["full_image"]).'&category='.urlencode($contest["category"]).'&prizes='.urlencode($contest["prizes"]).'&apply_url='.urlencode($contest["apply_url"]).'&entity_id='.urlencode($contest["entity_id"]).'&d_photo_contest='.urlencode($contest["d_photo_contest"]) ?>" data-toggle="modal">							
								<div class="image">
									<img class="fade_new" style="width:100%;" src="<?php echo $contest['little_image']; ?>" alt=""/>
								</div>
							</a>
					<?php
						}
						else
						{
					?>
							<div class="image">
								<img class="fade_new" style="width:100%;" src="<?php echo $contest['little_image']; ?>" alt=""/>
							</div>
					<?php
						} 
					?>
					</div>
				<?php 
					if($i%6 == 0 || $i == count($bottom_contest))
					{ 
						echo "</div>"; 
						echo "<div class='space1'></div>"; 
					}
				}
				?>
			</div>
			<!--
			<div style="position: relative; width: 10%; height: 20px; margin-left: 10%; margin-right: 10%; display: inline-block; background-color: #2c3e50; margin-bottom: -0.2%;">
				<div style="position: absolute; left: -20px; display: inline-block; width: 0px; height: 0px; border-style: solid; border-width: 0 20px 20px 0; border-color: transparent #2c3e50 transparent transparent;"></div>
				<span style="font-size: 14px; color: white;">Ver Más</span>
				<div style="position: absolute; right: -20px; display: inline-block; width: 0px; height: 0px; border-style: solid; border-width: 20px 20px 0 0; border-color: #2c3e50 transparent transparent transparent;"></div>
			</div>
			-->
			<div class="space4"></div> 	
			<div class="space2"></div> 	
		</div>
	</div>
</div>