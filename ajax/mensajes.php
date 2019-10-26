<?php
#archivo para arrojar los mensajes del sistema
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

function exito($messages)
{
    ?>
  <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
          </div>
          <?php
}

function error($errors)
{
    ?>
  <div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
  </div>
  <?php
}
