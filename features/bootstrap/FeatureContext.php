<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given /^I log out$/
     */
    public function iLogOut() {
        $this->getSession()->reset();
    }

    /**
     * @Given /^I wait for ajax response$/
     */
    public function iWaitForAjaxResponse()
    {
        $this->getSession()->wait(1000);
    }

    /**
     * @Given I am logged in as :arg1 with :arg2
     */
    public function iAmLoggedInAsWith($arg1, $arg2)
    {
        $this->visit('signin');
        $this->fillField('email', $arg1);
        $this->fillField('password', $arg2);
        $this->pressButton('btn-signin');
        $this->getSession()->wait(2000);
    }
}
