<?php

use bl\cms\shop\common\entities\Category;
use bl\cms\shop\widgets\ManageButtons;
use bl\multilang\entities\Language;
use dektrium\user\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel bl\cms\shop\common\entities\SearchCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('shop', 'Categories');
$this->params['breadcrumbs'] = [
    Yii::t('shop', 'Shop'),
    $this->title
];
?>
<div class="ibox">

    <div class="ibox-title">
        <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-user-plus']) .
            Yii::t('shop', 'Create category'), ['save', 'languageId' => Language::getCurrent()->id], ['class' => 'btn btn-primary btn-xs pull-right']);
        ?>
        <h5>
            <i class="glyphicon glyphicon-list">
            </i>
            <?= Html::encode($this->title); ?>
        </h5>
    </div>

    <div class="ibox-content">
        <?php Pjax::begin([
            'enablePushState' => false,
            'linkSelector' => '.pjax',
            'timeout' => 10000,
        ]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterRowOptions' => ['class' => 'm-b-sm m-t-sm'],
            'options' => [
                'class' => 'project-list'
            ],
            'tableOptions' => [
                'id' => 'my-grid',
                'class' => 'table table-hover'
            ],

            'summary' => "",

            'columns' => [

                /*POSITION*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'format' => 'html',
                    'label' => Yii::t('shop', 'Position'),
                    'value' => function ($model) {
                        $buttonUp = Html::a(
                            '',
                            Url::toRoute(['up', 'id' => $model->id]),
                            [
                                'class' => 'pjax fa fa-chevron-up'
                            ]
                        );
                        $buttonDown = Html::a(
                            '',
                            Url::toRoute(['down', 'id' => $model->id]),
                            [
                                'class' => 'pjax fa fa-chevron-down'
                            ]
                        );
                        return $buttonUp . '<div>' . $model->position . '</div>' . $buttonDown;
                    },
                    'contentOptions' => ['class' => 'vote-actions col-md-1'],
                ],

                /*TITLE*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-3'],
                    'attribute' => 'title',
                    'value' => function ($model) {
                        $content = null;
                        if (!empty($model->translation->title)) {
                            $content = Html::a(
                                $model->translation->title,
                                Url::toRoute(['save', 'id' => $model->id, 'languageId' => Language::getCurrent()->id])
                            );
                        }
                        return $content;
                    },
                    'label' => Yii::t('shop', 'Title'),
                    'format' => 'html',
                    'contentOptions' => ['class' => 'project-title col-md-3'],
                ],

                /*PARENT CATEGORY*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-3'],
                    'attribute' => 'parent_id',
                    'filter' => ArrayHelper::map(Category::find()->all(), 'id', 'translation.title'),
                    'value' => 'parent.translation.title',
                    'label' => Yii::t('shop', 'Parent category'),
                    'format' => 'html',
                    'contentOptions' => ['class' => 'project-title col-md-3'],
                ],

                /*IMAGES*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-2'],
                    'attribute' => 'images',
                    'value' => function ($model) {
                        $content = '';

                        if (!empty($model->cover)) {
                            $content .= Html::img('/images/shop-category/cover/' . $model->cover . '-small.jpg', ['class' => 'img-circle']);
                        }
                        if (!empty($model->thumbnail)) {
                            $content .= Html::img('/images/shop-category/thumbnail/' . $model->thumbnail . '-small.jpg', ['class' => 'img-circle']);
                        }
                        if (!empty($model->menu_item)) {
                            $content .= Html::img('/images/shop-category/menu_item/' . $model->menu_item . '-small.jpg', ['class' => 'img-circle']);
                        }

                        return Html::a($content, Url::toRoute(['add-images', 'categoryId' => $model->id, 'languageId' => Language::getCurrent()->id]));
                    },
                    'label' => Yii::t('shop', 'Images'),
                    'format' => 'html',
                    'contentOptions' => ['class' => 'col-md-2 project-people'],
                ],

                /*SHOW*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-1'],
                    'format' => 'html',
                    'attribute' => 'show',
                    'filter' =>
                        Html::activeDropDownList($searchModel, 'show',
                            [
                                1 => \Yii::t('shop', 'On'),
                                0 => \Yii::t('shop', 'Off')
                            ], ['class' => 'form-control', 'prompt' => \Yii::t('shop', 'All')])
                    ,
                    'label' => Yii::t('shop', 'Show'),
                    'contentOptions' => ['class' => 'text-center col-md-1'],

                    'value' => function ($model) {
                        return Html::a(
                            Html::tag('i', '', ['class' => $model->show ? 'glyphicon glyphicon-ok text-primary' : 'glyphicon glyphicon-minus text-danger']),
                            Url::to([
                                'switch-show',
                                'id' => $model->id
                            ]),
                            [
                                'class' => 'category-nav pjax'
                            ]);
                    }
                ],

                /*ACTIONS*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-2'],
                    'attribute' => \Yii::t('shop', 'Manage'),

                    'value' => function ($model) {
                        return ManageButtons::widget(['model' => $model]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'col-md-2 text-center'],
                ],
            ],
        ]);
        ?>

        <?php Pjax::end(); ?>

        <div class="row">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-user-plus']) .
                Yii::t('shop', 'Create category'), ['save', 'languageId' => Language::getCurrent()->id], ['class' => 'btn btn-primary btn-xs pull-right']);
            ?>
        </div>

    </div>

</div>