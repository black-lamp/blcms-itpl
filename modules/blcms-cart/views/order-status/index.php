<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $this yii\web\View
 * @var $searchModel bl\cms\cart\models\SearchOrderStatus
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use bl\cms\shop\widgets\ManageButtons;
use bl\multilang\entities\Language;

$this->title = Yii::t('cart', 'Order Statuses');
?>

<div class="ibox">
    <div class="ibox-title">
        <div class="ibox-tools">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-user-plus']) .
                Yii::t('cart', 'Create status'), ['save', 'languageId' => Language::getCurrent()->id], ['class' => 'btn btn-primary btn-xs pull-right']);
            ?>

            <h5>
                <i class="glyphicon glyphicon-list">
                </i>
                <?= Html::encode($this->title); ?>
            </h5>
        </div>
    </div>

    <div class="ibox-content">

        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

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
                    'label' => Yii::t('cart', 'Title') . '*',
                    'format' => 'html',
                    'contentOptions' => ['class' => 'text-center project-title'],
                ],

                /*DESCRIPTION*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-7'],
                    'attribute' => 'title',
                    'value' => function ($model) {
                        $content = null;
                        if (!empty($model->translation->description)) {
                            $content = substr($model->translation->description, 0, 250);
                        }
                        return $content;
                    },
                    'label' => Yii::t('cart', 'Description'),
                    'format' => 'html',
                    'contentOptions' => ['class' => 'text-center project-title'],
                ],

                /*ACTIONS*/
                [
                    'headerOptions' => ['class' => 'text-center col-md-2'],
                    'attribute' => \Yii::t('cart', 'Manage'),

                    'value' => function ($model) {
                        return ManageButtons::widget(['model' => $model]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center text-center'],
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
        <div class="row">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-user-plus']) .
                Yii::t('cart', 'Create status'), ['save', 'languageId' => Language::getCurrent()->id], ['class' => 'btn btn-primary btn-xs m-r-xs pull-right']);
            ?>
            <p>
                <em>
                    <?= '*' . Yii::t('cart', 'Status title should be specified in the Past Simple tense'); ?>
                </em>
            </p>
        </div>
    </div>
</div>

