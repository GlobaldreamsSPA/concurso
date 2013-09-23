<script type="text/javascript">
	if($(window).width() < 930){
		
		$(".responsive-top").removeClass('span6');  
		$(".responsive-top").addClass("row");

		$(".responsive-bottom").css("padding-top","4%");
		$(".responsive-bottom").removeClass('span6');  
		$(".responsive-bottom").addClass("span11 offset1");

		$(".addable").addClass("space4");

	   	
	}else if($(window).width() >= 930)
	{
		$(".responsive-top").addClass('span6');  
		$(".responsive-top").removeClass("row");

		$(".responsive-bottom").css("padding-top","1%");
		$(".responsive-bottom").addClass('span6');  
		$(".responsive-bottom").removeClass("span11 offset1");

		$(".addable").removeClass("space4");


	}

	$(window).resize(function(){
		if($(this).width() < 930){
			
			$(".responsive-top").removeClass('span6');  
			$(".responsive-top").addClass("row");

			$(".responsive-bottom").css("padding-top","4%");
			$(".responsive-bottom").removeClass('span6');  
			$(".responsive-bottom").addClass("span11 offset1");

			$(".addable").addClass("space4");

		   	
		}else if($(this).width() >= 930)
		{
			$(".responsive-top").addClass('span6');  
			$(".responsive-top").removeClass("row");

			$(".responsive-bottom").css("padding-top","1%");
			$(".responsive-bottom").addClass('span6');  
			$(".responsive-bottom").removeClass("span11 offset1");

			$(".addable").removeClass("space4");


		}
	});

</script>
<div class="content_lh" id="content">
	<div class="space2"></div>
	<div class="content-fluid">
		<div class="row">
			<h1 style="text-align:center; margin-bottom:20px; color: #4da0d8; font-family: 'ganandofont'; font-size: 50px !important;" > ¿QUE ES GANANDO.CL?</h1>									
			<div class="addable"></div>
			<div style="margin-top:2%; margin-left:3%; text-align:center;" class="responsive-top span6">
				
				<iframe style="border: 10px solid #E67E22; border-radius:8px;" width="85%" height="360px" src="https://www.youtube.com/embed/yAlfQibk1J0?rel=0&amp;showinfo=0&amp;theme=light" frameborder="0" allowfullscreen=""></iframe>

			</div>	
			<div style="padding-top:1%" class="responsive-bottom span6">
				<div class="space1"></div>
				<div style="text-align:center;">
					<img src="<?php echo HOME."/img/about-icon.png";?>"/>
				</div>
				<p style="text-align:center; color: #4da0d8; line-height: 32px; font-family: 'ganandofont'; font-size: 28px;">
					Es el nuevo portal donde podrás encontrar muchos concursos entretenidos para participar
				</p>
				<div class="space1"></div>
				<p style="text-align:center; color: #4da0d8; line-height: 30px; font-family: 'ganandofont'; font-size: 26px;">
					¿Qué estás esperando?				
				</p>
				<p style="text-align:center; color: #4da0d8; line-height: 40px; font-family: 'ganandofont'; font-size: 26px;">
					 <a rel="nofollow" href="<?php echo base_url().'user/fb_login'; ?>">¡CONCURSA!</a>
				</p>
			</div>		
		</div>
	</div>
	<div class="space4"></div>
</div>