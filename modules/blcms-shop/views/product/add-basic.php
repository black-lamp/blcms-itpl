<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $product \bl\cms\shop\common\entities\Product
 * @var $products_translation \bl\cms\shop\common\entities\Product
 * @var $selectedLanguage \bl\multilang\entities\Language
 */
use bl\cms\shop\common\entities\CategoryTranslation;
use bl\cms\shop\common\entities\ProductAvailability;
use bl\cms\shop\common\entities\ProductCountryTranslation;
use bl\cms\shop\common\entities\Vendor;
use marqu3s\summernote\Summernote;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => [
        'product/add-basic',
        'productId' => $product->id,
        'languageId' => $selectedLanguage->id
    ]]);
?>

<!--BASIC-->
<div id="basic">

    <h2><?= \Yii::t('shop', 'Basic options'); ?></h2>
    <!--NAME-->
    <?= $form->field($products_translation, 'title', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->label(\Yii::t('shop', 'Name'))
    ?>
    <!--ARTICULUS-->
    <?= $form->field($product, 'articulus', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->label(\Yii::t('shop', 'Articulus'))
    ?>
    <!--CATEGORY-->
    <b><?= \Yii::t('shop', 'Category'); ?></b>
    <?= '<ul class="list-group ul-treefree ul-dropfree">'; ?>
    <?= '<li class="list-group-item"><input type="radio" checked name="Product[category_id]" value="" id="null"><label for="null">' . \Yii::t("shop", "Without parent") . '</label>'; ?>
    <?= CategoryTranslation::treeRecoursion($categoriesTree, $product->category_id, 'Product[category_id]'); ?>
    <?= '</ul>'; ?>

    <!--STANDART PRICE-->
    <?= $form->field($product, 'price', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->textInput(['type' => 'number', 'step' => '0.01'])->label(\Yii::t('shop', 'Price'))
    ?>
    <!--COUNTRY-->
    <?= $form->field($product, 'country_id', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->dropDownList(
        ['' => '-- no countries --'] +
        ArrayHelper::map(ProductCountryTranslation::find()->where(['language_id' => $selectedLanguage->id])->all(), 'country_id', 'title')
    )->label(\Yii::t('shop', 'Country'));
    ?>
    <!--VENDOR-->
    <?= $form->field($product, 'vendor_id', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->dropDownList(
        ['' => '-- no vendor --'] +
        ArrayHelper::map(Vendor::find()->all(), 'id', 'title')
    )->label(\Yii::t('shop', 'Vendor'))
    ?>
    <!--AVAILABILITY-->
    <?= $form->field($product, 'availability', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->dropDownList(
        ArrayHelper::map(ProductAvailability::find()->all(), 'id', 'translation.title')
    )->label(\Yii::t('shop', 'Availability'))
    ?>
    <!--SHORT DESCRIPTION-->
    <?= $form->field($products_translation, 'description', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->widget(Summernote::className())->label(\Yii::t('shop', 'Short description'));
    ?>

    <!-- FULL TEXT -->
    <?= $form->field($products_translation, 'full_text', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->widget(Summernote::className())->label(\Yii::t('shop', 'Full description'));
    ?>

    <!-- SEO -->
    <h2><?= \Yii::t('shop', 'SEO options'); ?></h2>
    <div class="seo-url">
        <?= $form->field($products_translation, 'seoUrl', [
            'inputOptions' => [
                'class' => 'form-control'
            ]
        ])->label('SEO URL')
        ?>
        <?= Html::button(\Yii::t('shop', 'Generate'), ['class' => 'btn btn-primary btn-generate', 'id' => 'generate-seo-url']); ?>
    </div>

    <?= $form->field($products_translation, 'seoTitle', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->label(\Yii::t('shop', 'SEO title'))
    ?>
    <?= $form->field($products_translation, 'seoDescription', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->textarea(['rows' => 3])->label(\Yii::t('shop', 'SEO description'))
    ?>
    <?= $form->field($products_translation, 'seoKeywords', [
        'inputOptions' => [
            'class' => 'form-control'
        ]
    ])->textarea(['rows' => 3])->label(\Yii::t('shop', 'SEO keywords'))
    ?>

    <div class="ibox">
        <a href="<?= Url::to(['/shop/product']); ?>">
            <?= Html::button(\Yii::t('shop', 'Close'), [
                'class' => 'btn btn-xs btn-danger pull-right'
            ]); ?>
        </a>
        <input type="submit" class="btn btn-xs btn-primary m-r-xs pull-right" value="<?= \Yii::t('shop', 'Save'); ?>">
    </div>
</div>

<?php $form::end(); ?>
