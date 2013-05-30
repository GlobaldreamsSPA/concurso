<style>
.glow {
 background-color: #FFF;
 -webkit-box-shadow: 3px 3px 2px rgba(50, 50, 50, 0.43); -moz-box-shadow:    3px 3px 2px rgba(50, 50, 50, 0.43); box-shadow:         3px 3px 2px rgba(50, 50, 50, 0.43);
 margin-bottom: 1%;
}
</style>

<div class="row-fluid">    
  <div class="span3 user-profile-left">
    <div class="row">
    <?php 
      if(file_exists(APPPATH.'/../img/gallery/'.$image_profile_name) == TRUE)
        echo "<img class='user_image' src='".HOME.'/img/gallery/'.$image_profile_name."'/>";
      else
        echo "<img class='user_image' src='".HOME."/img/profile/user.jpg'/>";
    ?>
    </div>
    <div class="space2"></div>
    <div class="row">
      <?php if(!$public) {?>
      <form action="" method="POST">
        <?php if($postulation_flag) {?>
        <a href="<?php echo HOME.'/home/casting_list'?>" class="btn btn-success" type="submit" name="apply">POSTULAR CASTINGS</a>
        <input type="hidden" name="validate" value="1"/>
        <?php } else{ ?>
        <button data-toggle="modal"  href="#error" class="btn btn-success">POSTULAR CASTINGS</button>
          <?php } ?>
        </form>
        <?php } ?>
    </div>
    <?php if(!$public) {?>
    <div class="row">
        <div class="span9 offset1">                    
          <ul class="nav nav-pills nav-stacked orange">
          <li class="active"><a href="<?php echo HOME."/user/";?>"> <i class="icon-user"></i> Perfil</a>
          </li>
          <li><a href="<?php echo HOME."/user/edit/".$user_id;?>"> <i class="icon-pencil"></i> Editar Datos</a></li>
          <li>
            <a data-toggle="collapse" href="#collapseOne">
              <i class="icon-star-empty"></i> Postulaciones
            </a>
            <div id="collapseOne" class="collapse">
              <ul style="padding-left: 30px;" class="nav nav-pills nav-stacked orange">
                <li><a href="<?php echo HOME."/user/active_casting_list"?>">Activas</a></li>  
                <li><a href="<?php echo HOME."/user/results_casting"?>">Resultados</a></li>  
              </ul>
            </div>
          </li>  
          <li><a href="<?php echo HOME."/user/logout";?>"> <i class="icon-off"></i> Cerrar Sesi&oacuten</a></li>          
        </ul>
      </div><!--NAVEGACION LATERAL IZQUIERDA -->
    </div>
    <?php } ?>
  </div>

    <div class="span8 offset1 user-profile-right"> <!-- CARGAREMOS LOS DATOS DE LA GALERIA -->
    <div class="row">
      <div class="span8">
        <h2><a href="<?php echo HOME."/user"?>"> Perfil</a> / Galeria de Fotos</h2>
      </div>      
      <div style="margin-top:15px;" class="span4">
        <button data-toggle="modal"  href="#add_photo" class="btn btn-primary">Agregar foto</button>
      </div>
    </div>
    
    <!-- CARGO EL MODAL-->
    <div id="add_photo" class="modal hide fade" style="width: 430px !important;" tabindex="-1" role="dialog" aria-labelledby="AgregaVideo" aria-hidden="true">
      <form id="photo_upload_form" enctype="multipart/form-data" action="<?php echo HOME.'/user/'?>" method="post">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Agregar fotografia</h3>
        </div>
        <div class="modal-body">
            <div>  
              <input name="url_photo" style="width:96%" type="text" placeholder="Dirección - URL foto" value="">
              o                      
              <div style="margin-left: -10px; margin-top: -20px;" id="image_upload">
              <h5>Sube una imagen de t&iacute</h5>
              <?php echo form_upload(array('name' => 'upload_photo','class'=> 'file')); ?>
              <?php
                  echo form_hidden('image','');
                  echo form_error('image'); 
              ?>
              </div>
              <div class="space2"></div>
              <input type="hidden" name="from_gallery" value="yes" />
              <div class="space1"></div>  
            </div>
        </div>
        <div class="modal-footer" style="height: 30px;">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
      </form>
    </div>      <!-- MODAL-->
    
    
  
      <ul class="thumbnails" style="width:100%;"> <!-- ABRE LOS THUMBNAILS -->
      <?php 
      $i=0;
      foreach($photos as $photo){
        $i++;
      if($i%2 == 0 )                
          if($photo["id"] == $image_profile) echo '<div style="padding:8px;" title="Imagen Perfil" class="span6 glow">'; //carga el efecto de "brillo"
        else echo '<div style="padding:8px;" class="span6">';  
      else
        {
        echo '<div class="space1"></div>';
        echo '<div class="row">';
        if($photo["id"] == $image_profile) echo '<div style="padding:8px;" title="Imagen Perfil" class="span6 glow">';//carga el efecto de "brillo"
        else echo '<div style="padding:8px;" class="span6">';
        }                
      ?>
        <div class="row">
        <?php if(!$public) {?>
          <div class="span1">
            <a class="btn-del" title="Establecer como foto de perfil" href="<?php echo HOME."/user/photo_gallery/1/".$photo['id'];?>" class="btn btn-primary"><i class="icon-star-empty"></i></a>
          </div>
          <div style="margin-left: 1px;" class="span1">
            <a class="btn-del" title="Eliminar foto" href="<?php echo HOME."/user/photo_gallery/2/".$photo['id'];?>" class="btn btn-primary"><i class="icon-remove"></i></a>
          </div>
          
        <?php } ?>
      </div>
        <div class="row">
	        <div style="margin-left:1%;" class="span12">
	            <a href="#" class="thumbnail"><!-- ABRA VISOR DE GALERIA -->
	          <img data-src="<?php echo GALLERY.$photo['name'];?>" alt="<?php echo $photo['description'];?>" title="<?php echo $photo['description'];?>" style="width: auto; height: 150px;" src="<?php echo GALLERY.$photo['name'];?>">              
	        </a>
	        </div>
       </div>
      </div>

      <?php 
    if($i%2 == 0 )                
      echo '</div>';  
    if($i%2 != 0 && $i == count($photos))
      echo '</div>';  
    }?>
    </ul>
   </div>
 </div>