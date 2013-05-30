<div class="content" id="content">
	<div class="space4"></div>
	<div class="space4"></div>
	<div class="container-fluid">
	  	<div class="row">
	  		<div class="span9">
	  			<div  style="border-radius: 5px; margin-left:3%;" id="variable" class="row-fluid">
		  			<div style="padding: 2%;">
		  				<?php $this->load->view($hunter_content);  ?>
		  			</div>
		  		</div>
			 </div>
		
			<div class="span3">
				<div style="border-radius: 5px; margin-left:8%; text-align:center;" id="grow" class="row-fluid">	
					<div style="margin:7%;">
						<h3 id="profile"> Estado Castings </h3>
						<?php foreach ($castings_dash as $casting) {?>
							
						
						<div style="height: 10"class="row">
							<div class= "span9">
								<a href="<?php echo HOME."/hunter/casting_detail/".$casting["id"];?>">
								<h5 class="list-view-title"><?php echo $casting["title"]?></h5>
								</a>
							</div>
							<div style="margin-top: 5%;"class= "span3">
								<i class="icon-time"></i> <?php echo $casting["days"]?> d&iacute;as
							</div>
						</div>
						<div class="progress" style="height: 17px;">
						    <div class="bar <?php echo $casting["target_applies_color"]?>" style="width: <?php echo $casting["target_applies"]?>%; color:black !important;"><?php echo $casting["target_applies"]?>%</div>
						</div>
						<div class="progress" style="height: 17px;">
						  	<div class="bar <?php echo $casting["reviewed_color"]?>" style="width: <?php echo $casting["reviewed"]?>%; color:black !important;" ><?php echo $casting["reviewed"]?>%</div>
						</div>
						
						<?php }?>				

						<div class="space2"></div>
						<div class="space05"></div>
						
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<div class="space4">
	</div>
</div>