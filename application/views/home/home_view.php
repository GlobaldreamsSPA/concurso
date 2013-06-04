<div class="modal fade hide" id="contestmodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div style="padding: 0px;" class="modal-body">
	</div>
</div>

<div class="content" id="content">
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
		<div class="row">
				<div style="margin-left:1.2%;"  class="row-fluid">
					<div class="space05"></div>
		  			<div style="margin-left:3%;" class="row">
			  			<?php echo form_open('home',array('method' => 'get', 'class' => 'form-inline')); ?>
		  					<div style="margin-top:15px;" class="span3">
								<input type="text" id='filter' style='width:95%;' placeholder="Busca por t&iacute;tulo" name="search_terms" value="<?php echo $search_values["search_terms"] ?>"></input>
							</div>
							<div class="span7" style="margin-top:15px; margin-left:0 !important;">
																		
								<?php echo form_dropdown("category",$categories,$search_values["category"],'data-placeholder="Categorías" class="chzn-select-deselect" style="width:38%;"') ?>
								<?php echo form_dropdown("prize",$prizes,$search_values["prize"],'data-placeholder="Premios" class="chzn-select-deselect" style="width:42%;"') ?>
							
							</div>
							<div style="margin-top:15px; text-align:right;" class="span2">
								<input type="submit"  id="filter_button" class="btn btn-info" value="Buscar"/>
							</div>
						</form>
					</div>
			

					<?php
					$i=0; 
					foreach ($contest_list as $contest) {
						$i++;
						if(($i-1)%3 == 0 or $i==1) 
							echo "<div style='margin-left: 1px;' class='row'>";
						?>
						<div id="main_videos_list" class='span4'>
							<div class="space1"></div>
							<a href="<?php echo HOME.'/home/contest?id='.urlencode($contest["id"]).'&title='. urlencode($contest["title"]).'&entity='. urlencode($contest["entity"]).'&days='. urlencode($contest["days"]).'&logo='. urlencode($contest["logo"]).'&description='.urlencode($contest["description"]).'&full_image='.urlencode($contest["full_image"]).'&category='.urlencode($contest["category"]).'&prizes='.urlencode($contest["prizes"]).'&apply_url='.urlencode($contest["apply_url"]).'&entity_id='.urlencode($contest["entity_id"]) ?>" data-target="#contestmodal" data-toggle="modal">							
								<div class="image">
									<img class="fade_new" src="<?php echo $contest['full_image']; ?>" alt=""/>
								</div>
							</a>
							<span class="arrow"></span>
							<div class="container video_text_main span12">
								<div class="space1"></div>
								<div class="row row_text_main">
									<div class="span10 offset1">
										<div style="margin-bottom: 20px;" class="home-video-title"><?php echo $contest["title"]; ?></div>
										<span class="home-video-author">Publicado por Ganando.cl</span>
										<?php /* <img class='user_image_main_page' src='<?php echo $contest["logo"]; ?>'/> */ ?>
									</div>
								</div>
							</div>
						</div>
					<?php 
						if($i%3 == 0 || $i == count($contest_list)) 
							echo "</div>"; 
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
						<div class="space1"></div>
						<div class="pagination">  
						  <ul id="pagination_bt">
						    <li class="previous" <?php if($page==1) echo "class=disabled";?>><a <?php if($page!=1) echo "href='".base_url()."home/index/".($page-1).$get_uri."'";?>>Prev</a></li>  
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
						    <li class="next" <?php if($page==$chunks) echo "class=disabled";?>><a <?php if($page!=$chunks) echo "href='".base_url()."home/index/".($page+1).$get_uri."'";?>>Next</a></li>
						     
						  </ul>  
						</div>  
						<div class="space1"></div>	
					</div>	
				</div>
		</div>
  	<div class="space4"></div> 	
</div>