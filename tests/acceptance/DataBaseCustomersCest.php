<?php

class DataBaseCustomersCest
{
    private const BUTTON_RUN_SQL = '//*/button[text()[contains(.,"Run SQL")]]';

    public function _before(AcceptanceTester $I)
    {
          $I->amOnPage('/sql/trysql.asp?filename=trysql_select_all');
    }

    public function ReadTest(AcceptanceTester $I)
    {
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForElement('//table[@class="w3-table-all notranslate"]', 10);
        $address=$I->grabTextFrom('//*/tr/td[text()="Giovanni Rovelli"]/following-sibling::*');
        $I->assertEquals("Via Ludovico il Moro 22", $address, 'Giovanni Rovelli has address Via Ludovico il Moro 21');
    }

    public function FilterTest(AcceptanceTester $I)
    {
        $I->executeJs('window.editor.setValue("select * from customers where City =\'London\'")');
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForText('Number of Records: 6', 10);
        $I->seeNumberOfElements('//table/*/tr', 7);
    }

    public function InsertTest(AcceptanceTester $I)
    {
        $I->executeJs('window.editor.setValue("INSERT INTO Customers(\'CustomerName\',\'ContactName\',\'Address\',\'City\',\'PostalCode\',\'Country\') VALUES(\'Ivanov IV\', \'Ivan Ivanov\', \'Adress 12\', \'Moscow\', \'123456\', \'Russia\')")');
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForText('You have made changes to the database. Rows affected: 1');
        $I->executeJs('window.editor.setValue("select * from customers")');
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForElement('//*[text()="Ivanov IV"]', 10);
        $I->canSeeElement('//*/tr[last()]/*[text()="Ivan Ivanov"]');
        $I->canSeeElement('//*/tr[last()]/*[text()="Adress 12"]');
        $I->canSeeElement('//*/tr[last()]/*[text()="Moscow"]');
        $I->canSeeElement('//*/tr[last()]/*[text()="123456"]');
        $I->canSeeElement('//*/tr[last()]/*[text()="Russia"]');
    }

    public function UpdateTest(AcceptanceTester $I)
    {
        $I->executeJs('window.editor.setValue("UPDATE Customers SET CustomerName=\'NewCustomerName\', ContactName=\'NewContactName\', Address=\'NewAddress\', City=\'NewCity\', PostalCode=\'111111\', Country=\'NewCountry\' WHERE CustomerID=1")');
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForText('You have made changes to the database. Rows affected: 1', 10);
        $I->executeJs('window.editor.setValue("select * from customers")');
        $I->click(self::BUTTON_RUN_SQL);
        $I->waitForElement('//*[text()="NewCustomerName"]', 10);
        $I->canSeeElement('//*[text()="NewContactName"]');
        $I->canSeeElement('//*[text()="NewAddress"]');
        $I->canSeeElement('//*[text()="NewCity"]');
        $I->canSeeElement('//*[text()="111111"]');
        $I->canSeeElement('//*[text()="NewCountry"]');
    }
}
