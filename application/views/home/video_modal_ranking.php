<script>
$(document).ready(function(){
	$('.upvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes_r').html(votes[0]);
			$('#downvotes_r').html(votes[1]);

		}) 
	})
});

$(document).ready(function(){
	$('.downvote').bind('click',function(event){
		event.preventDefault();
		$.get(this.href,{},function(response){
			var votes = response.split("-");

			$('#upvotes_r').html(votes[0]);
			$('#downvotes_r').html(votes[1]);

		}) 
	})
});

</script>

<div style="overflow:hidden; padding:2%; margin-left: 2%;" class="row">
	<div class="span8">
		<div style="font-size: 18px;" id="profile" ><?php echo $title;?></div>
	</div>
	<div class="span3">
		<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo HOME.'/user/index/'.$iduser; ?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=374106952676336" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>
	</div>
	<div class="span1">
		<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a>  
	</div>
	<div class="row">
		<div style="padding-top:3.5%;padding-left:2%; padding-right:2%;padding-bottom:1.5%;">
			<iframe width="100%" height="270px" src="http://www.youtube.com/embed/<?php echo $id_video.'?rel=0&autoplay=1&showinfo=0'?>" frameborder="0" allowfullscreen></iframe> 
		</div>
	</div>
	<div style="padding-top:2%;">
			<div class="span5">
				<a class="upvote vote" href="<?php echo HOME.'/home/vote/1/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/upgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/upwhite.png" ?>'/> <p id="upvotes_r" style="display:inline;"><?php echo $upvotes;?></p></a>  
				<a class="downvote vote" href="<?php echo HOME.'/home/vote/0/'.$id_bdd_video ?>"> <img class="greyvote" src='<?php echo HOME."/img/downgrey.png" ?>'/> <img class="whitevote" src='<?php echo HOME."/img/downwhite.png" ?>'/> <p id="downvotes_r" style="display:inline;"><?php echo $downvotes;?></p></a>  
			</div>
			<div class="span7" style="text-align: right">
				<p style="font-weight:bold;">Reproducciones: <?php echo $video_reproductions; ?></p>
			</div>
		</div>

	<div class="span12">
		<div style="margin-top: 1.5%; overflow-y: scroll; min-height: 60px; max-height:60px; width: 100%;"><?php echo $description;?></div>
	</div>
</div>