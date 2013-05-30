<script>
$(document).ready(function(){
	$('.upvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes').html(votes[0]);
			$('#downvotes').html(votes[1]);

		}) 
	})
});

$(document).ready(function(){
	$('.downvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes').html(votes[0]);
			$('#downvotes').html(votes[1]);

		}) 
	})
});

</script>


<div style="margin-left:10px;" class="row">
	<div class="span4" style="padding-right: 2%; border-right:solid 1px">
		<div style="margin-bottom: 10px;font-size: 18px;" id="profile" ><?php echo $name;?></div>
		<div style= "overflow-y: scroll; min-height: 190px; max-height:190px; width: 100%;"><?php echo $description;?></div>
		
		<div style="max-height:180px; margin-top:5%;"class="row">
			<div class="span6">
				<a class="home-video-author" href="<?php echo HOME.'/user/index/'.$iduser; ?>">
					<?php
					if(file_exists(APPPATH.'/../img/gallery/'.$image) == TRUE)
						echo "<img class='user_image_main_page' src='".HOME.'/img/gallery/'.$image."'/>";
					else
						echo "<img class='user_image_main_page' src='".HOME."/img/profile/user.jpg'/>";
					?>
				</a>
			</div>
			<div class="span6">
				
				<div style="margin-top: 15%;" >
					<a class="home-video-author" href="<?php echo HOME.'/user/index/'.$iduser; ?>"><?php echo $username." ".$userlastname; ?></a>								
				</div>
				<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo HOME.'/user/index/'.$iduser; ?>&amp;send=false&amp;layout=box_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=90&amp;appId=374106952676336" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:90px;" allowTransparency="true"></iframe>

			</div>
		</div>
		


	</div>
	<div class="span8">
		<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a>  
		<div style="padding-left:2%; padding-top:5%; text-align: center">
			<iframe width="100%" height="270px" src="http://www.youtube.com/embed/<?php echo $id_video.'?rel=0&autoplay=1&showinfo=0'?>" frameborder="0" allowfullscreen></iframe> 
		</div>
		<div style="padding-left:2%; padding-top:2%;">
			<div class="span5">
				<a class="upvote vote" href="<?php echo HOME.'/home/vote/1/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/upgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/upwhite.png" ?>'/> <p id="upvotes" style="display:inline;"><?php echo $upvotes;?></p></a>  
				<a class="downvote vote" href="<?php echo HOME.'/home/vote/0/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/downgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/downwhite.png" ?>'/> <p id="downvotes" style="display:inline;"><?php echo $downvotes;?></p></a>  
			</div>
			<div class="span7" style="text-align: right">
				<p style="font-weight:bold;">Reproducciones: <?php echo $video_reproductions; ?></p>
			</div>
		</div>
	</div>
</div>