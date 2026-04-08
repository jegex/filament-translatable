<?php

namespace Jegex\FilamentTranslatable\Commands;

use Illuminate\Console\Command;

class FilamentTranslatableCommand extends Command
{
    public $signature = 'filament-translatable';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
