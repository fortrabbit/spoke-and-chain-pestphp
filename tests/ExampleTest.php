<?php

use function markhuot\craftpest\helpers\http\get;

//
// "Better to light one candle than to curse the darkness." ~ Chinese Proverb
//
// Your test library will grow over time and become more and more complex with each added feature. You will add
// business logic, unwritten rules, and all sorts of odds and ends here. Pest makes it easy to keep track of
// those things that would otherwise be forgotten. If you find yourself adding a code comment or a //todo to
// remember _why_ something is the way it is, add a test.
//
// Before any of that, let's start with a simple test ensures the homepage loads and returns an 200 Ok status code.
get('/')->assertOk();

it('renders the homepage with h1', function() {
	$this->get('/')
		->assertOk()
		->querySelector('.aspect-ratio-hero-home h1')
		->assertText('Made for fun since 1986');
});


test('no errors', function ($url) {
	$this->get($url)->assertOk();
})->with([
    '/bikes',
    '/services',
    '/articles',
    '/lost-page',
    '/contact'

]);

