<?php

/** @var \Codeception\Scenario $scenario */
$I = new AcceptanceTester($scenario);
$I->populateDBData1();

$I->wantTo('write a comment, but forget my name');
$I->gotoConsultationHome(true, 'bdk', 'bdk')->gotoMotionView(4);

$I->dontSee('Kommentar schreiben');
$I->click('#section_21_1 .comment .shower');
$I->see('Kommentar schreiben', '#section_21_1');
$I->fillField('#comment_21_1_name', '');
$I->fillField('#comment_21_1_email', 'test@example.org');
$I->fillField('#comment_21_1_text', 'Some Text');
$I->submitForm('#section_21_1 .commentForm', [], 'writeComment');

$I->see('Bitte gib deinen Namen an');
$I->see('Kommentar schreiben', '#section_21_1');
$I->seeInField('#comment_21_1_name', '');
$I->seeInField('#comment_21_1_email', 'test@example.org');
$I->seeInField('#comment_21_1_text', 'Some Text');


$I->wantTo('enter the missing data');
$I->fillField('#comment_21_1_name', 'My Name');
$I->submitForm('#section_21_1 .commentForm', [], 'writeComment');

$I->see(mb_strtoupper('My Name'), '#section_21_1 .motionComment');
$I->see('Some Text', '#section_21_1 .motionComment');
$I->dontSee('#section_21_1 .motionComment .delLink');



$I->wantTo('see the comment on the sidebar and the feed');
$I->gotoConsultationHome(true, 'bdk', 'bdk');
$I->see('My Name', '#sidebar .comments');
$I->click('.feedComments');
$I->seeInPageSource('My Name');
$I->gotoConsultationHome(true, 'bdk', 'bdk');
$I->click('.feedAll');
$I->seeInPageSource('My Name');




$I->wantTo('delete the comment');
$I->gotoConsultationHome(true, 'bdk', 'bdk');
$I->loginAsStdAdmin();
$I->gotoConsultationHome(true, 'bdk', 'bdk')->gotoMotionView(4);

$I->dontSee('Kommentar schreiben');
$I->click('#section_21_1 .comment .shower');
$I->see('Kommentar schreiben', '#section_21_1');

$I->seeElement('#section_21_1 .motionComment .delLink');

$I->submitForm('#section_21_1 .motionComment .delLink', [], '');
$I->wait(1);
$I->see('Wirklich löschen', '.bootbox');
$I->click('.bootbox .btn-primary');

$I->dontSee('Kommentar schreiben');
$I->click('#section_21_1 .comment .shower');
$I->dontSee('My Name', '#section_21_1 .motionComment');
$I->dontSee('Some Text', '#section_21_1 .motionComment');


// @TODO Switching to section-based comments afterwards -> should be still visible