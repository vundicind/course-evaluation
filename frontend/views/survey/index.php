<?php
use kartik\widgets\SideNav;

/* @var $this yii\web\View */
?>
<h1>Alegeți grupa</h1>

<?php if(isset($active) && !$active): ?>
<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  Ne pare rău, dar chestionarul nu este activ. Adresați-vă administratorului.
</div>
<p color="red"></p>
<?php endif;?>

<?= SideNav::widget([
    'items' => $items,
]) ?>
