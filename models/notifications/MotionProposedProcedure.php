<?php

namespace app\models\notifications;

use app\components\mail\Tools as MailTools;
use app\components\UrlHelper;
use app\models\settings\AntragsgruenApp;
use app\models\db\{EMailLog, Motion};

class MotionProposedProcedure
{
    public static function getPpOpenAcceptToken(Motion $motion): string
    {
        /** @var AntragsgruenApp $app */
        $app  = \Yii::$app->params;
        $base = 'getPpOpenAcceptToken' . $app->randomSeed . $motion->id;

        /** @noinspection PhpUnhandledExceptionInspection */
        return substr(preg_replace('/[^\w]/siu', '', base64_encode(sodium_crypto_generichash($base))), 0, 20);
    }

    public function __construct(Motion $motion, ?string $text = '', ?string $fromName = null, ?string $replyTo = null)
    {
        $initiator = $motion->getInitiators();
        if (count($initiator) === 0 || $initiator[0]->contactEmail === '') {
            return;
        }

        if ($text === null || trim($text) === '') {
            $text = static::getDefaultText($motion);
        }
        if ($replyTo === null || trim($replyTo) === '') {
            $replyTo = MailTools::getDefaultReplyTo($motion->getMyConsultation(), \app\models\db\User::getCurrentUser());
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        MailTools::sendWithLog(
            EMailLog::TYPE_AMENDMENT_PROPOSED_PROCEDURE,
            $motion->getMyConsultation(),
            trim($initiator[0]->contactEmail),
            null,
            str_replace('%PREFIX%', $motion->getTitleWithPrefix(), \Yii::t('motion', 'proposal_email_title')),
            $text,
            '',
            null,
            $fromName,
            $replyTo
        );
    }

    public static function getDefaultText(Motion $motion): string
    {
        $initiator     = $motion->getInitiators();
        $initiatorName = (count($initiator) > 0 ? $initiator[0]->getGivenNameOrFull() : null);

        switch ($motion->proposalStatus) {
            case Motion::STATUS_ACCEPTED:
                $body = \Yii::t('motion', 'proposal_email_accepted');
                break;
            case Motion::STATUS_MODIFIED_ACCEPTED:
                $body = \Yii::t('motion', 'proposal_email_modified');
                break;
            default:
                $body = \Yii::t('motion', 'proposal_email_other');
                break;
        }

        $procedureToken = static::getPpOpenAcceptToken($motion);
        $motionLink     = UrlHelper::absolutizeLink(UrlHelper::createMotionUrl($motion, 'view', ['procedureToken' => $procedureToken]));

        return str_replace(
            ['%LINK%', '%NAME%', '%NAME_GIVEN%'],
            [$motionLink, $motion->getTitleWithPrefix(), $initiatorName],
            $body
        );
    }
}
