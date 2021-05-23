<?php
namespace Tests\Functional;

use FunctionalTester;

class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email', 'kolesniks559@gmail.com');
        $I->fillField('password', 'kakashla12');
        $I->click('Login');

        $I->see('logout', 'submit');
    }
    public function dontSeeAuthentication(FunctionalTester $I)
    {
        $I->amOnPage('/home');
        $I->dontSeeAuthentication();
    }
    public function grabRecord(FunctionalTester $I)
    {
        $record = $I->grabRecord('users', ['email' => 'kolesniks559@gmail.com']);
        $I->assertTrue(is_array($record));

    }
}
