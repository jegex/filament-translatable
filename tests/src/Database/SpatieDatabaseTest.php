<?php

use Jegex\FilamentTranslatable\Tests\DatabaseTestCase;
use Jegex\FilamentTranslatable\Tests\Models\SpatiePost;

uses(DatabaseTestCase::class);

it('can save translations to JSON column with Spatie package', function (): void {
    $post = new SpatiePost;
    $post->author = 'John Doe';
    $post->setTranslation('title', 'en', 'English Title');
    $post->setTranslation('title', 'fr', 'French Title');
    $post->setTranslation('title', 'pl', 'Polish Title');
    $post->setTranslation('content', 'en', 'English Content');
    $post->setTranslation('content', 'fr', 'French Content');
    $post->setTranslation('content', 'pl', 'Polish Content');
    $post->save();

    // Verify the post was saved
    $savedPost = SpatiePost::find($post->id);

    expect($savedPost)->not->toBeNull();
    expect($savedPost->author)->toBe('John Doe');

    // Verify translations are retrieved correctly
    expect($savedPost->getTranslation('title', 'en'))->toBe('English Title');
    expect($savedPost->getTranslation('title', 'fr'))->toBe('French Title');
    expect($savedPost->getTranslation('title', 'pl'))->toBe('Polish Title');
    expect($savedPost->getTranslation('content', 'en'))->toBe('English Content');
    expect($savedPost->getTranslation('content', 'fr'))->toBe('French Content');
    expect($savedPost->getTranslation('content', 'pl'))->toBe('Polish Content');

    // Verify translations are stored in the same table as JSON
    $rawData = $savedPost->getRawOriginal('title');
    $titleTranslations = json_decode((string) $rawData, true);

    expect($titleTranslations)->toBeArray();
    expect($titleTranslations)->toHaveKey('en');
    expect($titleTranslations)->toHaveKey('fr');
    expect($titleTranslations)->toHaveKey('pl');
});
