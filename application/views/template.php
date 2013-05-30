<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Viddon - Tu Talento, Nuestra Pasi&oacute;n</title>

	<meta property="og:title" content="Viddon. Tu Talento, Nuestra Pasión"/>
	<meta property="fb:app_id" content="374106952676336"/>
	<meta property="og:type" content="website" />

	
	<?php if(isset($public)) {?>
	
	<meta property="og:description" content="Conoce a <?php echo $name.' '.$last_name; ?>, únete a la revolución del talento!."/>

		<meta property="og:image" content="<?php echo HOME.'/img/gallery/'.$image_profile_name ?>"/>
	<?php }else{ ?>
	<meta property="og:description" content="La nueva plataforma online que llevará a toda la gente con talento al éxito, la revolución ya comienza!."/>
	<meta property="og:image" content="<?php echo HOME.'/img/logo.png'?>"/>

	<?php } ?>

	<link rel="icon" 
      type="image/png" 
      href="<?php echo HOME ?>/favicon.ico">

	<meta name="description" content="">
	<meta name="keyword" content="">

	<link href="<?php echo base_url()?>style/main.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/jquery.dataTables.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/jquery.cleditor.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/list-castings.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/list-view.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/publish-view.css" rel="stylesheet">
	<link href="<?php echo base_url()?>style/uniform.default.css" rel="stylesheet"/>
	<link href="<?php echo base_url()?>style/datepicker.css" rel="stylesheet"/>
	<link href="<?php echo base_url()?>style/chosen.css" rel="stylesheet"/>


	<script type="text/javascript">
	var fb_param = {};
	fb_param.pixel_id = '6007047054806';
	fb_param.value = '0.00';
	(function(){
	  var fpw = document.createElement('script');
	  fpw.async = true;
	  fpw.src = '//connect.facebook.net/en_US/fp.js';
	  var ref = document.getElementsByTagName('script')[0];
	  ref.parentNode.insertBefore(fpw, ref);
	})();
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6007047054806&amp;value=0" /></noscript>


</head>

<body>
 	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>	
 	<script src="<?php echo base_url()?>js/chosen.jquery.js"></script>
	<script src="<?php echo base_url()?>js/bootstrap.js"></script>
	<script src="<?php echo base_url()?>js/jquery.cleditor.js"></script>
	<script src="<?php echo base_url()?>js/jquery.uniform.js"></script>
	<script src="<?php echo base_url()?>js/jquery.dataTables.js"></script>
	<script src="<?php echo base_url()?>js/bootstrap-datepicker.js"></script>	
	<script src="<?php echo base_url()?>js/chosen.jquery.js"></script>
	<script src="<?php echo base_url()?>js/jquery.ba-resize.js"></script>
		
	<div id="fb-root"></div>

	<div class="navbar-fixed-top" id="headercontent">
	    <div id="upperhalf">
		    <div class="row-fluid" >
		    	<div style="padding-top: 1%;" class="span2">
					<a href="<?php echo HOME?>"  style="margin-left: 40px;"title="Volver a la P&aacute;ina Principal">
						<img class="image-logo" src="<?php echo base_url(); ?>img/logo.png"/>
					</a>
				</div>
				<div style="padding-top: 1%;" class="span2 header-text-left">
					<a href="<?php echo HOME?>/home/what_is" class="slogan" style="margin-left: -60px;">
						Donde el talento es descubierto
					</a>
				</div>
				
				<div  class="span6 offset2">
					<?php
					
						/*verificacion usuario postulante*/
						$id = $this->session->userdata('id');

						if($this->session->userdata('name') != FALSE)
						{
							$user = $this->session->userdata('name')." ".$this->session->userdata('last_name');
						}
						else if($this->session->userdata('email') != FALSE)
						{
							$user = $this->session->userdata('email');
						}
						else
							$user = "";
						
						/*verificacion ususario hunter*/
						$id_h = $this->session->userdata('logged_in');				
						if($id_h)
						{
							$name = $this->session->userdata('logged_in');
							$name= $name["name"];
						}
						
						if($id)
						{
							echo "<div class='span4 offset2'>";
								echo "<a href='".base_url()."home' style='padding-top:6%' class='span6 menu'>";
									echo "Pagina Principal";
								echo "</a>";
								echo "<a href='".base_url()."home/what_is' style='padding-top: 6%' class='span6 menu'>";
									echo "Quienes Somos";
								echo "</a>";
							echo "</div>";
							echo "<div style='margin-top:2%;' class='span6'>";						
							echo "<li class='welcome-login'> Bienvenido ".anchor('user', $user).' '.anchor('user/logout',' (Cerrar sesi&oacuten)');
							echo "</div>";
						}
						
						elseif ($id_h) 
						{
							echo "<div class='span4 offset2'>";
								echo "<a href='".base_url()."home' style='padding-top:6%' class='span6 menu'>";
									echo "Pagina Principal";
								echo "</a>";
								echo "<a href='".base_url()."home/what_is' style='padding-top:6%' class='span6 menu'>";
									echo "Quienes Somos";
								echo "</a>";
							echo "</div>";
							echo "<div style='margin-top:2%;' class='span6'>";														
								echo "<li class='welcome-login'> Bienvenido ".anchor('hunter', $name).' '.anchor('hunter/logout',' (Cerrar sesi&oacuten)');
							echo "</div>";
						
						}
						else
						{
							echo "<div class='span6 offset2'>";
								echo "<a href='".base_url()."home' class='span4 menu'>";
									echo "Pagina Principal";
								echo "</a>";
								echo "<a href='".base_url()."home/what_is' class='span4 menu'>";
									echo "Quienes Somos";
								echo "</a>";
								echo "<a href='".base_url()."home/login_hunter' class='span4 menu'>";
									echo "Cazatalentos";
								echo "</a>";
							echo "</div>";
							
						}
					
						if(!$id && !$id_h)
						{
							$login_url = HOME."/user/fb_login";
							echo "<div style='padding-top: 2.3%;' id='login-button-container' class='span4'>";
							echo "<a href='".$login_url."' id='login-button'>";
							echo "<img style='margin-left: -8%;' id='login-button-image' src='".HOME."/img/fb-login.png' />";
							echo "</a>";
							echo "</div>";
						}
					
					?>				
				</div>
				
		    </div>	
	    </div>
		
		
	</div>

	<?php $this->load->view($content,$inner_args); ?>
	

	<script type="text/javascript">
	      
	    if($(".chzn-select").length > 0)
			$(".chzn-select").chosen({no_results_text: "No se encontraron resultados"});
		
		if($(".rich_textarea").length > 0)	      
	        $("document").ready(function() {
			    $("textarea.rich_textarea").cleditor({
			          width:        $('.span12').width(), // width not including margins, borders or padding
			          height:       230, // height not including margins, borders or padding
			          controls:     // controls to add to the toolbar
			                        "bold italic underline strikethrough subscript superscript | font size " +
			                        "style | color highlight removeformat | bullets numbering | outdent " +
			                        "indent | alignleft center alignright justify | undo redo | " +
			                        "link unlink",
			          colors:       // colors in the color popup
			                        "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
			                        "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
			                        "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
			                        "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
			                        "666 900 C60 C93 990 090 399 33F 60C 939 " +
			                        "333 600 930 963 660 060 366 009 339 636 " +
			                        "000 300 630 633 330 030 033 006 309 303",    
			          fonts:        // font names in the font popup
			                        "Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond," +
			                        "Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",
			          sizes:        // sizes in the font size popup
			                        "1,2,3,4,5,6,7",
			          styles:       // styles in the style popup
			                        [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
			                        ["Header 3", "<h3>"],  ["Header 4","<h4>"],  ["Header 5","<h5>"],
			                        ["Header 6","<h6>"]],
			          useCSS:       false, // use CSS to style HTML when possible (not supported in ie)
			          docType:      // Document type contained within the editor
			                        '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
			          docCSSFile:   // CSS file used to style the document contained within the editor
			                        "", 
			          bodyStyle:    // style to assign to document body contained within the editor
			                        "margin:4px; font:10pt Arial,Verdana; cursor:text"
			    });
		    });
		
		if($(".rich_textarea_pop_up").length > 0)	      
	        $("document").ready(function() {
			    $("textarea.rich_textarea_pop_up").cleditor({
			          width:        400, // width not including margins, borders or padding
			          height:       230, // height not including margins, borders or padding
			          controls:     // controls to add to the toolbar
			                        "bold italic underline strikethrough subscript superscript | font size " +
			                        "style | color highlight removeformat | bullets numbering | outdent " +
			                        "indent | alignleft center alignright justify | undo redo | " +
			                        "link unlink",
			          colors:       // colors in the color popup
			                        "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
			                        "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
			                        "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
			                        "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
			                        "666 900 C60 C93 990 090 399 33F 60C 939 " +
			                        "333 600 930 963 660 060 366 009 339 636 " +
			                        "000 300 630 633 330 030 033 006 309 303",    
			          fonts:        // font names in the font popup
			                        "Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond," +
			                        "Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",
			          sizes:        // sizes in the font size popup
			                        "1,2,3,4,5,6,7",
			          styles:       // styles in the style popup
			                        [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
			                        ["Header 3", "<h3>"],  ["Header 4","<h4>"],  ["Header 5","<h5>"],
			                        ["Header 6","<h6>"]],
			          useCSS:       false, // use CSS to style HTML when possible (not supported in ie)
			          docType:      // Document type contained within the editor
			                        '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
			          docCSSFile:   // CSS file used to style the document contained within the editor
			                        "", 
			          bodyStyle:    // style to assign to document body contained within the editor
			                        "margin:4px; font:10pt Arial,Verdana; cursor:text"
			    });
		    });
		
      	if($("#datatables").length > 0)
      		$(document).ready(function() {
			    $('#datatables').dataTable({
		    		"sPaginationType": "full_numbers"
				});
			});
		
      	if($("#playermodal").length > 0)
      	{
	      	$("a[data-target=#playermodal]").click(function(ev) {
			    ev.preventDefault();
			    var target = $(this).attr("href");

			    // load the url and show modal on success
			    $("#playermodal .modal-body").load(target, function() { 
			         $("#playermodal").modal("show"); 
			    });
			});

			jQuery(".modal-backdrop, #playermodal .close, #playermodal .btn").live("click", function() {
	        jQuery("#playermodal iframe").attr("src", null);
			});
		}

      	if($("#playermodal_simple").length > 0)
      	{
	      	$("a[data-target=#playermodal_simple]").click(function(ev) {
			    ev.preventDefault();
			    var target = $(this).attr("href");

			    // load the url and show modal on success
			    $("#playermodal_simple .modal-body").load(target, function() { 
			         $("#playermodal_simple").modal("show"); 
			    });
			});

			jQuery(".modal-backdrop, #playermodal_simple .close, #playermodal_simple .btn").live("click", function() {
	        jQuery("#playermodal_simple iframe").attr("src", null);
			});
		}

		if($("#spotmodal").length > 0)
      	{


			jQuery(".modal-backdrop, #spotmodal .close, #spotmodal .btn").live("click", function() {
	        var url = $('#spotiframe').attr('src');
			$('#spotiframe').attr('src', '');
			$('#spotiframe').attr('src', url);
			});
		}

		if($("#dp1").length > 0)
			$(function(){
				window.prettyPrint && prettyPrint();
				$("#dp1").datepicker();
			});
		
		if($("#dp2").length > 0)
			$(function(){
				window.prettyPrint && prettyPrint();
				$("#dp2").datepicker();
			});

		if($(".carousel").length > 0)
			$('.carousel').carousel({
		  		interval: 7000
			});
		
		/* comentarios perfil usuario*/
		function get()
		{
			var input = $('#comment').val();
			 
			if ( $('#comment').val() == '' )
			{
				alert('Debes escribir un comentario antes de Enviarlo. Intenta nuevamente');
			}
			else
			{
				document.getElementById('comment').setAttribute('disabled','');
				document.getElementById('post1').getElementsByTagName('input')[0].setAttribute('disabled', '');
				
				var xmlhttp;

				if (window.XMLHttpRequest)
				{
				  	xmlhttp = new XMLHttpRequest();
				}
				else
				{
				  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						response = xmlhttp.responseText;
						if (response == 0)
						{
							alert('Para comentar debes estar registrado en Viddon. Inténtalo nuevemente.');
						}
						else if(response == 2)
						{
				    		$('#post1').prepend('<img src="../img/profile/user.jpg" width="40px" height="40px"style="display:inline;float:left;">&nbsp;'+'<span style="color:gray;font-family:times new roman;"> Usuario </span> &nbsp;'+ input + '<br/><br/> <hr>');
				    		$('#comment').val('');
				    	}
					}
				}
				
				xmlhttp.open("POST", "<?php echo HOME ?>/user/comments", false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send("comment=" + input);
			}

			document.getElementById('comment').removeAttribute('disabled');
			document.getElementById('post1').getElementsByTagName('input')[0].removeAttribute('disabled');
		}
		 
		if($(".chzn-select").length > 0)
			$(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
   		
		if($(".file").length > 0)
			$(function () 
			{
				
				 $(".file").each(function () {
					$(this).uniform()
					
			      });
			});

			
	    
		(function(d, s, id) 
		{
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
    	
    	if($("#grow").length > 0 && $("#variable").length > 0  )
		{
			if($('#variable').height() >= $('#grow').height() )
			{
				$('#grow').css({
					'height': $('#variable').outerHeight()
				});
			    	
			    jQuery('#variable').bind( 'resize', function(e) {
						  
					$('#grow').css({
						    'height': $('#variable').outerHeight()
					});
				});
			}else
			{
				$('#variable').css({
					'height': $('#grow').outerHeight()
				});
			    	
			    jQuery('#grow').bind( 'resize', function(e) {
						  
					$('#variable').css({
						    'height': $('#grow').outerHeight()
					});
				});
			}
		}

		$('.menu').css({
			'height': $('#headercontent').outerHeight()
		});
			    	

		
		if($(".chosen_filter").length > 0)
		{
			var function_clean_select_all = function () 
			{
				
				 $("option",this).each(function () {
					if(this.selected && this.value == -1)
					{
						$(this).parent().children("option").each(function () {
							if($(this).val() == -2)
								$(this).prop('selected', false);
							else
								$(this).prop('selected', true);
						});
						$(this).prop('selected', false);
						$(this).parent().trigger('liszt:updated');
						return false;
					}
					
					if(this.selected && this.value == -2)
					{
						$(this).parent().children("option").each(function () {
							$(this).prop('selected', false);
						});
						$(this).prop('selected', false);
						$(this).parent().trigger('liszt:updated');
						return false;
					}
					
			      });
			};

			$(".chosen_filter").change(function_clean_select_all);
			$('.chosen_filter').trigger('change');

		}



		var update_chosen_filter = function (event) 
		{
			
			var regExp1 = new RegExp(event.data.regexp); 
	        var result = regExp1.exec($(event.data.target).attr("href"));
	        var temp = (""+result).substr(0,(""+result).length - 1);
	        temp = temp.substr(0,temp.lastIndexOf('/')+1)
	        var uri="";
			
			$("option",this).each(function () {
				if(this.selected)
			    	uri= uri + this.value +"_";
			});
			     
			uri= uri.substr(0,uri.length - 1);
			if(uri=="")
				uri=-2;
	        result = temp + uri + "/";
			    
			$(event.data.target).attr("href",$(event.data.target).attr("href").replace(regExp1,result));

		};	

		/* filtro en home/casting list */
		if($("#filter").length > 0)
		{
			$("#filter").change({regexp: '/[0-9]+/[0-9_-]+/',target: '#filter_button'},update_chosen_filter);
			$('#filter').trigger('change');
		}
		
		var update_state_filter = function (event) 
		{
			
			var regExp1 = new RegExp(event.data.regexp); 
	        var result = regExp1.exec($(event.data.target).attr("href"));
	        var temp = (""+result).substr(0,(""+result).length - 2);
	            
	        result = temp + $(event.data.src).val() + "/";
			    
			$(event.data.target).attr("href",$(event.data.target).attr("href").replace(regExp1,result));

		};	
		
		/* filtro en hunter/casting_list*/
		if($("#casting_status").length > 0)
		{				
			$("#casting_status").change({regexp: '/[0-9]+/[0-3]/',target: '#filter_button',src: '#casting_status'},update_state_filter);
			$('#casting_status').trigger('change');
		}



		if($("iframe").attr('src').indexOf("youtube") >= 0){
			$("iframe").each(function(){
			  var ifr_source = $(this).attr('src');
			  var wmode = "&wmode=opaque";
			  $(this).attr('src',ifr_source+wmode);
			});
		}
			    	    
    </script>
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-39703328-1', 'viddon.com');
	  ga('send', 'pageview');

	</script>
</body>

<footer>


<div class"row">
	<div class="span8 offset3"><p style="color: #7d7d7d;">GlobalDreams SPA | Publica tus castings <a href="<?php echo base_url();?>home/login_hunter">con nosotros</a> | Lee los <a href="<?php echo base_url();?>docs/terms.pdf">T&eacuterminos y condiciones</a> | <a href="mailto:contacto@viddon.com">Cont&aacutectanos</a></p></p></div>
</div>
<div class="row">
	<div class="span8 offset3">
		<div class="row">
				<div class="span11 offset1" style="margin-top: -3px;">
					<a style="margin-left: 30px; text-decoration: none; color: #7d7d7d;" class="second">Viddon &copy; 2013 | Todos los derechos reservados</a>
					<a style="margin-left: 20px;" href="https://twitter.com/ViddonCom" target=”_blank”><img style="width: 25px; height: 25px;" src="<?php echo base_url(); ?>img/twitter-logo.png"/></a>
					<a  href="http://www.facebook.com/pages/Viddoncom/499177723428347?ref=hl" target=”_blank”> <img style="width: 25px; height: 25px;" src="<?php echo base_url(); ?>img/fb-logo.png"/></a>
					<div style="margin-left: 10px;" class="fb-like" data-href="https://www.facebook.com/pages/Viddoncom/499177723428347" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>				

				</div>
		</div>
	</div>
</div>
</footer>