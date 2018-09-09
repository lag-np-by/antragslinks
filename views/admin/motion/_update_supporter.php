<?php

use app\models\db\ISupporter;
use app\models\settings\InitiatorForm;
use app\models\supportTypes\SupportBase;
use yii\helpers\Html;

/**
 * @var ISupporter[] $supporters
 * @var ISupporter $newTemplate
 * @var InitiatorForm $settings
 */


/**
 * @param ISupporter $supporter
 * @return string
 */
$getSupporterRow = function (\app\models\db\ISupporter $supporter) use ($settings) {
    $str = '<li><div class="supporterRow">';
    $str .= '<input type="hidden" name="supporterId[]" value="' . Html::encode($supporter->id) . '">';

    $title = Html::encode(\Yii::t('admin', 'motion_supp_name'));
    $str   .= '<div class="nameCol">';

    $str .= '<span class="glyphicon glyphicon-resize-vertical moveHandle"></span> ';

    $str .= '<input type="text" name="supporterName[]" value="' . Html::encode($supporter->name) . '" ';
    $str .= ' class="form-control supporterName" placeholder="' . $title . '" title="' . $title . '">';
    $str .= '</div>';

    $title = Html::encode(\Yii::t('admin', 'motion_supp_orga'));
    $str   .= '<div>';
    $str   .= '<input type="text" name="supporterOrga[]" value="' . Html::encode($supporter->organization) . '" ';
    $str   .= ' class="form-control supporterOrga" placeholder="' . $title . '" title="' . $title . '">';
    $str   .= '</div>';

    if ($settings->contactGender !== InitiatorForm::CONTACT_NONE) {
        $genderChoices = array_merge(
            ['' => \Yii::t('initiator', 'gender') . ':'],
            SupportBase::getGenderSelection()
        );
        $str .= '<div class="colGender">';
        $str .= \app\components\HTMLTools::fueluxSelectbox(
            'supporterGender[]',
            $genderChoices,
            $supporter->getExtraDataEntry('gender'),
            [],
            true
        );
        $str .= '</div>';
    }

    $str .= '<div>';
    $str .= '<a href="#" class="delSupporter"><span class="glyphicon glyphicon-minus-sign"></span></a>';
    if ($supporter->user) {
        $str .= Html::encode($supporter->user->getAuthName());
    }
    $str .= '</div>';


    $str .= '</div></li>';
    return $str;
};

?>
<h2 class="green"><?= \Yii::t('admin', 'motion_edit_supporters') ?></h2>
<div class="content fuelux" id="motionSupporterHolder">
    <ul class="supporterList">
        <?php
        foreach ($supporters as $supporter) {
            echo $getSupporterRow($supporter);
        }
        ?>
    </ul>

    <div class="fullTextAdder"><a href="#"><?= Yii::t('initiator', 'fullTextField') ?></a></div>

    <a href="#" class="supporterRowAdder" data-content="<?= Html::encode($getSupporterRow($newTemplate)) ?>">
        <span class="glyphicon glyphicon-plus-sign"></span>
        <?= \Yii::t('admin', 'motion_edit_supporters_add') ?>
    </a>

    <div class="form-group hidden" id="fullTextHolder">
        <div class="col-md-9">
            <textarea class="form-control" placeholder="<?= Html::encode(Yii::t('initiator', 'fullTextSyntax')) ?>"
                      rows="10"></textarea>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-success fullTextAdd">
                <span class="glyphicon glyphicon-plus"></span>
                <?= Yii::t('initiator', 'fullTextAdd') ?>
            </button>
        </div>
    </div>
</div>
