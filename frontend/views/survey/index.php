<?php
use kartik\widgets\SideNav;

/* @var $this yii\web\View */
?>
<h1>Alegeți grupa</h1>

<?php if(isset($active) && !$active): ?>
<p color="red">Ne pare rău, dar chestionarul nu este activ. Adresați-vă administratorului.</p>
<?php endif;?>

<?= SideNav::widget([
    'items' => $items,
]) ?>
