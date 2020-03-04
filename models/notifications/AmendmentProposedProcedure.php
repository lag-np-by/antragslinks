<?php

namespace app\models\notifications;

use app\components\mail\Tools as MailTools;
use app\components\UrlHelper;
use app\models\db\{Amendment, EMailLog};
use app\models\settings\AntragsgruenApp;

class AmendmentProposedProcedure
{
    public static function getPpOpenAcceptToken(Amendment $amendment): string
    {
        /** @var AntragsgruenApp $app */
        $app  = \Yii::$app->params;
        $base = 'getPpOpenAcceptToken' . $app->randomSeed . $amendment->motionId . '-' . $amendment->id;

        /** @noinspection PhpUnhandledExceptionInspection */
        return substr(preg_replace('/[^\w]/siu', '', base64_encode(sodium_crypto_generichash($base))), 0, 20);
    }

    public function __construct(Amendment $amendment, ?string $text = null, ?string $fromName = null, ?string $replyTo = null)
    {
        $initiator = $amendment->getInitiators();
        if (count($initiator) === 0 || $initiator[0]->contactEmail === '') {
            return;
        }

        if ($text === null || trim($text) === '') {
            $text = static::getDefaultText($amendment);
        }
        if ($replyTo === null || trim($replyTo) === '') {
            $replyTo = MailTools::getDefaultReplyTo($amendment->getMyConsultation(), \app\models\db\User::getCurrentUser());
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        MailTools::sendWithLog(
            EMailLog::TYPE_AMENDMENT_PROPOSED_PROCEDURE,
            $amendment->getMyConsultation(),
            trim($initiator[0]->contactEmail),
            null,
            str_replace('%PREFIX%', $amendment->getShortTitle(), \Yii::t('amend', 'proposal_email_title')),
            $text,
            '',
            null,
            $fromName,
            $replyTo
        );
    }

    public static function getDefaultText(Amendment $amendment): string
    {
        $initiator = $amendment->getInitiators();

        switch ($amendment->proposalStatus) {
            case Amendment::STATUS_ACCEPTED:
                $body = \Yii::t('amend', 'proposal_email_accepted');
                break;
            case Amendment::STATUS_MODIFIED_ACCEPTED:
                $body = \Yii::t('amend', 'proposal_email_modified');
                break;
            default:
                $body = \Yii::t('amend', 'proposal_email_other');
                break;
        }

        $procedureToken = static::getPpOpenAcceptToken($amendment);
        $amendmentLink  = UrlHelper::absolutizeLink(UrlHelper::createAmendmentUrl($amendment, 'view', ['procedureToken' => $procedureToken]));

        return str_replace(
            ['%LINK%', '%NAME%', '%NAME_GIVEN%'],
            [$amendmentLink, $amendment->getShortTitle(), $initiator[0]->getGivenNameOrFull()],
            $body
        );
    }
}
