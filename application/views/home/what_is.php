<script type="text/javascript">
	if($(window).width() < 930){
		
		$(".responsive-top").removeClass('span6');  
		$(".responsive-top").addClass("row");

		$(".responsive-bottom").css("padding-top","4%");
		$(".responsive-bottom").removeClass('span6');  
		$(".responsive-bottom").addClass("span11 offset1");

		$(".removable").removeClass("space4");
		$(".addable").addClass("space4");

	   	
	}else if($(window).width() >= 930)
	{
		$(".responsive-top").addClass('span6');  
		$(".responsive-top").removeClass("row");

		$(".responsive-bottom").css("padding-top","1%");
		$(".responsive-bottom").addClass('span6');  
		$(".responsive-bottom").removeClass("span11 offset1");

		$(".removable").addClass("space4");
		$(".addable").removeClass("space4");


	}

	$(window).resize(function(){
		if($(this).width() < 930){
			
			$(".responsive-top").removeClass('span6');  
			$(".responsive-top").addClass("row");

			$(".responsive-bottom").css("padding-top","4%");
			$(".responsive-bottom").removeClass('span6');  
			$(".responsive-bottom").addClass("span11 offset1");

			$(".removable").removeClass("space4");
			$(".addable").addClass("space4");

		   	
		}else if($(this).width() >= 930)
		{
			$(".responsive-top").addClass('span6');  
			$(".responsive-top").removeClass("row");

			$(".responsive-bottom").css("padding-top","1%");
			$(".responsive-bottom").addClass('span6');  
			$(".responsive-bottom").removeClass("span11 offset1");

			$(".removable").addClass("space4");
			$(".addable").removeClass("space4");


		}
	});

</script>
<div class="content_lh" id="content">
	<div class="space4"></div>
	<div class="removable space4"></div>
	<div class="content-fluid">
		<div class="row">
			<h1 style="text-align:center; color: #E67E22; font-family: 'ganandofont'; font-size: 50px !important;" > ¿QUE ES GANANDO.CL?</h1>									
			<div class="addable"></div>
			<div style="margin-top:2%; margin-left:3%; text-align:center;" class="responsive-top span6">
				
				<iframe style="border: 5px solid #E67E22;" width="85%" height="360px" src="http://www.youtube.com/embed/GAWcdrSC1-k?rel=0&amp;showinfo=0&amp;theme=light" frameborder="0" allowfullscreen=""></iframe>

			</div>	
			<div style="padding-top:1%" class="responsive-bottom span6">
				<p style="text-align:center; margin-top:8%; color: #E67E22; line-height: 40px; font-family: 'ganandofont'; font-size: 36px;">
					Es el nuevo portal donde podrás encontrar muchos concursos entretenidos para participar
				</p>
				<p style="text-align:center; margin-top:8%; color: #E67E22; line-height: 40px; font-family: 'ganandofont'; font-size: 36px;">
					¿Qué estás esperando? <a rel="nofollow" href="<?php echo base_url().'user/fb_login'; ?>">¡CONCURSA!</a>
				</p>
			</div>		
		</div>
	</div>
	<div class="space4"></div>
</div>