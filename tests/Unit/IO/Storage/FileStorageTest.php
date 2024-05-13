<?php

use Sendama\Engine\IO\Storage\FileStorage;

it('can get the singleton instance of FileStorage', function() {
    $fileStorage = FileStorage::getInstance();
    expect($fileStorage)->toBeInstanceOf(FileStorage::class);
});

it ('can load a save file')