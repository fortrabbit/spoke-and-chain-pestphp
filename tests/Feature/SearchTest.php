<?php

it('finds two articles with matching keyword', function () {
    // Show and submit the form
    $response = $this->get('/search')
        ->form('#search-form')
        ->fill('q', 'Pine Mountain')
        ->submit();

    // Result: count items
    $response
        ->querySelector('.article-card')
        ->expect()
        ->toHaveCount(2);

    // Result: assert text
    expect($response->querySelector('.article-card')->getText())
        ->each()
        ->toContain('Pine Mountain');
});
