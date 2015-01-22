<?php

use yii\grid\GridView;

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
    <div class="row">
    <div class="col-md-4">
    <?php if($active && !empty($summary)):?>
    	<?= kartik\helpers\Html::panel([
			'heading' => 'Sumarul răspunsurilor',
           	'body' => '',
           	'postBody' => kartik\helpers\Html::listGroup([
               [
                   'content' => 'Răspunsuri complete',
                   'url' => '#',
                   'badge' => $summary['completed_responses']
               ],
               [
                   'content' => 'Răspunsuri incomplete',
                   'url' => '#',
                   'badge' => $summary['incomplete_responses']
               ],
               [
                   'content' => 'Total răspunsuri',
                   'url' => '#',
                   'badge' => $summary['full_responses']
               ],
               [
               		'content' => 'Numărul de studenți (aproximativ)',
               		'url' => '#',
               		'badge' => $summary['students']
               	],
               		 
           ], [], 'ul', 'li'),
           'footer'=> '',
           'headingTitle' => true,
           'footerTitle' => true,
       ]
      ) ?>
    
    <?php endif;?>
    </div>
    
        <div class="col-md-4">
    	<?= kartik\helpers\Html::panel([
			'heading' => '',
           	'body' => '',
           'footer'=> '',
           'headingTitle' => true,
           'footerTitle' => true,
       ]
      ) ?>
    </div>
    

        <div class="col-md-4">
    	<?= kartik\helpers\Html::panel([
			'heading' => '',
           	'body' => '',
           'footer'=> '',
           'headingTitle' => true,
           'footerTitle' => true,
       ]
      ) ?>
    </div>
    
    </div>
    
        <?php if(count($nonCorrespondence['FACULTATEA']) > 0):?>
        	<h3>Faculty noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['FACULTATEA'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>
    
        <?php if(count($nonCorrespondence['CICLUL']) > 0):?>
        	<h3>Study cycle noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['CICLUL'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>

        <?php if(count($nonCorrespondence['SPECIALITATEA']) > 0):?>
        	<h3>Specialty noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['SPECIALITATEA'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>
    	
        <?php if(count($nonCorrespondence['GRUPA']) > 0):?>
        	<h3>Group noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['GRUPA'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>

        <?php if(count($nonCorrespondence['DISCIPLINA']) > 0):?>
        	<h3>Course noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['DISCIPLINA'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>

        <?php if(count($nonCorrespondence['ACTIVITATEA']) > 0):?>
        	<h3>Activity type noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['ACTIVITATEA'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>

        <?php if(count($nonCorrespondence['PROFESORUL']) > 0):?>
        	<h3>Instructor noncorrespondence:</h3>
        	<ul>
        	<?php foreach($nonCorrespondence['PROFESORUL'] as $row):?>
        		<li>[<?= $row['code'] ?>] <?= $row['answer'] ?></li>
        	<?php endforeach;?>
        	</ul>
        <?php endif;?>
    	
    </div>
</div>
