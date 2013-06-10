<script type="text/javascript">

    var state_des = true;
    $("#des").click(function () {

		$("#des").css("z-index","0");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","-1");

        if (state_des) {
            $("#des").animate({
                height: 410,
                width: "55%"
            }, 1000);
            $("#des-text").append($("#text-des").html());
        } else {
            $("#des").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#pri").css("z-index","0");
				$("#bas").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#des-text").empty();
 

        }
  
		state_des = !state_des;
    });

    var state_pri = true;
    $("#pri").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","0");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","-1");

        if (state_pri) {
            $("#pri").animate({
                height: 410,
                width: "55%"
            }, 1000);
            $("#pri-text").append($("#text-pri").html());
        } else {
            $("#pri").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#bas").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#pri-text").empty();
              
        }
  
		state_pri = !state_pri;
    });
	
	var state_bas = true;
    $("#bas").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","0");
		$("#ste").css("z-index","-1");

        if (state_bas) {
            $("#bas").animate({
                height: 410,
                width: "55%"
            }, 1000);
            $("#bas-text").append($("#text-bas").html());

        } else {
            $("#bas").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#pri").css("z-index","0");
				$("#ste").css("z-index","0");
				}
            );
            $("#bas-text").empty();
          
        }
  
		state_bas = !state_bas;
    });

    var state_ste = true;
    $("#ste").click(function () {

		$("#des").css("z-index","-1");
		$("#pri").css("z-index","-1");
		$("#bas").css("z-index","-1");
		$("#ste").css("z-index","0");

        if (state_ste) {
            $("#ste").animate({
                height: 410,
                width: "55%"
            }, 1000);
            $("#ste-text").append($("#text-ste").html());

        } else {
            $("#ste").animate({
                height: 200,
                width: "27%"
            }, 1000, function(){
				$("#des").css("z-index","0");
				$("#pri").css("z-index","0");
				$("#bas").css("z-index","0");
				}
            );
            $("#ste-text").empty();

        }
  
		state_ste = !state_ste;
    });
	
</script>


<div style="margin-left:10px;" class="row">
	<div class="span11">
	<h2 style="text-align: center; position:relative; z-index: -1;" id="profile">	<?php echo $title; ?> </h2>
	</div>
	<div class="span1">
		<h2><a class="close" data-dismiss="modal"><span class="fui-cross"></span></a> </h2>
	</div>
</div>
<div style="margin-left:10px; margin-top:2%; margin-bottom:2%; height: 90%;" class="row">
	<div class="span5" style="padding-right: 2%;">
		<img src='<?php echo $full_image; ?>'/>
		<div style="margin-top: 5%; margin-bottom: 5%;">
			<?php 
				echo "<a href='".HOME."/home?search_terms=&category=".$category_id."&prize=' target='_blank' class='btn btn-inverse tag'>".$category."</a>";
				
				foreach ($prizes as $id => $prize ) 
					if($prize!="")
					{
						echo "<a href='".HOME."/home?search_terms=&category=&prize=".$id."' target='_blank' class='btn btn-inverse tag'>".$prize."</a>";
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
	<div class="span7" style="height:420px;">
		<div id="des" style="position:absolute; width:27%; height:200px; background-color:#3498DB">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Descripci&oacute;n
			</h3>
			<div id="des-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="pri" style="right:1.5%; position:absolute; width:27%; height:200px; background-color:#2ECC71">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				Premios
			</h3>
			<div id="pri-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="bas"  style="position:absolute; width:27%; height:200px; bottom:15%; background-color:#F39C12">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Puedo Concursar?
			</h3>
			<div id="bas-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>
		<div id="ste" style="right:1.5%;  position:absolute;  width:27%; height:200px; bottom:15%; background-color:#F1C40F">
			<h3 style="text-align: center; margin-top:80px; color:#ffffff;">
				¿Como Concursar?
			</h3>
			<div id="ste-text" style="color:#ffffff; padding:5%; font-size:15px;">
			</div>
		</div>

	</div>
</div>
<div style="margin-right:2%;" class="row">
	<a class="btn btn-primary pull-right" href="#">CONCURSAR</a>
</div>

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