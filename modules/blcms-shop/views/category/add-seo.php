<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $addForm = ActiveForm::begin(['method' => 'post']) ?>
<?= Html::submitInput(\Yii::t('shop', 'Save'), ['class' => 'btn btn-xs btn-primary m-r-xs pull-right']); ?>

    <h2><?= \Yii::t('shop', 'SEO options'); ?></h2>
<?= $addForm->field($category_translation, 'seoUrl', [
    'inputOptions' => [
        'class' => 'form-control'
    ]
])->label('SEO URL')
?>
<?= $addForm->field($category_translation, 'seoTitle', [
    'inputOptions' => [
        'class' => 'form-control'
    ]
])->label(\Yii::t('shop', 'SEO title'))
?>
<?= $addForm->field($category_translation, 'seoDescription')->textarea(['rows' => 3])->label(\Yii::t('shop', 'SEO description'));
?>
<?= $addForm->field($category_translation, 'seoKeywords')->textarea(['rows' => 3])->label(\Yii::t('shop', 'SEO keywords'))
?>


    <div class="ibox">
        <!--CLOSE BUTTON-->
        <a href="<?= Url::to(['/shop/category']); ?>">
            <?= Html::button(\Yii::t('shop', 'Close'), [
                'class' => 'btn btn-danger btn-xs pull-right'
            ]); ?>
        </a>
        <?= Html::submitInput(\Yii::t('shop', 'Save'), ['class' => 'btn btn-xs btn-primary m-r-xs pull-right']); ?>
    </div>

<?php $addForm::end(); ?>