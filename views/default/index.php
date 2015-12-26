<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\seo\models\Seo;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel yeesoft\seo\models\search\SeoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yee/seo', 'Search Engine Optimization');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title seo-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/seo/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'page-grid-pjax']) ?>
                </div>
            </div>

            <?php Pjax::begin(['id' => 'seo-grid-pjax']) ?>

            <?=
            GridView::widget([
                'id' => 'seo-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'seo-grid',
                    'actions' => [
                        Url::to(['bulk-delete']) => Yii::t('yii', 'Delete'),
                    ]
                ],
                'columns' => [
                    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/seo/default',
                        'title' => function (Seo $model) {
                            return Html::a($model->title, ['/seo/default/view', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                    ],
                    'author',
                    'keywords',
                    'description',
                    [
                        'attribute' => 'created_by',
                        'filter' => User::getUsersList(),
                        'filterInputOptions' => [],
                        'value' => function (Seo $model) {
                            return Html::a($model->author->username,
                                ['/user/default/view', 'id' => $model->created_by],
                                ['data-pjax' => 0]);
                        },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUsers'),
                        'options' => ['style' => 'width:180px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>

