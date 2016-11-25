<?php
use bl\cms\cart\models\DeliveryMethod;
use bl\imagable\helpers\FileHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $this yii\web\View
 * @var $model bl\cms\cart\models\Order
 * @var $orderProducts bl\cms\cart\models\OrderProduct
 * @var $statuses [] bl\cms\cart\models\OrderStatus
 */

$this->title = Yii::t('cart', 'Order details');
?>
<div class="ibox">

    <div class="ibox-title">
        <h1><?= \Yii::t('cart', 'Order #') . $model->id; ?></h1>
    </div>

    <?php if (Yii::$app->user->can('changeOrderStatus')) : ?>
    <div class="ibox-content">
        <!--CHANGE STATUS-->
        <h2>
            <?= Yii::t('cart', 'Order status'); ?>
        </h2>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map($statuses, 'id', function ($model) {
            return $model->translation->title;
        }), ['options' => [$model->status => ['selected' => true]]]); ?>
        <?= Html::submitButton(Yii::t('cart', 'Change status'), ['class' => 'btn btn-xs btn-primary']); ?>
        <?= Html::a(Yii::t('cart', 'Close'), Url::toRoute('/cart/order'), ['class' => 'btn btn-xs btn-danger']) ?>
        <?php $form::end(); ?>
    </div>
    <?php endif; ?>

    <div class="ibox-content">
        <div class="row">
            <div class="col-md-6">
                <!--CUSTOMER DATA-->
                <h2>
                    <?= Yii::t('cart', 'Customer data'); ?>
                </h2>

                <p><b><?= \Yii::t('cart', 'Customer name'); ?>:</b> <?= $model->user->profile->name ?? ''; ?></p>
                <p><b><?= \Yii::t('cart', 'Surname'); ?>:</b> <?= $model->user->profile->surname ?? ''; ?></p>
                <p><b><?= \Yii::t('cart', 'Patronymic'); ?>:</b> <?= $model->user->profile->patronymic ?? ''; ?></p>
                <p><b><?= \Yii::t('cart', 'Phone number'); ?>:</b> <?= $model->user->profile->phone ?? ''; ?></p>

                <!--PAYMENT METHOD-->
                <?php if (Yii::$app->cart->enablePayment === true) : ?>
                    <h2>
                        <?= Yii::t('cart', 'Payment method'); ?>
                    </h2>
                    <div class="col-md-2">
                        <?php if (!empty($model->paymentMethod->image)) : ?>
                            <?= Html::img(
                                '/images/payment/' . FileHelper::getFullName(\Yii::$app->shop_imagable->get('payment', 'small', $model->paymentMethod->image)),
                                ['class' => '', 'style' => 'width: 100%;']); ?>
                        <?php endif ;?>
                    </div>
                    <p class="col-md-10">
                        <?= (!empty($model->paymentMethod)) ? $model->paymentMethod->translation->title : ''; ?>
                    </p>
                <?php endif; ?>
            </div>

            <!--DELIVERY METHOD-->
            <div class="col-md-6">
                <div class="col-md-4">
                    <?= Html::img($model->deliveryMethod->smallLogo); ?>
                </div>
                <div class="col-md-8">
                    <h2>
                        <?= Yii::t('cart', 'Delivery method'); ?>
                    </h2>
                    <?php if (!empty($model->deliveryMethod->translation->title)) : ?>
                    <p>
                        <?= Html::tag('b', $model->deliveryMethod->translation->title);?>
                    </p>
                    <?php endif; ?>

                    <?php if ($model->deliveryMethod->show_address_or_post_office == DeliveryMethod::SHOW_POST_OFFICE_FIELD) : ?>
                        <?php if (!empty($model->delivery_post_office)) : ?>
                            <p><?= Yii::t('cart', 'Post office') . ': #' . $model->delivery_post_office; ?></p>
                        <?php endif; ?>
                    <?php elseif($model->deliveryMethod->show_address_or_post_office == DeliveryMethod::SHOW_ADDRESS_FIELDS) : ?>
                        <!--Address-->
                        <p><b><?= Yii::t('cart', 'Country'); ?>:</b> <?= (!empty($model->address->country)) ? $model->address->country : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'Region'); ?>:</b> <?= (!empty($model->address->region)) ? $model->address->region : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'City'); ?>:</b> <?= (!empty($model->address->city) )? $model->address->city : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'Street'); ?>:</b> <?= (!empty($model->address->street)) ? $model->address->street : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'House'); ?>:</b> <?= (!empty($model->address->house)) ? $model->address->house : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'Apartment'); ?>:</b> <?= (!empty($model->address->apartment)) ? $model->address->apartment : ''; ?></p>
                        <p><b><?= Yii::t('cart', 'Zip'); ?>:</b> <?= (!empty($model->address->zipcode)) ? $model->address->zipcode : ''; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!--PRODUCT LIST-->
    <div class="ibox-content col-md-12">
        <h2>
            <?= Yii::t('cart', 'Product list'); ?>
        </h2>

        <table class="table table-hover table-striped table-bordered">
            <tr>
                <th>#</th>
                <th>
                    <?= Yii::t('cart', 'Articulus'); ?>
                </th>
                <th>
                    <?= Yii::t('cart', 'Product title'); ?>
                </th>
                <th>
                    <?= Yii::t('cart', 'Count'); ?>
                </th>
                <th>
                    <?= Yii::t('cart', 'Price'); ?>
                </th>
                <th>
                    <?= Yii::t('cart', 'Delete'); ?>
                </th>
            </tr>

            <?php $i = 0;
            foreach ($orderProducts as $orderProduct) : ?>
                <tr>
                    <td><?= ++$i; ?></td>
                    <td>
                        <?= $orderProduct->product->articulus ?? ''; ?>
                    </td>
                    <td>
                        <?= $orderProduct->product->translation->title ?? ''; ?>
                        <?= (!empty($orderProduct->priceTitle)) ?
                            Html::tag('i', '(' . $orderProduct->priceTitle . ')') : ''; ?>
                    </td>
                    <td>
                        <?= $orderProduct->count; ?>
                    </td>
                    <td>
                        <?= $orderProduct->price ?? ''; ?>
                    </td>
                    <td>
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::toRoute(['delete-product', 'id' => $model->id]),
                            ['title' => Yii::t('yii', 'Delete'), 'class' => 'btn btn-danger pull-right pjax']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>