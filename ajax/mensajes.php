<?php
function exito($messages)
{
  ?>
  <div class="alert alert-success" role="alert">
  						<button type="button" class="close" data-dismiss="alert">&times;</button>
  						<strong>¡Bien hecho!</strong>
  						<?php
  							foreach ($messages as $message) {
  									echo $message;
  								}
  							?>
  				</div>';
          <?php
}
