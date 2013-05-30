<div>

    <img src="https://graph.facebook.com/<?php echo $fb_data['id']; ?>/picture" alt="" class="pic" />
     <br />
    <?php echo "Id Facebook : ".$fb_data['id']; ?>
    <br />
    <?php echo "Nombres : ".$fb_data['first_name']; ?>
    <br />
    <?php echo "Apellidos : ".$fb_data['last_name']; ?>
    <br />
    <?php echo "Link Facebook : ".$fb_data['link']; ?>
    <br />
    <?php echo "Cumplea&ntilde;os : ".$fb_data['birthday']; ?>
    <br />
    <?php echo "Sexo : ".$fb_data['gender']; ?>
    <br />
    <?php 
    if(isset($fb_data['relationship_status']))
        echo "Estado Sentimental : ".$fb_data['relationship_status']; ?>
    <br />
    <?php echo "Correo : ".$fb_data['email']; ?>
    <br />
    <?php 
    if(isset($fb_data['religion']))
        echo "Religion : ".$fb_data['religion']; ?>
    <br />
    <?php 
    if(isset($fb_data['political']))
        echo "Politica : ".$fb_data['political']; ?>
    <br />
    <?php 
    if(isset($fb_data['bio']))
        echo "Sobre mi : ".$fb_data['bio']."</br>"; ?>
    <?php echo "Lenguaje Nativo (?) : ".$fb_data['locale']; ?>
    <br />
    <?php
    if(isset($fb_data['hometown']))
      echo "Lugar de Nacimiento : ".$fb_data['hometown']['name']; 
    ?>
    <br />
    <?php
    if(isset($fb_data['location']))
      echo "Lugar Actual : ".$fb_data['location']['name']; 
    ?>
    <br />


    <?php 
    if(isset($fb_data['education']))
      foreach ($fb_data['education'] as $education_institution) {
        echo "<br/> Estudios : ";
        echo $education_institution['school']['name'];
        echo "<br/> Tipo Institucion : ";
        echo $education_institution['type'];
        echo "<br/>";
        if(isset($education_institution['concentration']))
          foreach ($education_institution['concentration'] as $speciality) 
            echo "Especialidad : ".$speciality['name'];
        
      } 
    ?>

</div>
