<script type="text/javascript">
	if($(this).width() < 930){
		
		$(".responsive-top").removeClass('span5');  
		$(".responsive-top").removeClass('offset1');  
		$(".responsive-top").addClass("row");
		$(".responsive-top").css("padding-left","5%");
		$(".responsive-top").css("padding-top","0");
		$(".responsive-top").css("text-align","center");

		$(".responsive-bottom").css("padding-top","10%");
		$(".responsive-bottom").removeClass('span6');  
		$(".responsive-bottom").addClass("row");

		$(".removable").removeClass("space4");



    }else if($(this).width() >= 930)
    {
   		$(".responsive-top").addClass('span5');  
		$(".responsive-top").addClass('offset1');  
		$(".responsive-top").removeClass("row");
		$(".responsive-top").css("padding-left","0");
		$(".responsive-top").css("padding-top","6%");
		$(".responsive-top").css("text-align","left");
		
		$(".responsive-bottom").css("padding-top","0");
		$(".responsive-bottom").addClass('span6');  
		$(".responsive-bottom").removeClass("row");

		$(".removable").addClass("space4");


    }

	$(window).resize(function(){
		if($(this).width() < 930){
			
			$(".responsive-top").removeClass('span5');  
			$(".responsive-top").removeClass('offset1');  
			$(".responsive-top").addClass("row");
			$(".responsive-top").css("padding-left","5%");
			$(".responsive-top").css("padding-top","0");
			$(".responsive-top").css("text-align","center");

			$(".responsive-bottom").css("padding-top","10%");
			$(".responsive-bottom").removeClass('span6');  
			$(".responsive-bottom").addClass("row");

			$(".removable").removeClass("space4");

		   	
		}else if($(this).width() >= 930)
		{
			$(".responsive-top").addClass('span5');  
			$(".responsive-top").addClass('offset1');  
			$(".responsive-top").removeClass("row");
			$(".responsive-top").css("padding-left","0");
			$(".responsive-top").css("padding-top","6%");
			$(".responsive-top").css("text-align","left");

			$(".responsive-bottom").css("padding-top","0");
			$(".responsive-bottom").addClass('span6');  
			$(".responsive-bottom").removeClass("row");

			$(".removable").addClass("space4");


		}
	});

</script>
<div class="content_lh" id="content">
	<div class="space4"></div>
	<div class="removable space4"></div>
	<div class="content-fluid">
		<div class="row">
			<div style="padding-top:6%" class="responsive-top span5 offset1">
				<h1 style="text-align:center; color: #E67E22; font-family: 'ganandofont'; font-size: 45px !important;" > QUE ES GANANDO.CL?</h1>
				<p style="text-align:center; margin-top:8%; color: #E67E22; line-height: 40px; font-family: 'ganandofont'; font-size: 26px;">
					ES EL NUEVO PORTAL DONDE PODRAS ENCONTRAR MUCHOS CONCURSOS ENTRETENIDOS PARA PARTICIPAR. QUE ESTAS ESPERANDO, <a rel="nofollow" href="<?php echo base_url().'user/fb_login'; ?>">¡CONCURSA!</a>
				</p>
			</div>							
			<div style="margin-top:2%; margin-left:3%; text-align:center;" class="responsive-bottom span6">
				
				<iframe style="border: 5px solid #E67E22;" width="85%" height="360px" src="http://www.youtube.com/embed/GAWcdrSC1-k?rel=0&amp;showinfo=0&amp;theme=light" frameborder="0" allowfullscreen=""></iframe>

			</div>		
		</div>
	</div>
	<div class="space4"></div>
</div>