<?php
/**
 * @author Albert Gainutdinov <xalbert.einsteinx@gmail.com>
 * @var $this yii\web\View
 * @var $languages Language[]
 */

use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Static pages';
?>
<div class="ibox">
    <div class="ibox-title">
        <h5>
            <i class="glyphicon glyphicon-list"></i>
            <?= \Yii::t('static', 'Static pages list'); ?>
        </h5>
        <div class="ibox-tools">
            <a href="<?= Url::to(['/seo/static/save-page']); ?>"
               class="btn btn-primary btn-xs">
                <i class="fa fa-user-plus"></i> <?= \Yii::t('static', 'Add'); ?>
            </a>
        </div>
    </div>

    <div class="ibox-content">
        <table class="table table-hover">
            <?php if (!empty($pages)): ?>
                <thead>
                <tr>
                    <th class="col-md-9"><?= 'Page key' ?></th>
                    <th class="col-md-3 text-center">Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td>
                            <?= $page->key; ?>
                        </td>
                        <td>
                            <?php if (count($languages) > 1): ?>
                                <div class="btn-group">

                                    <button type="button" class="btn btn-w-m btn-default">
                                        <a class="block" href="<?=Url::toRoute(['save-page',
                                            'page_key' => $page->key,
                                            'languageId' => Language::getCurrent()->id]);?>">
                                        <?=Yii::t('static', 'Edit')?>
                                    </a>
                                    </button>
                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"> <span
                                            class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <?php $translations = ArrayHelper::index($page->translations, 'language_id') ?>
                                        <?php foreach ($languages as $language): ?>
                                            <li>
                                                <a href="<?= Url::to([
                                                    'save-page',
                                                    'page_key' => $page->key,
                                                    'languageId' => $language->id
                                                ]) ?>"
                                                   type="button"
                                                   class="btn btn-<?= !empty($translations[$language->id]) ? 'primary' : 'danger'
                                                   ?> btn-xs"><?= $language->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <a href="<?= Url::to([
                                'remove',
                                'key' => $page->key
                            ]) ?>" class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            <?php endif; ?>
        </table>
    </div>
</div>