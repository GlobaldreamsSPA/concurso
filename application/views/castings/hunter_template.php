<div class="content" id="content">
	<div class="space2"></div>
	<div class="container-fluid">
	  	<div class="row">
	  		<div class="span9">
	  			<div  style="border-radius: 5px; margin-left:3%;">
		  			<div style="padding: 2%; margin-top: -2%;">
		  				<?php $this->load->view($hunter_content);  ?>
		  			</div>
		  		</div>
			 </div>
		
			<div style="margin-left:2%;" class="span3">
				<div style=" text-align:center;" class="row-fluid top-div-right">
			    	<div style="margin-left: -3% !important" class="row top-title" >
						<h1>Estado Concursos</h1>
					</div>
					<div class="space1"></div>
					<?php foreach ($castings_dash as $casting) {?>
						
					
					<div style="height: 10"class="row">
						<div class= "span10">
							<a href="<?php echo HOME."/hunter/casting_detail/".$casting["id"];?>">
							<h5 class="list-view-title"><?php echo $casting["title"]?></h5>
							</a>
						</div>
						<div style="margin-top: 4%;"class= "span2">
							<i class="icon-time"></i> <?php echo $casting["days"]?> d
						</div>
					</div>
					<div class="progress" style="width:97% !important; height: 17px; border: 1px solid #95A5A6;">
					    <div class="bar <?php echo $casting["target_applies_color"]?>" style="width: <?php echo $casting["target_applies"]?>%; color:white !important; font-weight: 900	;"><?php echo $casting["target_applies"]?>%</div>
					</div>

					Postulaciones/Meta : <?php echo $casting["applies"]."/".$casting["max_applies"]; ?>
					<br>
					Estado : <span class="label <?php echo $casting['label_color']; ?>"> <?php echo $casting["status"];?></span>

					<div class="space1"></div>

					<?php }?>				

					<div class="space2"></div>
					<div class="space05"></div>
					
				</div>
			</div>
		
		</div>
	</div>
	<div class="space4">
	</div>
</div>