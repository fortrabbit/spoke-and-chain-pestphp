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
        ->assertCount(2);

    // Result: assert text
    $articleCards = $response->querySelector('.article-card');
    expect($articleCards->getText())
        ->each()
        ->toContain('Pine Mountain');
});
