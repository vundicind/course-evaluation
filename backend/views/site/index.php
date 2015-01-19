<?php
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

     <div class="jumbotron">
     	<?php if(!$active):?>
        	<p><a class="btn btn-lg btn-success" href="<?=yii\helpers\Url::to(['survey/activate']) ?>"><?= Yii::t('app', 'Activate survey') ?></a></p>
		<?php else: ?>        	
        	<p><a class="btn btn-lg btn-danger" href="<?=yii\helpers\Url::to(['survey/deactivate']) ?>"><?= Yii::t('app', 'Deactivate survey') ?></a></p>
        <?php endif;?>	
    </div>

    <div class="body-content">
    </div>
</div>
