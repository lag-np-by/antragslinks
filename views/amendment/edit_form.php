<?php

use app\components\UrlHelper;
use app\models\policies\IPolicy;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $mode
 * @var \app\models\forms\AmendmentEditForm $form
 * @var \app\models\db\Consultation $consultation
 */

/** @var \app\controllers\Base $controller */
$controller = $this->context;
$layout     = $controller->layoutParams;

$multipleParagraphs = $form->motion->motionType->amendmentMultipleParagraphs;

if ($form->motion->titlePrefix != '') {
    if ($consultation->getSettings()->hideTitlePrefix) {
        $title = Yii::t(
            'amend',
            $mode == 'create' ? 'amendment_create' : 'amendment_edit'
        );
    } else {
        $title = Yii::t(
            'amend',
            $mode == 'create' ? 'amendment_create_x' : 'amendment_edit_x'
        );
    }
    $this->title = str_replace('%prefix%', $form->motion->titlePrefix, $title);
} else {
    $this->title = Yii::t('amend', $mode == 'create' ? 'amendment_create' : 'amendment_edit');
}

$layout->robotsNoindex = true;
$layout->loadCKEditor();
$layout->addBreadcrumb($form->motion->motionType->titleSingular, UrlHelper::createMotionUrl($form->motion));
$layout->addBreadcrumb(Yii::t('amend', $mode == 'create' ? 'amendment_create' : 'amendment_edit'));

echo '<h1>' . Html::encode($this->title) . '</h1>';

echo '<div class="form content">';

echo '<br><div class="alert alert-info" role="alert">';
echo \Yii::t('amend', 'create_explanation');
echo '</div><br style="clear: both;">';


echo $controller->showErrors();

$motionPolicy = $form->motion->motionType->getMotionPolicy();
if (!in_array($motionPolicy::getPolicyID(), [IPolicy::POLICY_ALL, IPolicy::POLICY_LOGGED_IN])) {
    echo '<div>
                <legend>' . Yii::t('amend', 'amendment_requirement'), '</legend>
            </div>';

    echo $motionPolicy->getOnCreateDescription();
}

if (\Yii::$app->user->isGuest) {
    echo '<div class="alert alert-warning jsProtectionHint" role="alert">';
    echo \Yii::t('base', 'err_js_or_login');
    echo '</div>';
}

echo '<div id="draftHint" class="hidden alert alert-info" role="alert"
    data-motion-id="' . $form->motion->id . '" data-amendment-id="' . $form->amendmentId . '">' .
    \Yii::t('amend', 'unsaved_drafts') . '<ul></ul>
</div>

</div>';


echo Html::beginForm(
    '',
    'post',
    ['id' => 'amendmentEditForm', 'class' => 'motionEditForm draftForm', 'enctype' => 'multipart/form-data']
);

echo '<h2 class="green">' . \Yii::t('amend', 'merge_new_text') . '</h2>
<div class="content">

<section class="editorialChange">
    <a href="#" class="opener">' . \Yii::t('amend', 'editorial_hint') . '</a>
    <div class="form-group wysiwyg-textarea hidden" id="section_holder_editorial" data-full-html="0" data-max-len="0">
        <label for="sections_editorial">' . \Yii::t('amend', 'editorial_hint') . '</label>
        <textarea name="amendmentEditorial" id="amendmentEditorial" class="raw">' .
    Html::encode($form->editorial) . '</textarea>
        <div class="texteditor boxed" id="amendmentEditorial_wysiwyg">';
echo $form->editorial;
echo '</div>
</section>
';


foreach ($form->sections as $section) {
    echo $section->getSectionType()->getAmendmentFormField();
}

echo '</div>';


echo '<h2 class="green">' . \Yii::t('amend', 'reason') . '</h2>';

echo '<div class="content">';


echo '<div class="form-group wysiwyg-textarea" data-maxLen="0" data-fullHtml="0" id="amendmentReasonHolder">';
echo '<label for="amendmentReason">' . Yii::t('amend', 'reason') . '</label>';

echo '<textarea name="amendmentReason"  id="amendmentReason" class="raw">';
echo Html::encode($form->reason) . '</textarea>';
echo '<div class="texteditor boxed" id="amendmentReason_wysiwyg">';
echo $form->reason;
echo '</div>';
echo '</div>';

echo '</div>';


$initiatorClass = $form->motion->motionType->getAmendmentInitiatorFormClass();
echo $initiatorClass->getAmendmentForm($form->motion->motionType, $form, $controller);


if (!$multipleParagraphs) {
    echo '<input type="hidden" name="modifiedSectionId" value="">';
    echo '<input type="hidden" name="modifiedParagraphNo" value="">';
}

echo '<div class="submitHolder content"><button type="submit" name="save" class="btn btn-primary">';
echo '<span class="glyphicon glyphicon-chevron-right"></span> ' . \Yii::t('amend', 'go_on');
echo '</button></div>';

$layout->addOnLoadJS('jQuery.Antragsgruen.amendmentEditForm(' . ($multipleParagraphs ? 1 : 0) . ');');

echo Html::endForm();
