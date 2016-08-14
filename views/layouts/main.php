<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
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
        'brandLabel' => app()->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (!Yii::$app->user->isGuest) {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => [
                ['label' => 'Главная', 'url' => ['site/index']],
                ['label' => 'Категории', 'url' => ['category/index']],
                ['label' => 'Расходы', 'url' => ['expense/index']],
                ['label' => 'Отчеты', 'url' => ['report/index']],
                ['label' => 'Настройки', 'url' => ['setting/index']],
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>',
            ],
        ]);
    }
    NavBar::end();
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <?= Menu::widget([
                    'options' => [
                        'class' => 'nav nav-sidebar',
                    ],
                    'items'   => [
                        // Important: you need to specify url as 'controller/action',
                        // not just as 'controller' even if default action is used.
                        ['label' => 'Главная', 'url' => ['site/index'], 'visible' => !app()->user->isGuest],
                        // 'Products' menu item will be selected as long as the route is 'product/index'
                        ['label' => 'Категории', 'url' => ['category/index'], 'visible' => !app()->user->isGuest],
                        ['label' => 'Расходы', 'url' => ['expense/index'], 'visible' => !app()->user->isGuest],
                        ['label' => 'Отчеты', 'url' => ['report/index'], 'visible' => !app()->user->isGuest],
                        ['label' => 'Предельные суммы', 'url' => ['expense-limit/index'], 'visible' => !app()->user->isGuest],
                        ['label' => 'Настройки', 'url' => ['setting/index'], 'visible' => !app()->user->isGuest],
                    ],
                ]); ?>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <?= Alert::widget() ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= app()->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
