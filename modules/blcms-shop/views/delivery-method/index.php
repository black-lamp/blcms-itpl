<?php
use bl\cms\shop\widgets\ManageButtons;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;


/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 *
 * @var $this yii\web\View
 * @var $deliveryMethods bl\cms\cart\models\DeliveryMethod
 */

$this->title = Yii::t('shop', 'Delivery methods');
?>

<div class="ibox">

    <div class="ibox-title">
        <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-user-plus']) .
            Yii::t('shop', 'Create delivery method'), ['save', 'languageId' => Language::getCurrent()->id], ['class' => 'btn btn-primary btn-xs pull-right']);
        ?>
        <h5>
            <i class="glyphicon glyphicon-list">
            </i>
            <?= Html::encode($this->title); ?>
        </h5>
    </div>

    <div class="ibox-content">

        <table id="my-grid" class="table table-hover">
            <tr>
                <th class="col-md-2 text-center"><?= Yii::t('shop', 'ID'); ?></th>
                <th class="col-md-5 text-center"><?= Yii::t('shop', 'Title'); ?></th>
                <th class="col-md-3 text-center"><?= Yii::t('shop', 'Logo'); ?></th>
                <th class="col-md-2 text-center"><?= Yii::t('shop', 'Manage'); ?></th>
            </tr>
            <?php foreach ($deliveryMethods as $deliveryMethod) : ?>
                <tr>
                    <td class="text-center">
                        <?= $deliveryMethod->id; ?>
                    </td>
                    <td class="project-title">
                        <?php if (!empty($deliveryMethod->translation->title)) : ?>
                            <?= Html::a($deliveryMethod->translation->title, Url::to([
                                'save',
                                'id' => $deliveryMethod->id,
                                'languageId' => Language::getCurrent()->id])); ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if (!empty($deliveryMethod->image_name)) : ?>
                            <?= Html::img($deliveryMethod->smallLogo); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= ManageButtons::widget(['model' => $deliveryMethod]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
