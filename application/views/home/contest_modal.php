<script type="text/javascript">

	$('body').css('overflow', 'hidden');

	/* Funcion de la animacion de la informacion del concurso, de modo que al hacer click en
	uno de los bloques se ocultan los otros */
	var contest_information_animation_onmouseleave = function(event)
	{
		if(event.data.state == false)
		{
			$(event.data.target).animate({
	                height: 127,
	                width: "27%",
	                "padding-top": 80
	            }, 1000, function(){
					$(event.data.div1).css("z-index","0");
					$(event.data.div2).css("z-index","0");
					$(event.data.div3).css("z-index","0");
					$(event.data.hideclick).css("display","");
					}
	            );
	        $(event.data.target_text).empty();
	        event.data.state = !event.data.state;
	    }
	}

	var contest_information_animation = function (event) 
	{
		$(event.data.target).css("z-index","0");
		$(event.data.div1).css("z-index","-1");
		$(event.data.div2).css("z-index","-1");
		$(event.data.div3).css("z-index","-1");
		$(event.data.hideclick).css("display","none");

        if (event.data.state) {
            $(event.data.target).animate({
                height: 395,
                width: "55%",
                "padding-top": 30
            }, 1000);
            $(event.data.target_text).append($(event.data.source_text).html());
        } else {
            $(event.data.target).animate({
                height: 127,
                width: "27%",
                "padding-top": 80
            }, 1000, function(){
				$(event.data.div1).css("z-index","0");
				$(event.data.div2).css("z-index","0");
				$(event.data.div3).css("z-index","0");
				$(event.data.hideclick).css("display","");

				}
            );
            $(event.data.target_text).empty();
        }
  		event.data.state = !event.data.state;
    };

    var stade_des = {target: '#des', div1: '#pri', div2: '#bas', div3: '#ste', hideclick: '.hide-click1', state: true, target_text: '#des-text', source_text: '#text-des'};
	$("#des").click(stade_des, contest_information_animation);
	$("#des").mouseleave(stade_des, contest_information_animation_onmouseleave);

	var state_pri = {target: '#pri', div1: '#des', div2: '#bas', div3: '#ste', hideclick: '.hide-click2', state: true, target_text: '#pri-text', source_text: '#text-pri'};
	$("#pri").click(state_pri, contest_information_animation);
	$("#pri").mouseleave(state_pri, contest_information_animation_onmouseleave);

  	var state_bas = {target: '#bas', div1: '#des', div2: '#pri', div3: '#ste', hideclick: '.hide-click3', state: true, target_text: '#bas-text', source_text: '#text-bas'};
	$("#bas").click(state_bas, contest_information_animation);
  	$("#bas").mouseleave(state_bas, contest_information_animation_onmouseleave);

  	var state_ste = {target: '#ste', div1: '#des', div2: '#pri', div3: '#bas', hideclick: '.hide-click4', state: true, target_text: '#ste-text', source_text: '#text-ste'};
	$("#ste").click(state_ste, contest_information_animation);
	$("#ste").mouseleave(state_ste, contest_information_animation_onmouseleave);

	/* Animacion tipo telon de cine para los concursos de video y trivia*/

    var close_elements= ".modal-backdrop, .close"; /* variable que maneja los elementos que ocacionan que se cierre el modal*/
    var toggle = true;

	if($(".upload-content").length > 0)
	{
		$('#contest-link').click(function (event)
		{
		    event.preventDefault();
		    if (toggle) {
		    
		    $(".upload-content").css("display","inline");
            $("#contestmodal").css("overflow-x","hidden");
            

            var width_boxes = "0.3%";

            $("#des").animate({
                width: width_boxes
            }, 1000);

            $("#pri").animate({
                width: width_boxes,
            }, 1000);

            $("#bas").animate({
                width: width_boxes,
            }, 1000);

            $("#ste").animate({
                width: width_boxes,
            }, 1000, function(){
            	$(".upload-content").css("z-index","0");
            	$('#contest-link').text("VOLVER");
            	$('#contest-link').removeClass('btn-primary');
            	$('#contest-link').addClass('btn-info');
			});
			

	        } else {
	        	$(".upload-content").css("z-index","-1");

	            $("#des").animate({
	                width: "27%"
	            }, 1000);

	            $("#pri").animate({
	                width: "27%",
	            }, 1000);

	            $("#bas").animate({
	                width: "27%",
	            }, 1000);

	            $("#ste").animate({
	                width: "27%",
	            }, 1000, function()
	            {
	            	$(".upload-content").css("display","none");
	            	$('#contest-link').text("CONCURSAR");
	            	$('#contest-link').removeClass('btn-info');
	            	$('#contest-link').addClass('btn-primary');
				});

	           	$("#contestmodal").css("overflow","visible");
	        }

	       	toggle=!toggle;
		});
	}

	if((($("#contest-link").attr("href") == 'photo' || $("#contest-link").attr("href") == 'trivia') && !($(".upload-content").length > 0)) ||  $("#contest-link").attr("href") == 'none')
	{
			

		$('#contest-link').attr('rel','tooltip');
		$('#contest-link').attr('data-original-title','Debes iniciar sesión para participar');
		$('#contest-link').tooltip();

		$('#contest-link').click(function(event){
	         event.preventDefault();
	      });

	}
		
	if(!($("#contest-link").attr("href") == 'photo' || $("#contest-link").attr("href") == 'trivia' || $("#contest-link").attr("href") == 'none'))
		close_elements = close_elements + ", .btn-primary";


	$(close_elements).bind("click", function() {
	    $("#contestmodal").fadeOut(500, function () {
			$(this).remove();
		});
	    $(".modal-backdrop").fadeOut(500, function () {
			$(this).remove();
		});

		$('body').css('overflow', 'visible');

	});

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#img_prev')
	            .attr('src', e.target.result);
	        };

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#trivia-upload-form").submit(function(){

		var error = false;
		var elements = $('.control-group textarea');

		for(var i=0; i < elements.length; i++)
		{
			if(elements[i].value == "")
			{
				error = true;

				div = $('.control-group')[i];
				div.className = div.className + " error";

				label = $('.control-group label')[i];
				label.style.display = "block";
				label.style.marginTop = "0";
				label.style.color = "#E74C3C";
			}
		}

		var elements = $('.chzn-choices');
		
		for(var i=0; i < elements.length; i++)
		{
			length = elements[i].getElementsByClassName('search-choice').length;
			if(length == 0)
			{
				error = true;
				label = $('.chozen-control-group label')[i];
				label.style.display = "block";	
				label.style.color = "#E74C3C";
			}
		}

		if(error)
			return false;
		else
			return true;
	});

	$('#photo_upload_form').submit(function(){

		var error = false;

		if($('#photo_upload_form input').val() == "")
		{
			$('#photo_upload_form .error-label')[0].style.display = "block";
			error = true;
		}

		if($('#photo_upload_form textarea').val() == "")
		{
			$('#photo_upload_form .error-label')[1].style.display = "block";
			error = true;
		}

		if(error)
			return false;
		else
			return true;
	});


	$(".photo-container").bind("click", function() {
	    $('#upload_photo').trigger('click');
	});


</script>

<div style="margin-left:10px; margin-right:10px;" class="row">
	<div class="span11">
		<h2 class="contest-title" >	<?php echo $title; ?> </h2>
	</div>
	<div class="span1 contest-close-container">
		<h2><a class="close contest-close" data-dismiss="modal"><span class="fui-cross"></span></a> </h2>
	</div>
</div>
<div style="margin-left:10px; margin-top:2%; margin-bottom:2%; height: 90%;" class="row">
	<div class="span5" style="padding-right: 2%;">
		<img src='<?php echo $full_image; ?>'/>
		<div class="space05"></div>
		<span style="font-size:20px !important; font-weight: bold;">Etiquetas:</span>
		<div style="margin-top: 1%; margin-bottom: 5%;">
			<ul class="tags">
			<?php 
				echo "<li><a href='".HOME."/home?search_terms=&category=".$category_id."&prize=' target='_blank'>".$category."</a></li>";
				
				foreach ($prizes as $id => $prize ) 
					if($prize!="")
					{
						echo "<li><a href='".HOME."/home?search_terms=&category=&prize=".$id."' target='_blank' >".$prize."</a></li>";
					}
			?>
			<ul>
		</div>
		<div class="space1"></div>
		<div style="text-align: center;">
			<span class="fui-time"></span>
			<?php
				echo $days." d&iacute;as para concursar"; 			
			?>
		</div>

		<!-- Codigo para mostrar el publicador del concurso, ver despues-->
		
		<?php /*
		<div class="span8">
			<div class="span6">
				<img style="max-width:50px;"src='<?php echo $logo; ?>'/>
			</div>
			<div class="span6">
				<?php echo $entity; ?>
			</div>
		</div>
		*/ ?>


	</div>
	<div class="span7" id="info-contest" style="height:420px;">
		<div style="height: 127px;" id="des" class="modal-closed">
			<h3 style="text-align: center; color:#ffffff;">
				Descripci&oacute;n
				<label class="hide-click1" style="font-size: 12px; margin-top:-10px;">(click para ver info)</label>
			</h3>
			<div id="des-text" style="color:#ffffff; padding:5%; padding-top:1% !important;font-size:15px;">
			</div>
		</div>

		<div style="height: 127px;" id="pri" class="modal-closed">
			<h3 style="text-align: center;  color:#ffffff;">
				Premios
				<label class="hide-click2" style="font-size: 12px; margin-top:-10px;">(click para ver info)</label>
			</h3>
			<div id="pri-text" style="color:#ffffff; padding:5%; padding-top:1% !important; font-size:15px;">
			</div>
		</div>
	
		<div style="height: 127px;" id="bas" class="modal-closed">
			<h3 style="text-align: center; color:#ffffff;">
				Bases del Concurso
				<label class="hide-click3" style="font-size: 12px; margin-top:-10px;">(click para ver info)</label>
			</h3>
			<div id="bas-text" style="color:#ffffff; padding:5%; padding-top:1% !important; font-size:15px;">
			</div>
		</div>
		<div style="height: 127px;" id="ste" class="modal-closed">
			<h3 style="text-align: center; color:#ffffff;">
				¿Como Concursar?
				<label class="hide-click4" style="font-size: 12px; margin-top:-10px;">(click para ver info)</label>
			</h3>
			<div id="ste-text" style="color:#ffffff; padding:5%; padding-top:1% !important; font-size:15px;">
			</div>
		</div>
		
		<?php
			if(strcmp($apply_url, "photo") == 0 && $logged_in) 
			{
		?>
			 <form id="photo_upload_form" enctype="multipart/form-data"  action="<?php echo HOME.'/home/apply_photo/'.$id_casting;?>" method="post">
		        <div class="upload-content photo-content span6">
		         <h3 id="myModalLabel">Sube tu Foto</h3>
		            <div>  
			            <div id="image_upload">
				              <?php echo form_upload(array('name' => 'upload_photo','id' => 'upload_photo','class'=> 'file','onchange'=>'readURL(this);')); ?>
			
			            </div>
			            <label class="error-label">Debe subir una imagen antes de concursar</label>
						
						<div class="photo-container">
							<img id="img_prev" style="max-height:250px; max-width:100%;"src="<?php echo HOME.'/img/dummy_galeria_fotos.png'; ?>" alt="your image" />
						</div>
			            <div class="space1"></div>  
			            <div >
			           		<?php echo $d_photo_contest; ?>
			            </div>
			            <div class="space1"></div>  
			            <textarea style="width: 95% !important;" name="foto_description" id="foto_description" rows="2" placeholder="Descripción de la foto"></textarea>
			            <label class="error-label" style="margin-top: -2%;">Debe ingresar una descripción antes de concursar</label>
		         		<div class="space1"></div>
		            </div>
		          <button type="submit" class="btn btn-primary pull-right">CONCURSAR</button>
		    	</div>
		    </form>

		<?php
			}
			elseif(strcmp($apply_url, "trivia") == 0 && $logged_in)
			{
		?>
		<form id="trivia-upload-form" action="<?php echo HOME.'/home/apply_trivia/'.$id_casting; ?>" method="POST">
			<div style="margin-left: 1% !important; width: 53.6% !important;" class="upload-content trivia-content">
				<?php
					if($custom_options != FALSE)
					{
						echo "<h3 style='text-align: center;' class='demo-panel-title'>Responde las siguientes preguntas</h3>";

						for($i=0; $i < count($custom_options); $i++) 
						{
							echo "<div style='padding-left:4%; padding-right:3%; width:95%;'class='row'";

							if(strcmp($custom_options[$i]['type'], 'text') == 0)
							{
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<div style='text-align: center;' class='control-group'><textarea name='custom_text_answer_".$custom_options[$i]['id']."'style='resize: none; width: 91%; margin-top: 15px;' placeholder='ingresa tu respuesta'></textarea>";
								echo "<label style='display: none; font-size: 12px; margin-left: 5px; margin-top: -2.4%;'>Este campo es requerido</label></div>";
								echo "<div class='space05'></div>";
							}

							if(strcmp($custom_options[$i]['type'], 'select') == 0)
							{
								//Pregunta va h5 y se crea un select con varios options
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<div class='space05'></div>";
								echo "<div style='text-align: center;'>";
								echo "<select name='custom_select_answer_".$custom_options[$i]['id']."'>";
								foreach ($custom_options[$i]['options'] as $option)
								{
									echo "<option value='".$option['id']."'>".$option['option']."</option>";
								}
								echo "</select>";
								echo "</div>";
								echo "<div class='space05'></div>";
							}

							if(strcmp($custom_options[$i]['type'], 'multiselect') == 0)
							{
								//Pregunta va h5 y se crea un select chozen
								echo "<h5>".$custom_options[$i]['text']."</h5>";
								echo "<div class='space05'></div>";

								$options =  array();
								foreach ($custom_options[$i]['options'] as $option)
								{
									$options[$option['id']] = $option['option'];
								}

								echo "<div style='text-align: center;' class='chozen-control-group'>".form_multiselect("custom_multiselect_answer_".$custom_options[$i]['id']."[]", $options ,NULL,"class='chzn-select chosen_filter' data-placeholder='Selecciona tus respuestas..'");
								echo "<label style='display: none; font-size: 12px; margin-left: 1%;'>Este campo es requerido</label></div>";
								echo "<div class='space1'></div>";
							}
							echo "</div>";
						}
					echo form_submit("", "CONCURSAR", "id='apply-link' class='btn btn-primary' target='_blank' ");
					}
				?>
				
				<!-- Este script es para convertir los multiselects en chozen selects -->
				<script type="text/javascript">
					$(".chzn-select").chosen();
				</script>
			</div>
		</form>
		<?php		
			}
		?>
	</div>
</div>
<div style="margin-right:2%;" class="row">
	<a id="contest-link" style="font-size:18px; line-height: 40px;" class="btn btn-primary pull-right" <?php if(!isset($target)) echo 'target="_blank"';?> href="<?php echo $apply_url; ?>"> <img style="height: 30px; margin-right:10px; margin-top: -7px;" src="<?php echo HOME."/img/animacion2.gif" ?>"/>CONCURSAR</a>
</div>


<!-- Texto oculto de las descripciones-->
<div id="text-des" style="display:none;">
	<?php echo $description; ?>
</div>

<div id="text-pri" style="display:none;">
	<?php echo $prizes_description; ?>
</div>

<div id="text-bas" style="display:none;">
	<?php echo $bases; ?>
</div>

<div id="text-ste" style="display:none;">
	<?php echo $steps; ?>
</div>