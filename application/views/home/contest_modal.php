<div style="margin-left:10px;" class="row">
	<div class="span11">
	<h2 style="text-align: center" id="profile">	<?php echo $title; ?> </h2>
	</div>
	<div class="span1">
		<h2><a class="close" data-dismiss="modal"><span class="fui-cross"></span></a> </h2>
	</div>
</div>
<div style="margin-left:10px; margin-top:2%; margin-bottom:2%; height: 90%;" class="row">
	<div class="span4" style="padding-right: 2%;">
		<img src='<?php echo $full_image; ?>'/>
		<div style="margin-top: 5%; margin-bottom: 5%;">
			<?php 
				echo "<a class='btn btn-inverse tag'>".$category."</a>";
				foreach ($prizes as $prize) 
					if(!is_null($prize))
					{
						echo "<a class='btn btn-inverse tag'>".$prize."</a>";
					}
			?>
		</div>
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
	<div class="span8">
		<div class="span6" style="height:200px; background-color:#3498DB">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Descripci&oacute;n
			</h3>
		</div>
		<div class="span6" style="height:200px; background-color:#2ECC71">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Premios
			</h3>
		</div>
		<div class="span6" style="height:200px; margin-top:1%; background-color:#F39C12">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Puedo Concursar?
			</h3>
		</div>
		<div class="span6" style="height:200px; margin-top:1%; background-color:#F1C40F">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Como Concursar?
			</h3>
		</div>

	</div>
</div>
<div style="margin-right:2%;" class="row">
	<a class="btn btn-primary pull-right" href="#">CONCURSAR</a>
</div>