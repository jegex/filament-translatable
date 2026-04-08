<?php

namespace Jegex\FilamentTranslatable\Forms\Component;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\View\FormsIconAlias;
use Filament\Support\Concerns\CanBeContained;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;

class Translations extends Repeater
{
    use CanBeContained;

    protected bool | Closure $isVertical = false;

    protected bool | Closure $isScrollable = true;

    protected string $view = 'filament-translatable::forms.components.translatable';

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function getActiveTab(): int | Closure | null | string
    {
        if ($this->getItemsCount()) {
            return collect($this->getItems())->keys()->first();
        }

        return 0;
    }

    public function isCollapsible(): bool
    {
        return false;
    }

    public function getDeleteAction(): Action
    {
        return parent::getDeleteAction()
            ->icon(
                FilamentIcon::resolve(FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_DELETE) ??
                    Heroicon::XMark
            );
    }

    public function getAddAction(): Action
    {
        return parent::getAddAction()
            ->icon(Heroicon::Plus)
            ->iconButton();
    }

    public function vertical(bool | Closure $condition = true): static
    {
        $this->isVertical = $condition;

        return $this;
    }

    public function isVertical(): bool
    {
        return (bool) $this->evaluate($this->isVertical);
    }

    public function scrollable(bool | Closure $condition = true): static
    {
        $this->isScrollable = $condition;

        return $this;
    }

    public function isScrollable(): bool
    {
        return (bool) $this->evaluate($this->isScrollable);
    }
}
