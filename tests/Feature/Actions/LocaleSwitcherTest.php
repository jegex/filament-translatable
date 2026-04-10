<?php

use Jegex\FilamentTranslatable\Actions\LocaleSwitcher;

it('has correct default name', function () {
    expect(LocaleSwitcher::getDefaultName())->toBe('activeLocale');
});

it('can be instantiated', function () {
    $action = LocaleSwitcher::make('activeLocale');

    expect($action)->toBeInstanceOf(LocaleSwitcher::class);
});
