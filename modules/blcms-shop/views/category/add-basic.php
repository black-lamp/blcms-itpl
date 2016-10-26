<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 */
use bl\cms\shop\common\entities\CategoryTranslation;
use marqu3s\summernote\Summernote;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $addForm = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>

<?= Html::submitInput(\Yii::t('shop', 'Save'), ['class' => 'btn btn-xs btn-primary m-r-xs pull-right']); ?>

    <div id="basic">
        <h2><?= \Yii::t('shop', 'Basic options'); ?></h2>

        <!-- NAME -->
        <?= $addForm->field($category_translation, 'title', [
            'inputOptions' => [
                'class' => 'form-control'
            ]
        ])->label(\Yii::t('shop', 'Name'))
        ?>

        <!-- SHOW -->
        <?= $addForm->field($category, 'show', [
            'inputOptions' => [
                'class' => 'form-control'
            ]
        ])->checkbox(['class' => 'i-checks', 'checked ' => ($category->show) ? '' : false])
        ?>

        <!-- PARENT CATEGORY -->
        <b><?= \Yii::t('shop', 'Parent category'); ?></b>
        <?= '<ul class="list-group ul-treefree ul-dropfree">'; ?>
        <?= '<li class="list-group-item"><input type="radio" checked name="Category[parent_id]" value="" id="null"><label for="null">' . \Yii::t("shop", "Without parent") . '</label>'; ?>
        <?= CategoryTranslation::treeRecoursion($categoriesTree, $category->parent_id, 'Category[parent_id]', $category_translation->category_id); ?>
        <?= '</ul>'; ?>

        <!-- DESCRIPTION -->
        <?= $addForm->field($category_translation, 'description', [
            'inputOptions' => [
                'class' => 'form-control'
            ]
        ])->widget(Summernote::className())->label(\Yii::t('shop', 'Description'))
        ?>

        <!-- SORT ORDER -->
        <?= $addForm->field($category, 'position', [
            'inputOptions' => [
                'class' => 'form-control'
            ]])->textInput([
            'type' => 'number',
            'max' => $maxPosition,
            'min' => $minPosition
        ]); ?>

        <div class="ibox">
            <!--CLOSE BUTTON-->
            <a href="<?= Url::to(['/shop/category']); ?>">
                <?= Html::button(\Yii::t('shop', 'Close'), [
                    'class' => 'btn btn-danger btn-xs pull-right'
                ]); ?>
            </a>
            <?= Html::submitInput(\Yii::t('shop', 'Save'), ['class' => 'btn btn-xs btn-primary m-r-xs pull-right']); ?>
        </div>
    </div>


<?php $addForm::end(); ?>