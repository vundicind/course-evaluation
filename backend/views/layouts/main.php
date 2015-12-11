<?php
use backend\assets\AppAsset;
use kartik\growl\Growl;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Brand'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => Yii::t('app', 'Data1'), 'items' => [
            ['label' => Yii::t('app', '{n, plural, =1{Faculty} other{Faculties}}', ['n' => 2]), 'url' => ['/faculty/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Study Cycle} other{Study Cycles}}', ['n' => 2]), 'url' => ['/study-cycle/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Specialty} other{Specialties}}', ['n' => 2]), 'url' => ['/specialty/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Study Form} other{Study Forms}}', ['n' => 2]), 'url' => ['/study-form/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Semester} other{Semesters}}', ['n' => 2]), 'url' => ['/semester/index']],
        ]],
        ['label' => Yii::t('app', 'Data2'), 'items' => [
            ['label' => Yii::t('app', '{n, plural, =1{Instructor} other{Instructors}}', ['n' => 2]), 'url' => ['/instructor/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Course} other{Courses}}', ['n' => 2]), 'url' => ['/course/index']],
            ['label' => Yii::t('app', '{n, plural, =1{Activity Type} other{Activity Types}}', ['n' => 2]), 'url' => ['/activity-type/index']],
        ]],
        ['label' => Yii::t('app', 'Data3'), 'items' => [
            ['label' => Yii::t('app', '{n, plural, =1{Group} other{Groups}}', ['n' => 2]), 'url' => ['/group/index']],
//		            ['label' => Yii::t('app', '{n, plural, =1{Group Activity} other{Groups Activities}}', ['n' => 2]), 'url' => ['/group-activity/index']],
        ]],
        ['label' => Yii::t('app', 'Data4'), 'items' => [
            ['label' => Yii::t('app', 'Settings'), 'url' => ['/settings']],
        ]],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <?php
    foreach (Yii::$app->session->getAllFlashes() as $type => $message):; ?>
        <?php
        echo Growl::widget([
            'type' => ($type == 'error') ? Growl::TYPE_DANGER : $type,
            'body' => $message,
            'delay' => 1700
        ]);
        ?>
    <?php endforeach; ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('app', 'Brand'); ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
