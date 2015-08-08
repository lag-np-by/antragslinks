<?php

namespace app\components\diff;

use app\models\db\AmendmentSection;
use app\models\db\MotionSection;

class AmendmentDiffMerger
{
    private $paras          = null;
    private $paraData       = null;
    private $diffParagraphs = null;

    /**
     * @return array
     */
    public function getParaData()
    {
        return $this->paraData;
    }

    /**
     * @return array
     */
    public function getParagraphs()
    {
        return $this->paras;
    }


    /**
     * @param MotionSection $section
     * @throws \app\models\exceptions\Internal
     */
    public function initByMotionSection(MotionSection $section)
    {
        $paras = $section->getTextParagraphs();
        $this->initByMotionParagraphs($paras);
    }

    /**
     * @param array $paras
     */
    public function initByMotionParagraphs($paras)
    {
        $this->paras    = $paras;
        $this->paraData = [];
        foreach ($paras as $paraNo => $paraStr) {
            $origTokenized = \app\components\diff\Diff::tokenizeLine($paraStr);
            $origArr       = preg_split('/\R/', $origTokenized);
            $words         = [];
            foreach ($origArr as $x) {
                $words[] = [
                    'orig'         => $x,
                    'modification' => null,
                    'modifiedBy'   => null,
                ];
            }
            $this->paraData[$paraNo] = [
                'orig'                => $paraStr,
                'origTokenized'       => $origTokenized,
                'words'               => $words,
                'collidingParagraphs' => [],
            ];
        }
    }

    /**
     * @param int $amendmentId
     * @param array $affectedParas
     */
    public function addAmendingParagraphs($amendmentId, $affectedParas)
    {
        $diffEngine = new \app\components\diff\Engine();
        foreach ($affectedParas as $amendPara => $amendText) {
            $newTokens  = \app\components\diff\Diff::tokenizeLine($amendText);
            $diffTokens = $diffEngine->compareStrings($this->paraData[$amendPara]['origTokenized'], $newTokens);
            $diffTokens = $diffEngine->shiftMisplacedHTMLTags($diffTokens);
            $firstDiff  = null;
            foreach ($diffTokens as $i => $token) {
                if ($firstDiff === null && $token[1] != Engine::UNMODIFIED) {
                    $firstDiff = $i;
                }
            }
            $this->diffParagraphs[$amendPara][] = [
                'amendment' => $amendmentId,
                'firstDiff' => $firstDiff,
                'diff'      => $diffTokens,
            ];
        }
    }

    /**
     * @param AmendmentSection[] $sections
     */
    public function addAmendingSections($sections)
    {
        $this->diffParagraphs = [];
        foreach (array_keys($this->paras) as $para) {
            $this->diffParagraphs[$para] = [];
        }
        foreach ($sections as $section) {
            $affectedParas = $section->getAffectedParagraphs($this->paras);
            $this->addAmendingParagraphs($section->amendmentId, $affectedParas);
        }
    }

    /**
     * For testing
     *
     * @param array $data
     */
    public function setAmendingSectionData($data)
    {
        $this->diffParagraphs = $data;
    }

    /**
     * Sort the amendment paragraphs by the last affected line/word.
     * This is an attempt to minimize the number of collissions when merging the paragraphs later on,
     * as amendments changing a lot and therefore colloding more frequently tend to start at earlier lines.
     */
    private function sortDiffParagraphs()
    {
        foreach (array_keys($this->diffParagraphs) as $paraId) {
            usort($this->diffParagraphs[$paraId], function ($val1, $val2) {
                if ($val1['firstDiff'] < $val2['firstDiff']) {
                    return 1;
                }
                if ($val2['firstDiff'] < $val1['firstDiff']) {
                    return -1;
                }
                return 0;
            });
        }
    }

    /**
     * @param int $paraNo
     * @param array $diff
     * @return bool;
     */
    private function checkIsDiffColliding($paraNo, $diff)
    {
        $origNo = 0;
        foreach ($diff as $token) {
            if ($token[1] == Engine::INSERTED) {
                if ($token[0] == '') {
                    continue;
                }
                $pre = $origNo - 1;
                if ($this->paraData[$paraNo]['words'][$pre]['modifiedBy'] !== null) {
                    return true;
                }
            } elseif ($token[1] == Engine::DELETED) {
                if ($token[0] != '') {
                    if ($this->paraData[$paraNo]['words'][$origNo]['modifiedBy'] !== null) {
                        return true;
                    }
                }
                $origNo++;
            } elseif ($token[1] == Engine::UNMODIFIED) {
                $origNo++;
            }
        }
        return false;
    }

    /**
     * @param int $paraNo
     * @param array $changeSet
     */
    public function mergeParagraph($paraNo, $changeSet)
    {
        $amendId = $changeSet['amendment'];
        $origNo  = 0;
        $words   = $this->paraData[$paraNo]['words'];

        foreach ($changeSet['diff'] as $token) {
            if ($token[1] == Engine::INSERTED) {
                if ($token[0] == '') {
                    continue;
                }
                $insStr = '<ins>' . $token[0] . '</ins>';
                if ($origNo == 0) {
                    // @TODO
                } else {
                    $pre = $origNo - 1;
                    if ($words[$pre]['modifiedBy'] === null) {
                        $words[$pre]['modifiedBy']   = $amendId;
                        $words[$pre]['modification'] = $words[$pre]['orig'];
                    }
                    $words[$pre]['modification'] .= $insStr;
                }
            } elseif ($token[1] == Engine::DELETED) {
                if ($token[0] != '') {
                    $delStr = '<del>' . $token[0] . '</del>';
                    if ($words[$origNo]['modifiedBy'] === null) {
                        $words[$origNo]['modifiedBy']   = $amendId;
                        $words[$origNo]['modification'] = '';
                    }
                    $words[$origNo]['modification'] .= $delStr;
                }
                $origNo++;
            } elseif ($token[1] == Engine::UNMODIFIED) {
                $origNo++;
            }
        }

        $this->paraData[$paraNo]['words'] = $words;
    }

    /**
     */
    public function mergeParagraphs()
    {
        $this->sortDiffParagraphs();
        foreach ($this->diffParagraphs as $paraNo => $para) {
            foreach ($para as $changeSet) {
                if ($this->checkIsDiffColliding($paraNo, $changeSet['diff'])) {
                    $this->paraData[$paraNo]['collidingParagraphs'][] = $changeSet;
                } else {
                    $this->mergeParagraph($paraNo, $changeSet);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getGroupedParagraphData()
    {
        $groupedParaData = [];
        foreach ($this->paraData as $paraNo => $para) {
            $paraG            = [];
            $pending          = '';
            $pendingCurrAmend = 0;

            $addToParaG = function ($pendingCurrAmend, $text) use (&$paraG) {
                $paraG[] = [
                    'amendment' => $pendingCurrAmend,
                    'text'      => static::cleanupParagraphData($text),
                ];
            };

            foreach ($para['words'] as $word) {
                if ($word['modifiedBy'] !== null) {
                    if ($pendingCurrAmend == 0 && $word['orig'] != '') {
                        if (mb_strpos($word['modification'], $word['orig']) === 0) {
                            $shortened = mb_substr($word['modification'], mb_strlen($word['orig']));
                            $pending .= $word['orig'];
                            $word['modification'] = $shortened;
                        }
                    }
                    if ($word['modifiedBy'] != $pendingCurrAmend) {
                        $addToParaG($pendingCurrAmend, $pending);
                        $pending          = '';
                        $pendingCurrAmend = $word['modifiedBy'];
                    }
                    $pending .= $word['modification'];
                } else {
                    if (0 != $pendingCurrAmend) {
                        $addToParaG($pendingCurrAmend, $pending);
                        $pending          = '';
                        $pendingCurrAmend = 0;
                    }
                    $pending .= $word['orig'];
                }
            }
            $addToParaG($pendingCurrAmend, $pending);
            $groupedParaData[$paraNo] = $paraG;
        }
        return $groupedParaData;
    }

    /**
     * @param string $text
     * @return string
     */
    public static function cleanupParagraphData($text)
    {
        $text = preg_replace('/<(del|ins)>(<\/?(li|ul|ol)>)<\/(del|ins)>/siu', '\2', $text);
        $text = str_replace('</ins><ins>', '', $text);
        $text = str_replace('</del><del>', '', $text);
        $text = str_replace('<ins><p>', '<p><ins>', $text);
        $text = str_replace('<del><p>', '<p><del>', $text);
        $text = str_replace('</p></ins>', '</ins></p>', $text);
        $text = str_replace('</p></del>', '</del></p>', $text);
        return $text;
    }

    /**
     * @param array $paras
     * @return array
     */
    public static function filterChangingGroupedParagraphs($paras)
    {
        $return = [];
        foreach ($paras as $para) {
            $currBlock = [];
            foreach ($para as $paraBlock) {
                if ($paraBlock['amendment'] > 0) {
                    $currBlock[] = $paraBlock;
                }
            }
            $return[] = $currBlock;
        }
        return $return;
    }
}
