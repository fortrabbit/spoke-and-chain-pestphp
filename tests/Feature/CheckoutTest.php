<?php

test('full checkout process as a guest', function($newUser) {

    // 1. Add a product to the cart
    $this->get('/product/san-quentin-24')
        ->form('#buy form')
        ->submit()
        ->assertRedirect();


    // 2.Checkout as guest using email
    $next = $this->get('/checkout')
        ->assertStatus(200)
        ->form('#guest-checkout')
        ->fill('email', $newUser->email)
        ->submit()
        ->assertRedirectTo('/checkout/address')
        ->assertFlash('Cart updated.')
        ->followRedirect();

    // 3. Address form
    $next = $next
        ->form('#checkout-address')
        ->fill('shippingAddress[firstName]', $newUser->firstName)
        ->fill('shippingAddress[lastName]', $newUser->lastName)
        ->fill('shippingAddress[addressLine1]', $newUser->addressLine1)
        ->fill('shippingAddress[locality]', $newUser->locality)
        ->fill('shippingAddress[postalCode]', $newUser->postalCode)
        ->select('shippingAddress[countryCode]', $newUser->countryCode)
        // add virtual field
        ->addField('shippingAddress[administrativeArea]', $newUser->administrativeArea)
        ->tick('billingAddressSameAsShipping')
        ->submit()
        ->assertRedirectTo('/checkout/shipping')
        ->followRedirect();

    // 4. Shipping form
    $next = $next
        ->form('#checkout-shipping-method')
        ->select('shippingMethodHandle', 'freeShipping')
        ->submit()
        ->assertRedirectTo('/checkout/summary')
        ->followRedirect();

    // 5. Payment form
    $next = $next
        ->form('#checkout-payment')
        ->fill('paymentForm[dummy][firstName]', $newUser->firstName)
        ->fill('paymentForm[dummy][lastName]', $newUser->lastName)
        ->fill('paymentForm[dummy][number]', $newUser->cardNumber)
        ->fill('paymentForm[dummy][expiry]', $newUser->cardExpiry)
        ->fill('paymentForm[dummy][cvv]', $newUser->cardCvv)
        ->submit()
        ->assertRedirect()
        ->followRedirect();


    // 6. Finally
    $next
        ->querySelector('h1')
        ->assertText('Success');

})->with([

    'Tim Kelty, USA' => (object) [
        'email' => 'tim@craftcms.com',
        'firstName' => 'Tim',
        'lastName' => 'Kelty',
        'addressLine1' => 'Garfield Park',
        'locality' => 'Grand Rapids',
        'postalCode' => '44444',
        'countryCode' => 'US',
        'administrativeArea' => 'MI',
        'cardNumber' => '4242424242424242',
        'cardExpiry' => '03/2026',
        'cardCvv' => '123',
    ],



]);
