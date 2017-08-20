<?php

use app\components\diff\Diff;
use app\components\diff\DiffRenderer;
use app\components\HTMLTools;
use app\components\UrlHelper;
use app\models\db\Amendment;
use app\models\sectionTypes\ISectionType;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var Amendment $amendment
 * @var \app\models\forms\AmendmentProposedChangeForm $form
 * @var null|string $msgSuccess
 */

/** @var \app\controllers\Base $controller */
$controller = $this->context;
$layout     = $controller->layoutParams;

$this->title        = \Yii::t('amend', 'proposal_edit_title');
$layout->fullWidth  = true;
$layout->fullScreen = true;
$layout->loadCKEditor();

$motionUrl = UrlHelper::createMotionUrl($amendment->getMyMotion());
$layout->addBreadcrumb($amendment->getMyMotion()->getBreadcrumbTitle(), $motionUrl);
if (!$consultation->getSettings()->hideTitlePrefix && $amendment->titlePrefix != '') {
    $layout->addBreadcrumb($amendment->titlePrefix, UrlHelper::createAmendmentUrl($amendment));
} else {
    $layout->addBreadcrumb(\Yii::t('amend', 'amendment'), UrlHelper::createAmendmentUrl($amendment));
}
$layout->addBreadcrumb(\Yii::t('amend', 'proposal_edit_bread'));

echo '<h1>' . \Yii::t('amend', 'proposal_edit_title') . '</h1>';


echo Html::beginForm(UrlHelper::createAmendmentUrl($amendment, 'edit-proposed-change'), 'post', [
    'id'                        => 'proposedChangeTextForm',
    'data-antragsgruen-widget'  => 'backend/AmendmentEditProposedChange',
    'data-collission-check-url' => UrlHelper::createAmendmentUrl($amendment, 'edit-proposed-change-check'),
]);

if ($msgSuccess) {
    echo '<div class="content"><div class="alert alert-success">';
    echo $msgSuccess;
    echo '</div></div>';
}

$collidingAmendments = $amendment->collidesWithOtherProposedAmendments(true);

?>
    <div class="content">
        <a href="<?= UrlHelper::createAmendmentUrl($amendment) ?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= \Yii::t('amend', 'proposal_edit_back') ?>
        </a>
        <div class="row">
            <section class="col-md-6">
                <h2><?= \Yii::t('amend', 'proposal_edit_title_prop') ?></h2>
            </section>
            <section class="col-md-6">
                <h2><?= \Yii::t('amend', 'proposal_edit_title_orig') ?></h2>
            </section>
        </div>
        <?php

        foreach ($form->getProposalSections() as $section) {
            $amendSection = null;
            foreach ($amendment->getActiveSections() as $amSec) {
                if ($amSec->sectionId == $section->sectionId) {
                    $amendSection = $amSec;
                }
            }

            $type     = $section->getSettings();
            $nameBase = 'sections[' . $type->id . ']';
            $htmlId   = 'sections_' . $type->id;

            ?>
            <div class="row">
                <section class="col-md-6 motionTextHolder proposedVersion" data-section-id="<?= $type->id ?>">
                    <?= $section->getSectionType()->getAmendmentFormField() ?>
                </section>
                <section class="col-md-6 motionTextHolder originalVersion">
                    <div class="title"><?= Html::encode($amendSection->getSettings()->title) ?></div>
                    <?php
                    switch ($amendSection->getSettings()->type) {
                        case ISectionType::TYPE_TITLE:
                            echo '<div class="paragraph"><div class="text textOrig">';
                            echo Html::encode($amendSection->data);
                            echo '</div></div>';
                            break;
                        case ISectionType::TYPE_TEXT_HTML:
                            echo '<div class="paragraph"><div class="text textOrig">';
                            echo $amendSection->data;
                            echo '</div></div>';
                            break;
                        case ISectionType::TYPE_TEXT_SIMPLE:
                            $diff = new Diff();
                            echo '<div class="paragraph"><div class="text textOrig fixedWidthFont">';
                            echo implode("\n", $diff->compareHtmlParagraphs(
                                HTMLTools::sectionSimpleHTML($amendSection->getOriginalMotionSection()->data),
                                HTMLTools::sectionSimpleHTML($amendSection->data),
                                DiffRenderer::FORMATTING_ICE
                            ));
                            echo '</div></div>';
                            break;
                    }
                    ?>
                </section>
            </div>
            <?php
        }

        ?>
    </div>
    <div class="save-row">
        <button class="btn btn-primary" type="submit" name="save">
            <?= \Yii::t('base', 'save') ?>
        </button>
    </div>
    <aside id="collissionIndicator" class="<?= (count($collidingAmendments) === 0 ? 'hidden' : '') ?>">
        <h2><?= \Yii::t('amend', 'proposal_conflict_title') ?>:</h2>
        <ul class="collissionList">
            <?php
            foreach ($collidingAmendments as $collidingAmendment) {
                // Keep in sync with AmendmentController::actionEditProposedChangeCheck
                $title = $collidingAmendment->getShortTitle();
                $url   = UrlHelper::createAmendmentUrl($collidingAmendment);
                if ($collidingAmendment->proposalStatus == Amendment::STATUS_VOTE) {
                    $title .= ' (' . \Yii::t('amend', 'proposal_voting') . ')';
                }

                echo '<li>' . Html::a($title, $url, ['target' => '_blank']);
                echo HTMLTools::amendmentDiffTooltip($collidingAmendment, 'top', 'fixedBottom');
                echo '</li>';
            }
            ?>
        </ul>
    </aside>
<?php

echo Html::endForm();
