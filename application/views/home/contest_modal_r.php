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
	                width: "49.5%",
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
                height: 390,
                width: "100%",
                "padding-top": 30
            }, 1000);
            $(event.data.target_text).append($(event.data.source_text).html());
        } else {
            $(event.data.target).animate({
                height: 127,
                width: "49.5%",
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

	
	$(close_elements).bind("click", function() {
	    $("#contestmodal").fadeOut(500, function () {
			$(this).remove();
		});
	    $(".modal-backdrop").fadeOut(500, function () {
			$(this).remove();
		});

		$('body').css('overflow', 'visible');

	});

	if($(window).width() < 930)
	{
			
		$(".responsive-top").removeClass('span5');  
		$(".responsive-top").addClass("span12");
		$(".responsive-top").css("padding-top","10%");


		$(".responsive-bottom").css("padding-top","10%");
		$(".responsive-bottom").removeClass('span7');  
		$(".responsive-bottom").addClass("span12");


	   	
	}else if($(window).width() >= 930)
	{
		$(".responsive-top").addClass('span5');  
		$(".responsive-top").removeClass("span12");
		$(".responsive-top").css("padding-top","");

		$(".responsive-bottom").css("padding-top","");
		$(".responsive-bottom").addClass('span7');  
		$(".responsive-bottom").removeClass("span12");



	}

	$(window).resize(function(){
		if($(this).width() < 930){
			
			$(".responsive-top").removeClass('span5');  
			$(".responsive-top").addClass("span12");
			$(".responsive-top").css("padding-top","10%");


			$(".responsive-bottom").css("padding-top","10%");
			$(".responsive-bottom").removeClass('span7');  
			$(".responsive-bottom").addClass("span12");


		   	
		}else if($(this).width() >= 930)
		{
			$(".responsive-top").addClass('span5');  
			$(".responsive-top").removeClass("span12");
			$(".responsive-top").css("padding-top","");

			$(".responsive-bottom").css("padding-top","");
			$(".responsive-bottom").addClass('span7');  
			$(".responsive-bottom").removeClass("span12");



		}
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
	<div class="responsive-top span5" style="padding-right: 2%;">
		<div style="position: relative; background: #2C3E50;">
			<img style="position: absolute; z-index: 1000;" src='<?php echo HOME."/img/rev_stamp.png"; ?>'/>
			<img style="opacity: 0.5;" src='<?php echo $full_image; ?>'/>
		</div>		<div class="space05"></div>
		<span style="font-size:20px !important; font-weight: bold;">Etiquetas:</span>
		<div style="margin-top: 1%; margin-bottom: 5%;">
			<ul style="list-style-type: none !important;" class="tags">
			<?php 
				//echo "<li style='list-style-type: none !important;'><a href='".HOME."/home?search_terms=&category=".$category_id."&prize=' target='_blank'>".$category."</a></li>";
				echo "<li style='list-style-type: none !important;'><a>".$category."</a></li>";
				foreach ($prizes as $id => $prize ) 
					if($prize!="")
					{
						//echo "<li><a href='".HOME."/home?search_terms=&category=&prize=".$id."' target='_blank' >".$prize."</a></li>";
						echo "<li><a>".$prize."</a></li>";	
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
	<div class="responsive-bottom span7" id="info-contest" style="height:420px; position: relative !important;">
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
				
	</div>
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