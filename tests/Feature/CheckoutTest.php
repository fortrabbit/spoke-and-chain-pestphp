<?php

test('checkout as a guest', function() {

    $this->get('/product/san-quentin-24')
        ->assertOk()
        ->form('#buy form')
        ->submit()
        ->assertOk();

});

/*

namespace crafttests\acceptance;
use Craft;
use AcceptanceTester;

class CheckoutCest
{

public
function testCheckout(AcceptanceTester $I, \Codeception\Example $singleUser)
{
    // Add a product to the cart
    $I->amOnPage('product/san-quentin-24');
    $I->click('#buy button[type=submit]');

    // Navigate to the cart
    $I->click('button.cart-toggle');
    $I->see('Check Out', 'div.cart-menu a.button.submit');
    $I->click('div.cart-menu a.button.submit');

    // Checkout as guest
    $I->see('Continue as Guest', '#guest-checkout button[type=submit]');
    $I->fillField('#guest-checkout input[type=text]', $singleUser['email']);
    $I->click('#guest-checkout button[type=submit]');

    $I->submitForm('form#checkout-address', ['shippingAddress' => [
        'firstName' => $singleUser['firstName'],
        'lastName' => $singleUser['lastName'],
        'addressLine1' => $singleUser['addressLine1'],
        'locality' => $singleUser['locality'],
        'postalCode' => $singleUser['postalCode'],
        'countryCode' => $singleUser['countryCode'],
    ]]);
    $I->amOnPage('/checkout/shipping');

    // Use the default shipping method
    $I->click('form#checkout-shipping-method input[type=radio][value="freeShipping"]');
    $I->click('form#checkout-shipping-method button[type=submit]');

    // Fill credit card details and pay
    $I->submitForm('form#checkout-payment', ['paymentForm' => [
        'dummy' => [
            'firstName' => $singleUser['firstName'],
            'lastName' => $singleUser['lastName'],
            'number' => $singleUser['cardNumber'],
            'expiry' => $singleUser['cardExpiry'],
            'cvv' => $singleUser['cardCvv'],
        ]
    ]]);

    // success
    $I->see('Success', 'h1');
}

protected
function userProvider()
{
    return [
        [
            'email' => 'ben@craftcms.com',
            'firstName' => 'Ben',
            'lastName' => 'David',
            'addressLine1' => '13 rue des Papillons',
            'locality' => 'Grenoble',
            'postalCode' => '38000',
            'countryCode' => 'FR',
            'cardNumber' => '4242424242424242',
            'cardExpiry' => '03/2026',
            'cardCvv' => '123',
        ],
    ];
}
}
*/
