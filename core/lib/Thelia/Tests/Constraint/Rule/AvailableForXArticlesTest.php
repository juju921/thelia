<?php
/**********************************************************************************/
/*                                                                                */
/*      Thelia	                                                                  */
/*                                                                                */
/*      Copyright (c) OpenStudio                                                  */
/*      email : info@thelia.net                                                   */
/*      web : http://www.thelia.net                                               */
/*                                                                                */
/*      This program is free software; you can redistribute it and/or modify      */
/*      it under the terms of the GNU General Public License as published by      */
/*      the Free Software Foundation; either version 3 of the License             */
/*                                                                                */
/*      This program is distributed in the hope that it will be useful,           */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of            */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             */
/*      GNU General Public License for more details.                              */
/*                                                                                */
/*      You should have received a copy of the GNU General Public License         */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.      */
/*                                                                                */
/**********************************************************************************/

namespace Thelia\Coupon;

use Thelia\Constraint\Rule\AvailableForXArticles;

/**
 * Created by JetBrains PhpStorm.
 * Date: 8/19/13
 * Time: 3:24 PM
 *
 * Unit Test AvailableForXArticles Class
 *
 * @package Constraint
 * @author  Guillaume MOREL <gmorel@openstudio.fr>
 *
 */
class AvailableForXArticlesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        /** @var CouponAdapterInterface $stubTheliaAdapter */
        $stubTheliaAdapter = $this->generateValidCouponBaseAdapterMock();
    }

    /**
     * Return an Adapter Mock wick 4 products int the Cart
     *
     * @return CouponAdapterInterface
     */
    protected function generateValidCouponBaseAdapterMock()
    {
        /** @var CouponAdapterInterface $stubTheliaAdapter */
        $stubTheliaAdapter = $this->getMock(
            'CouponBaseAdapter',
            array('getNbArticlesInCart'),
            array()
        );
        $stubTheliaAdapter->expects($this->any())
            ->method('getNbArticlesInCart')
            ->will($this->returnValue(4));

        return $stubTheliaAdapter;
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::checkBackOfficeInput
     *
     */
    public function testValidBackOfficeInput()
    {
        $adapter = new CouponBaseAdapter();

        $validators = array(4);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = true;
        $actual = $rule->checkBackOfficeInput();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::checkBackOfficeInput
     *
     */
    public function testInValidBackOfficeInput()
    {
        $adapter = new CouponBaseAdapter();

        $validators = array(4.5);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkBackOfficeInput();
        $this->assertEquals($expected, $actual);

        $validators = array(-1);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkBackOfficeInput();
        $this->assertEquals($expected, $actual);

        $validators = array('bad');
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkBackOfficeInput();
        $this->assertEquals($expected, $actual);
    }



    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::checkCheckoutInput
     *
     */
    public function testValidCheckoutInput()
    {
        $adapter = new CouponBaseAdapter();
        $validators = array(4);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = true;
        $actual = $rule->checkCheckoutInput();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::checkCheckoutInput
     *
     */
    public function testInValidCheckoutInput()
    {
        $adapter = new CouponBaseAdapter();
        $validators = array(4.5);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkCheckoutInput();
        $this->assertEquals($expected, $actual);

        $validators = array(-1);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkCheckoutInput();
        $this->assertEquals($expected, $actual);

        $validators = array('bad');
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->checkCheckoutInput();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::isMatching
     *
     */
    public function testMatchingRuleEqual()
    {
        $adapter = new CouponBaseAdapter();
        $validators = array(4);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = true;
        $actual = $rule->isMatching();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::isMatching
     *
     */
    public function testMatchingRuleSuperior()
    {
        $adapter = new CouponBaseAdapter();
        $validators = array(5);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = true;
        $actual = $rule->isMatching();
        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @covers Thelia\Coupon\Rule\AvailableForXArticles::isMatching
     *
     */
    public function testNotMatchingRule()
    {
        $adapter = new CouponBaseAdapter();
        $validators = array(3);
        $validated = array($adapter->getNbArticlesInCart());
        $rule = new AvailableForXArticles($adapter, $validators, $validated);

        $expected = false;
        $actual = $rule->isMatching();
        $this->assertEquals($expected, $actual);
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

}