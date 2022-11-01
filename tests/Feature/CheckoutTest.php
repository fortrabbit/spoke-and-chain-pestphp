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
        ->assertRedirectTo('/checkout/address');

    $next->request->enableCookieValidation = false;

    // 3. Address form
    $next = $next
        ->form('#checkout-address')
        ->fill('shippingAddress[firstName]', $newUser->firstName)
        ->fill('shippingAddress[lastName]', $newUser->lastName)
        ->fill('shippingAddress[addressLine1]', $newUser->addressLine1)
        ->fill('shippingAddress[locality]', $newUser->locality)
        ->fill('shippingAddress[postalCode]', $newUser->postalCode)
        ->select('shippingAddress[countryCode]', $newUser->countryCode)
        ->submit()
        ->assertRedirectTo('/checkout/shipping')
        ->followRedirect();

    // 4. Shipping form
    $next = $next
        ->form('#checkout-shipping')
        ->tick('shippingMethodHandle', 'freeShipping')
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
        ->assertRedirectTo('/checkout/success?number=*')
        ->followRedirect();

    // 6. Finally
    $next
        ->querySelector('h1')
        ->assertText('Success');

})->with([
    (object) [
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
    ]
]);
