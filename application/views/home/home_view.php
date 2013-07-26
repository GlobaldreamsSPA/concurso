<script type="text/javascript">

$(document).ready(function() {
	
	
	var active = false;

	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();

		if (active) {
        	return;
    	}
		active = true;

		var url = $(this).attr('href');

		$.get(url, function(data) {
			$('<div id="contestmodal" style="max-height: 95% !important;" class="modal hide fade">' + data + '</div>').modal();
		}).success(function() { 
			$('.modal-title').focus(); 

			$(".modal-backdrop").on("remove", function () {
			    active = false;
			});
		});

	});

    if($(window).width() < 930){
		var collection = $(".responsive");
		collection.each(function( ) {
	     	if($(this).hasClass("span4")){
				$(this).removeClass('span4');  
				$(this).css('margin-left','19%');
				$(this).css('margin-bottom','10%');
				$(this).addClass("span8");
			}
		});

	    $(".responsive-search").removeClass('span3');  
	    $(".responsive-search").addClass("span12");
	    $(".responsive-search").css('margin-left','2.5%');


	    $(".responsive-select").removeClass('span7');  
	    $(".responsive-select").addClass("span12");
	    $(".responsive-select").css('margin-left','2.5%');


	    $(".styled").removeClass('span5');  
	    $(".styled").addClass("span6");

	   	$(".responsive-button").removeClass('span2'); 
	   	$(".responsive-button").addClass('span12'); 
	   	$(".responsive-button").css('text-align','center');

	   	$("#filter").css('font-size','20px');
	    $("#prize").css('font-size','20px');
	   	$("#category").css('font-size','20px');
	    $("#filter_button").css('font-size','20px');

	    $("#top-banner").removeClass('span5');  
	    $("#top-banner").addClass("span11");

	    $("#bottom-banner").removeClass('span6');  
	    $("#bottom-banner").addClass("span11 offset1");


	   	
	}else if($(window).width() >= 930)
	{
			var collection = $(".responsive");

	     collection.each(function( ) {
			 if(!$(this).hasClass("span4")){
			    $(this).addClass("span4");
				$(this).css('margin-left','1.7%');
				$(this).css('margin-bottom','0');
				$(this).removeClass("span8");
			 }  
		});
	    $(".responsive-search").addClass('span3');  
		$(".responsive-search").removeClass("span12");
		$(".responsive-search").css('margin-left','0');

		$(".responsive-select").addClass('span7');  
		$(".responsive-select").removeClass("span12");
		$(".responsive-select").css('margin-left','0');

		$(".styled").addClass('span5');  
		$(".styled").removeClass("span6");

		$(".responsive-button").addClass('span2'); 
	   	$(".responsive-button").removeClass('span12'); 
	   	$(".responsive-button").css('text-align','inline');

	   	$("#filter").css('font-size','16px');
	    $("#prize").css('font-size','16px');
	    $("#category").css('font-size','16px');
	    $("#filter_button").css('font-size','16px');


	    $("#top-banner").addClass('span5');  
	    $("#top-banner").removeClass("span11");

	    $("#bottom-banner").addClass('span6');  
	    $("#bottom-banner").removeClass("span11 offset1");

	}

	$(window).resize(function(){
 	    if($(this).width() < 930){
	    	var collection = $(".responsive");
			collection.each(function( ) {
		     	if($(this).hasClass("span4")){
					$(this).removeClass('span4');  
					$(this).css('margin-left','19%');
					$(this).css('margin-bottom','10%');
					$(this).addClass("span8");
				}
			});

		    $(".responsive-search").removeClass('span3');  
		    $(".responsive-search").addClass("span12");
		    $(".responsive-search").css('margin-left','2.5%');


		    $(".responsive-select").removeClass('span7');  
		    $(".responsive-select").addClass("span12");
		    $(".responsive-select").css('margin-left','2.5%');


		    $(".styled").removeClass('span5');  
		    $(".styled").addClass("span6");

		   	$(".responsive-button").removeClass('span2'); 
		   	$(".responsive-button").addClass('span12'); 
		   	$(".responsive-button").css('text-align','center');

		   	$("#filter").css('font-size','20px');
		    $("#prize").css('font-size','20px');
		   	$("#category").css('font-size','20px');
		    $("#filter_button").css('font-size','20px');


		    $("#top-banner").removeClass('span5');  
		    $("#top-banner").addClass("span11");

		    $("#bottom-banner").removeClass('span6');  
		    $("#bottom-banner").addClass("span11 offset1");


		   	
	   }else if($(this).width() >= 930)
	   {
	   		var collection = $(".responsive");

		     collection.each(function( ) {
				 if(!$(this).hasClass("span4")){
				    $(this).addClass("span4");
					$(this).css('margin-left','1.7%');
					$(this).css('margin-bottom','0');
					$(this).removeClass("span8");
				 }  
			});
		    $(".responsive-search").addClass('span3');  
	    	$(".responsive-search").removeClass("span12");
	    	$(".responsive-search").css('margin-left','0');

	    	$(".responsive-select").addClass('span7');  
	    	$(".responsive-select").removeClass("span12");
	    	$(".responsive-select").css('margin-left','0');

	    	$(".styled").addClass('span5');  
	    	$(".styled").removeClass("span6");

	    	$(".responsive-button").addClass('span2'); 
		   	$(".responsive-button").removeClass('span12'); 
		   	$(".responsive-button").css('text-align','inline');


		    $("#filter").css('font-size','16px');
		    $("#prize").css('font-size','16px');
		    $("#category").css('font-size','16px');
		    $("#filter_button").css('font-size','16px');


		    $("#top-banner").addClass('span5');  
		    $("#top-banner").removeClass("span11");

		    $("#bottom-banner").addClass('span6');  
		    $("#bottom-banner").removeClass("span11 offset1");
	   }
	});
});

</script>


<h1 style="display:none">Como ganar, solo concursa en Ganando .cl</h1>
<h1 style="display:none">Participa en los sorteos por premios en Ganando .cl</h1>

<div class="content home" style="background:none !important;"id="content">
		<h1 style="text-align:center; margin-top:120px; margin-bottom: 45px; color: #4da0d8; font-family: 'ganandofont'; font-size: 76px !important; line-height: 76px !important;" > GANA EN 3 PASOS</h1>									
		<div class="row">
			<div id="top-banner" style="margin-left: 9%;"class="span5">
				<p style="margin-top: 14px; color: #4da0d8; line-height: 40px; font-family: 'ganandofont'; font-size: 25px;">
					MUCHOS CONCURSOS PARA QUE PUEDAS PARTICIPAR DE FORMA GRATUITA CON TAN SÓLO 3 PASOS. 
				</p>
			</div>
			<div id="bottom-banner"class="span6">
				<div class="span4">
					<a href="<?php echo HOME."/user/fb_login"?>">
						<img style="width:100%;" src="<?php echo HOME.'/img/bg1.png'?>"/>
					
						<p style="text-align:center; color: #4da0d8; line-height: 40px; font-family: 'ganandofont'; font-size: 22px;">
							INGRESA 
						</p>
					</a>
				</div>
				<div class="span4">
					<a href="#" onclick=" if($(window).width() < 930) $('body,html').animate({ scrollTop: 800 }, 600); else $('body,html').animate({ scrollTop: 400 }, 600); ">
						<img style="width:100%;" src="<?php echo HOME.'/img/bg2.png'?>"/>
						<p style="text-align:center; color: #4da0d8; line-height: 40px; font-family: 'ganandofont'; font-size: 22px;">
							CONCURSA
						</p>
					</a>

				</div>
				<div class="span4">
					<img style="width:100%;" src="<?php echo HOME.'/img/bg3.png'?>"/>
					<p style="text-align:center; color: #4da0d8; line-height: 40px; font-family: 'ganandofont'; font-size: 22px;">
						¡GANA!
					</p>
				</div>

			</div>
		</div>
		<div class="row">
			<div style="margin-left:1.2%;"  class="row-fluid">
				<div class="space2"></div>
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
				<div class="space2"></div>

				<?php
				$i=0; 
				foreach ($contest_list as $contest) {
					$i++;
					if(($i-1)%3 == 0 or $i==1) 
						echo "<div style='margin-left: 1px;' class='row'>";
					?>
					<div id="main_videos_list" class='responsive span4'>
						<div class="space1"></div>
						<?php
							if($contest["has_started"] == TRUE)
							{
						?>
						<a rel="nofollow" href="<?php echo HOME.'/home/contest?id='.urlencode($contest["id"]).'&title='.urlencode($contest["title"]).'&entity='.urlencode($contest["entity"]).'&days='.urlencode($contest["days"]).'&logo='.urlencode($contest["logo"]).'&description='.urlencode($contest["description"]).'&steps='.urlencode($contest["steps"]).'&prizes_description='.urlencode($contest["prizes_description"]).'&bases='.urlencode($contest["bases"]).'&full_image='.urlencode($contest["full_image"]).'&category='.urlencode($contest["category"]).'&prizes='.urlencode($contest["prizes"]).'&apply_url='.urlencode($contest["apply_url"]).'&entity_id='.urlencode($contest["entity_id"]).'&d_photo_contest='.urlencode($contest["d_photo_contest"]) ?>" data-toggle="modal">							
							<div class="image">
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
						<span class="arrow"></span>
						<div class="video_text_main">
							<div class="space1"></div>
							<div class="row row_text_main">
								<div style="margin-left:6%;"class="span11">
									<div style="margin-bottom: 0.5%;" class="home-video-title"><?php echo $contest["title"]; ?></div>
									<span class="home-video-author">Publicado por Ganando.cl</span>
									<div class="space05"></div>
									<div class="home-video-countdown">
										<div class="contest-countdown" id="<?php echo 'countdown'.$i; ?>">
											<?php
												if($contest["has_started"] == TRUE)
												{
													$date = explode("-", $contest["end_date"]); $date[1] = $date[1] -1;
													echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00), layout: \"<span>El concurso finaliza en: {dnn} días, {hnn}&nbsp;horas</span></br><span>{mnn} minutos,&nbsp;{snn} segundos</span>\"}); </script>";
												}
												else
												{
													$date = explode("-", $contest["start_date"]); $date[1] = $date[1] -1;
													echo "<label>".$date."</label>";
													echo "<script type='text/javascript'> $('#countdown".$i."').countdown({until: new Date(".$date[0].",".$date[1].",".$date[2].", 23, 59, 59, 00), layout: '<span>Faltan {dnn} días para activarse</span>'}); </script>";
												}
											?>
										</div>
									</div>
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
							<div class="space1"></div>
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
				<div class="space4">
				</div>

				<div class="row" style="display: none;">
					<div class="space1"></div>
					<div class="pagination" style="text-align:center;">  
					  <ul id="pagination_bt">
					    <li class="previous" <?php if($page==1) echo "class=disabled";?>><a rel="nofollow" <?php if($page!=1) echo "href='".base_url()."home/index/".($page-1).$get_uri."'";?>>Prev</a></li>  
						<?php
						$pag_size = 16; 
						$margen = $pag_size/2;
						
						$begin_pag = $page - $margen;
						if($begin_pag < 0) $begin_pag = 1;
						
						$end_pag = $page + $margen;
						if($end_pag > $chunks) $end_pag = $chunks;
						
						for($i = $begin_pag; $i <= $end_pag; $i++){ 
							?>
							<li <?php if($page==$i) echo "class=disabled";?>><a rel="nofollow" <?php if($page!=$i) echo "href='".base_url()."home/index/".$i.$get_uri."'";?> > <?php echo $i; ?></a></li>  
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