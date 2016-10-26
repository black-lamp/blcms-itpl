<?php
use bl\cms\shop\backend\assets\EditProductAsset;
use bl\cms\shop\backend\components\form\ProductImageForm;
use bl\cms\shop\backend\components\form\ProductVideoForm;
use bl\cms\shop\common\entities\CategoryTranslation;
use bl\cms\shop\common\entities\Param;
use bl\cms\shop\common\entities\ParamTranslation;
use bl\cms\shop\common\entities\Product;
use bl\cms\shop\common\entities\ProductPrice;
use bl\cms\shop\common\entities\ProductPriceTranslation;
use bl\cms\shop\common\entities\ProductTranslation;
use bl\cms\shop\common\entities\ProductCountryTranslation;
use bl\cms\shop\common\entities\ProductVideo;
use bl\cms\shop\common\entities\Vendor;
use bl\multilang\entities\Language;
use marqu3s\summernote\Summernote;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $languages Language[]
 * @var $selectedLanguage Language
 * @var $product Product
 * @var $products_translation ProductTranslation
 * @var $params_translation ParamTranslation
 * @var $categories CategoryTranslation[]
 */

EditProductAsset::register($this);

$this->title = \Yii::t('shop', 'Edit product');
$newProductMessage = Yii::t('shop', 'You must save new product before this action');
?>

<!--BODY PANEL-->
<div class="tabs-container">

    <ul class="nav nav-tabs">
        <li class="<?= Yii::$app->controller->action->id == 'add-basic' || Yii::$app->controller->action->id == 'save' ? 'tab active' : 'tab'; ?>">
            <?= Html::a(\Yii::t('shop', 'Basic'), Url::to(['add-basic', 'productId' => $product->id, 'languageId' => $selectedLanguage->id]),
                [
                    'aria-expanded' => 'true'
                ]); ?>
        </li>

        <li class="<?= Yii::$app->controller->action->id == 'add-image' ? 'active' : ''; ?>">
            <?=
            ($product->isNewRecord) ?
                '<a>' . \Yii::t('shop', 'Photo') . '</a>' :
                Html::a(\Yii::t('shop', 'Photo'), Url::to(['add-image', 'productId' => $product->id, 'languageId' => $selectedLanguage->id]),
                    [
                        'aria-expanded' => 'true'
                    ]); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'add-video' ? 'tab active' : 'tab'; ?>">
            <?=
            ($product->isNewRecord) ?
                '<a>' . \Yii::t('shop', 'Video') . '</a>' :

                Html::a(\Yii::t('shop', 'Video'), Url::to(['add-video', 'productId' => $product->id, 'languageId' => $selectedLanguage->id]),
                    [
                        'aria-expanded' => 'true'
                    ]); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'add-price' ? 'tab active' : 'tab'; ?>">
            <?=
            ($product->isNewRecord) ?
                '<a>' . \Yii::t('shop', 'Prices') . '</a>' :
                Html::a(\Yii::t('shop', 'Prices'), Url::to(['add-price', 'productId' => $product->id, 'languageId' => $selectedLanguage->id]),
                    [
                        'aria-expanded' => 'true'
                    ]); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'add-param' ? 'tab active' : 'tab'; ?>">
            <?=
            ($product->isNewRecord) ?
                '<a>' . \Yii::t('shop', 'Params') . '</a>' :
                Html::a(\Yii::t('shop', 'Params'), Url::to(['add-param', 'productId' => $product->id, 'languageId' => $selectedLanguage->id]),
                    [
                        'aria-expanded' => 'true'
                    ]); ?>
        </li>
    </ul>

    <!--MODERATION-->
    <?php if (Yii::$app->user->can('moderateProductCreation') && $product->status == Product::STATUS_ON_MODERATION) : ?>
        <h2><?= \Yii::t('shop', 'Moderation'); ?></h2>
        <p><?= \Yii::t('shop', 'This product status is "on moderation". You may accept or decline it.'); ?></p>
        <?= Html::a(\Yii::t('shop', 'Accept'), Url::toRoute(['change-product-status', 'id' => $product->id, 'status' => Product::STATUS_SUCCESS]), ['class' => 'btn btn-primary btn-xs']); ?>
        <?= Html::a(\Yii::t('shop', 'Decline'), Url::toRoute(['change-product-status', 'id' => $product->id, 'status' => Product::STATUS_DECLINED]), ['class' => 'btn btn-danger btn-xs']); ?>
    <?php endif; ?>

    <div class="ibox-content">
        <!--CLOSE BUTTON-->
        <a href="<?= Url::to(['/shop/product']); ?>">
            <?= Html::button(\Yii::t('shop', 'Close'), [
                'class' => 'btn btn-xs btn-danger pull-right'
            ]); ?>
        </a>
        <!-- LANGUAGES -->
        <?php if (count($languages) > 1): ?>
            <div class="dropdown pull-right">
                <button class="btn btn-warning btn-xs dropdown-toggle m-r-xs" type="button"
                        id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true">
                    <?= $selectedLanguage->name ?>
                    <span class="caret"></span>
                </button>
                <?php if (count($languages) > 1): ?>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <?php foreach ($languages as $language): ?>
                            <li>
                                <a href="<?= Url::to([
                                    'save',
                                    'id' => $product->id,
                                    'languageId' => $language->id]) ?>
                                                ">
                                    <?= $language->name ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!--CONTENT-->
        <?= $this->render($viewName, $params); ?>
    </div>

</div>