<script type="text/javascript">

$(document).ready(function() {
	
// Support for AJAX loaded modal window.
// Focuses on first input textbox after it loads the window.
$('[data-toggle="modal"]').click(function(e) {
	e.preventDefault();
	var url = $(this).attr('href');
	
	$.get(url, function(data) {
		$('<div id="contestmodal" class="modal hide fade">' + data + '</div>').modal();
	}).success(function() { $('.modal-title').focus(); });
});
	
});

</script>


<!-- Muestra este mensaje, en caso de postular a un concurso de forma exitosa o fallida. -->
<div id="postulation-result" class="modal hide fade in">
<div class="modal-header">
<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a> 
</div>
<div class="modal-body">
<h4>Aviso</h4>
<p><?php if(isset($success_message)) echo $success_message; ?></p>              
</div>
<div class="modal-footer">
<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
</div>
</div>

<?php if(isset($success_message)){ ?>
<script type="text/javascript">

  $('#postulation-result').modal({
    show: true
  });
</script>
<?php } ?>



<div class="content home" id="content">
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="row">
			<div style="margin-left:1.2%;"  class="row-fluid">
				<div class="space2"></div>
	  			<div style="margin-left:3%;" class="row">
		  			<?php echo form_open('home',array('method' => 'get', 'class' => 'form-inline')); ?>
	  					<div style="margin-top:15px;" class="span3">
							<input type="text" id='filter' style='width:95%;' placeholder="Busca por t&iacute;tulo" name="search_terms" value="<?php echo $search_values["search_terms"] ?>"></input>
						</div>
						<div class="span7" style="margin-top:15px; margin-left:0 !important;">
							<div class="styled span5" style="margin-left: 2%;">										
								<?php echo form_dropdown("category",$categories,$search_values["category"],'data-placeholder="Categorías" style="width:100%;"') ?>
							</div>
							<div class="styled span5">
								<?php echo form_dropdown("prize",$prizes,$search_values["prize"],'data-placeholder="Premios" id="test2" style="width:100%;"') ?>
							</div>
						</div>
						<div style="margin-top:15px; text-align:right;" class="span2">
							<input type="submit"  id="filter_button" class="btn btn-primary" value="BUSCAR CONCURSOS"/>
						</div>
					</form>
				</div>
				<div class="space2"></div>

				<?php
				$i=0; 
				foreach ($contest_list as $contest) {
					$i++;
					if(($i-1)%3 == 0 or $i==1) 
						echo "<div style='margin-left: 1px;' class='row'>";
					?>
					<div id="main_videos_list" class='span4'>
						<div class="space1"></div>
						<a href="<?php echo HOME.'/home/contest?id='.urlencode($contest["id"]).'&title='.urlencode($contest["title"]).'&entity='.urlencode($contest["entity"]).'&days='.urlencode($contest["days"]).'&logo='.urlencode($contest["logo"]).'&description='.urlencode($contest["description"]).'&steps='.urlencode($contest["steps"]).'&prizes_description='.urlencode($contest["prizes_description"]).'&bases='.urlencode($contest["bases"]).'&full_image='.urlencode($contest["full_image"]).'&category='.urlencode($contest["category"]).'&prizes='.urlencode($contest["prizes"]).'&apply_url='.urlencode($contest["apply_url"]).'&entity_id='.urlencode($contest["entity_id"]) ?>" data-toggle="modal">							
							<div class="image">
								<img class="fade_new" src="<?php echo $contest['full_image']; ?>" alt=""/>
							</div>
						</a>
						<span class="arrow"></span>
						<div class="container video_text_main span12">
							<div class="space1"></div>
							<div class="row row_text_main">
								<div class="span10 offset1">
									<div style="margin-bottom: 0.5%;" class="home-video-title"><?php echo $contest["title"]; ?></div>
									<span class="home-video-author">Publicado por Ganando.cl</span>
									<div class="space05"></div>
									<div class="home-video-countdown">
										<?php $date = explode("-", $contest["end_date"]); $date[1] = $date[1] -1; ?>
										<div id="<?php echo 'countdown'.$i; ?>">
											<?php echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00)}); </script>"; ?>
										</div>
									</div>
								</div>
								<div class="span1">
									<?php 
										if($contest["info_only"])
										{
									?>
											<img style="position:absolute; bottom:-23%; right:0; height:142%; width:26%;" src="<?php echo HOME.'/img/info.png'; ?>"/>
									<?php
										}
									?>
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