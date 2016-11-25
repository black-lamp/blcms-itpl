<?php

use bl\imagable\helpers\FileHelper;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model bl\cms\payment\common\entities\PaymentMethod */

$this->title = Yii::t('payment', 'Payment Methods');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ibox">
    <div class="ibox-title">
        <?= Html::a(Yii::t('payment', 'Add payment method'),
            Url::toRoute(['save', 'languageId' => Language::getCurrent()->id]),
            ['class' => 'btn btn-primary btn-xs pull-right']) ?>
        <h5>
            <i class="glyphicon glyphicon-list">
            </i>
            <?= Html::encode($this->title); ?>
        </h5>
    </div>

    <div class="ibox-content">
        <table class="table table-hover table-striped table-bordered">
            <tr>
                <th class="col-md-3">
                    <?= Yii::t('payment', 'Title'); ?>
                </th>
                <th class="col-md-5">
                    <?= Yii::t('payment', 'Description'); ?>
                </th>
                <th class="col-md-2">
                    <?= Yii::t('payment', 'Logo'); ?>
                </th>
                <th class="col-md-2 text-center">
                    <?= Yii::t('payment', 'Manage'); ?>
                </th>
            </tr>
            <?php foreach ($model as $paymentMethod) : ?>
                <tr>
                    <td class="project-title">
                        <?= Html::a($paymentMethod->translation->title,
                            Url::to(['save', 'id' => $paymentMethod->id, 'languageId' => Language::getCurrent()->id])); ?>
                    </td>
                    <td>
                        <?= substr($paymentMethod->translation->description, 0, 200);?>
                    </td>
                    <td>
                        <?php if (!empty($paymentMethod->image)) : ?>
                            <?= Html::a(Html::img(
                                '/images/payment/' . FileHelper::getFullName(\Yii::$app->shop_imagable->get('payment', 'small', $paymentMethod->image)),
                                ['class' => '']),
                                Url::to(['save', 'id' => $paymentMethod->id, 'languageId' => Language::getCurrent()->id]));
                            ?>
                        <?php endif ;?>
                    </td>
                    <td>
                        <?= \bl\cms\shop\widgets\ManageButtons::widget(['model' => $paymentMethod]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>