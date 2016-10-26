<?php
use bl\articles\backend\assets\TabsAsset;
use bl\cms\shop\backend\assets\InputTreeAsset;
use bl\cms\shop\backend\components\form\CategoryImageForm;
use bl\cms\shop\common\entities\Category;
use bl\cms\shop\common\entities\CategoryTranslation;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $category Category
 * @var $category_translation CategoryTranslation
 * @var $categories Category[]
 * @var $selectedLanguage Language
 * @var $languages Language[]
 * @var $image_form CategoryImageForm
 * @var $minPosition Category
 * @var $maxPosition Category
 * @var $categoriesTree Category
 */

InputTreeAsset::register($this);
TabsAsset::register($this);

$this->title = \Yii::t('shop', 'Edit category');

if ($category->isNewRecord) {
    $this->title = \Yii::t('shop', 'Add new category');
}
else {
    $this->title = \Yii::t('shop', 'Edit category');
}
?>
<?php
Pjax::begin([
    'linkSelector' => '.image',
    'enablePushState' => true,
    'timeout' => 10000
]);
?>
<div class="tabs-container">
    <!--TABS-->
    <ul class="nav nav-tabs">
        <li class="<?= Yii::$app->controller->action->id == 'add-basic' || Yii::$app->controller->action->id == 'save' ? 'tab active' : 'tab'; ?>">
            <?= Html::a(Yii::t('shop', 'Basic'), $category->isNewRecord ? '' : Url::to(['save', 'id' => $category->id, 'languageId' => $selectedLanguage->id]), ['class' => 'image']); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'add-seo' ? 'tab active' : 'tab'; ?> <?= $category->isNewRecord ? 'disabled' : '';?>">
            <?= Html::a(Yii::t('shop', 'SEO data'), $category->isNewRecord ? '' : Url::to(['add-seo', 'categoryId' => $category->id, 'languageId' => $selectedLanguage->id]), ['class' => 'image']); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'add-images' ? 'tab active' : 'tab'; ?> <?= $category->isNewRecord ? 'disabled' : '';?>">
            <?= Html::a(Yii::t('shop', 'Images'), $category->isNewRecord ? '' : Url::to(['add-images', 'categoryId' => $category->id, 'languageId' => $selectedLanguage->id]), ['class' => 'image']); ?>
        </li>
        <li class="<?= Yii::$app->controller->action->id == 'select-filters' ? 'tab active' : 'tab'; ?> <?= $category->isNewRecord ? 'disabled' : '';?>">
            <?= Html::a(Yii::t('shop', 'Filters'), $category->isNewRecord ? '' : Url::to(['select-filters', 'categoryId' => $category->id, 'languageId' => $selectedLanguage->id]), ['class' => 'image']); ?>
        </li>
    </ul>

    <!--CONTENT-->
    <div class="ibox-content">

        <!-- LANGUAGES -->
        <?php if (count($languages) > 1): ?>
            <div class="dropdown pull-right">
                <button class="btn btn-warning btn-xs m-t-xs m-l-xs dropdown-toggle m-r-xs" type="button"
                        id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true">
                    <?= $selectedLanguage->name ?>
                    <span class="caret"></span>
                </button>
                <?php if (count($languages) > 1): ?>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <?php foreach ($languages as $language): ?>
                            <li>
                                <a href="
                                        <?= Url::to([
                                    'save',
                                    'id' => $category->id,
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

        <!--CLOSE BUTTON-->
        <a href="<?= Url::to(['/shop/category']); ?>">
            <?= Html::button(\Yii::t('shop', 'Close'), [
                'class' => 'btn m-t-xs btn-danger btn-xs pull-right'
            ]); ?>
        </a>


        <!--CONTENT-->
        <?= $this->render($viewName, $params); ?>
    </div>
</div>
<?php Pjax::end(); ?>
