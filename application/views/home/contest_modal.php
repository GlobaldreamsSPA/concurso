<div style="margin-left:10px;" class="row">
	<div class="span4" style="padding-right: 2%;">
		<img src='<?php echo $full_image; ?>'/>
		<?php 
			echo "Tipo de concurso: ".$category;
			echo "<br>"; 
			echo "Tiempo restante: ".$days." d&iacute;as"; 
			echo "<br>"; 
			foreach ($prizes as $prize) 
				if(!is_null($prize))
				{
					echo $prize;
					echo "<br>"; 
				}
		?>
		<div class="span8">
			<div class="span6">
				<img style="max-width:50px;"src='<?php echo $logo; ?>'/>
			</div>
			<div class="span6">
				<?php echo $entity; ?>
			</div>
		</div>


	</div>
	<div class="span8">
		<a class="close" data-dismiss="modal"><i class="icon-remove"></i></a>  
		<div style="padding-left:2%; text-align: center">
			<h4 id="profile">	<?php echo $title; ?> </h4>
			<?php echo $description; ?>
		</div>
	</div>
</div>