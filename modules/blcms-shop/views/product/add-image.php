<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $product Product
 * @var $image_form ProductImageForm
 * @var $selectedLanguage \bl\multilang\entities\Language
 */

use bl\cms\shop\backend\components\form\ProductImageForm;
use bl\cms\shop\common\entities\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<?php Pjax::begin();?>

<?php $addImageForm = ActiveForm::begin([
    'action' => [
        'product/add-image',
        'productId' => $product->id,
        'languageId' => $selectedLanguage->id
    ],
    'method' => 'post',
    'options' => [
        'class' => 'tab-content',
        'data-pjax' => true
    ]
]);
?>

<h2><?= \Yii::t('shop', 'Images'); ?></h2>

<table class="table table-bordered">
    <tbody>
    <tr>
        <td class="col-md-2">
            <strong>
                <?= \Yii::t('shop', 'Add from web'); ?>
            </strong>
        </td>
        <td class="col-md-4">
            <?= $addImageForm->field($image_form, 'link')->textInput([
                'placeholder' => Yii::t('shop', 'Image link')
            ])->label(false); ?>
        </td>
        <td class="col-md-4">
            <?= $addImageForm->field($image_form, 'alt1')->textInput(['placeholder' => \Yii::t('shop', 'Alternative text')])->label(false); ?>
        </td>
        <td class="col-md-2 text-center">
            <?= Html::submitButton(\Yii::t('shop', 'Add'), ['class' => 'btn btn-primary']) ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <tbody>
    <tr>
        <td class="col-md-2 text-center">
            <strong>
                <?= \Yii::t('shop', 'Upload'); ?>
            </strong>
        </td>
        <td class="col-md-4">
            <?= $addImageForm->field($image_form, 'image')->fileInput()->label(false); ?>
        </td>
        <td class="text-center col-md-4">
            <?= $addImageForm->field($image_form, 'alt2')->textInput(['placeholder' => \Yii::t('shop', 'Alternative text')])->label(false); ?>
        </td>
        <td class="text-center col-md-2">
            <?= Html::submitButton(\Yii::t('shop', 'Add'), ['class' => 'btn btn-primary']) ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <thead class="thead-inverse">
    <?php if (!empty($product->images)) : ?>
    <tr>
        <th class="text-center col-md-2">
            <?= \Yii::t('shop', 'Image preview'); ?>
        </th>
        <th class="text-center col-md-4">
            <?= \Yii::t('shop', 'Image URL'); ?>
        </th>
        <th class="text-center col-md-4">
            <?= \Yii::t('shop', 'Alt'); ?>
        </th>
        <th class="text-center col-md-2">
            <?= \Yii::t('shop', 'Manage'); ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($product->images as $image) : ?>
        <tr>
            <td class="text-center col-md-2">
                <img data-toggle="modal" data-target="#menuItemModal-<?= $image->id ?>"
                     src="<?= $image->small; ?>"
                     class="thumb">
                <!-- Modal -->
                <div id="menuItemModal-<?= $image->id ?>" class="modal fade" role="dialog">
                    <img style="display: block" class="modal-dialog"
                         src="<?= $image->thumb; ?>">
                </div>
            </td>
            <td class="text-center col-md-4">
                <input type="text" class="form-control"
                       value="<?= str_replace(Yii::$app->homeUrl, '', Url::home(true)) .
                       $image->big; ?>">
            </td>
            <td class="text-center col-md-4">
                <?= $image->alt; ?>
            </td>
            <td class="text-center col-md-2">
                <a href="<?= Url::toRoute(['delete-image', 'id' => $image->id, 'languageId' => $selectedLanguage->id]); ?>"
                   class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm pjax"></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<?php $addImageForm->end(); ?>
<?php Pjax::end();?>

