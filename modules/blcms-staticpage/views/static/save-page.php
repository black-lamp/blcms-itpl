<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $languages Language[]
 * @var $selectedLanguage Language
 * @var StaticPageTranslation $static_page_translation
 */

use bl\cms\seo\common\entities\StaticPageTranslation;
use bl\multilang\entities\Language;
use marqu3s\summernote\Summernote;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if (!empty($static_page_translation->page_key)) {
    $this->title = \Yii::t('static', 'Edit static page') . ': ' . $static_page_translation->page_key;
} else {
    $this->title = \Yii::t('static', 'Addition a new static page');
}
?>


<?php $form = ActiveForm::begin(['method' => 'post']) ?>
<?= $form->errorSummary($static_page_translation); ?>

<div class="ibox">
    <div class="ibox-title">
        <h5>
            <i class="glyphicon glyphicon-list"></i>
            <?= \Yii::t('static', 'Edit static page'); ?>
        </h5>
        <div class="ibox-tools">
            <input type="submit" class="btn btn-primary btn-xs  pull-right" value="<?= Yii::t('', 'Save'); ?>">

            <?php if (count($languages) > 1): ?>
                <div class="dropdown pull-right">
                    <button class="btn btn-warning btn-xs dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= $selectedLanguage->name ?>
                        <span class="caret"></span>
                    </button>
                    <?php if (count($languages) > 1): ?>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php foreach ($languages as $language): ?>
                                <li>
                                    <a href="<?=
                                    Url::to([
                                        'save-page',
                                        'page_key' => $static_page_translation->page_key,
                                        'languageId' => $language->id]);
                                    ?>
                                        ">
                                        <?= $language->name; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="ibox-content">


        <div class="panel-body">

            <?= $form->field($static_page_translation, 'page_key', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]])
            ?>
            <?= $form->field($static_page_translation, 'title', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]])
            ?>
            <?= $form->field($static_page_translation, 'text', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]
            ])->widget(Summernote::className())->label(\Yii::t('shop', 'Short description'));
            ?>
        </div>


        <div class="panel-body">
            <h5>
                <i class="glyphicon glyphicon-list"></i>
                <?= 'Seo Data' ?>
            </h5>
            <?= $form->field($static_page_translation, 'seoUrl', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]
            ])->label('Seo Url')
            ?>

            <?= $form->field($static_page_translation, 'seoTitle', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]
            ])->label('Seo Title')
            ?>

            <?= $form->field($static_page_translation, 'seoDescription', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]
            ])->textarea(['rows' => 3])->label('Seo Description')
            ?>

            <?= $form->field($static_page_translation, 'seoKeywords', [
                'inputOptions' => [
                    'class' => 'form-control'
                ]
            ])->textarea(['rows' => 3])->label('Seo Keywords')
            ?>

            <input type="submit" class="btn btn-primary pull-right" value="<?= Yii::t('', 'Save'); ?>">
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>
