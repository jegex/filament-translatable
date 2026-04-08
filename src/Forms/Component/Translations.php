<?php

namespace Jegex\FilamentTranslatable\Forms\Component;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\View\FormsIconAlias;
use Filament\Support\Concerns\CanBeContained;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Jegex\FilamentTranslatable\Dto\Locale;
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\FilamentTranslatablePlugin;

class Translations extends Repeater
{
    use CanBeContained;

    /**
     * @var null|Closure|array<string>|Collection<int,string>
     */
    protected null | Closure | array | Collection $locales = null;

    protected ?string $defaultLocale = null;

    /**
     * @var null|Closure|array<string>|Collection<int,string>
     */
    protected null | Closure | array | Collection $exclude = [];

    /**
     * @var null|Closure|array<string,string>|Collection<string,string>
     */
    protected null | Closure | array | Collection $localeLabels = null;

    protected Closure | bool $hasPrefixLocaleLabel = false;

    protected Closure | bool $hasSuffixLocaleLabel = false;

    protected ?Closure $fieldTranslatableLabel = null;

    protected ?Closure $preformLocaleLabelUsing = null;

    protected int | Closure $activeTab = 1;

    protected string | Closure | null $tabQueryStringKey = null;

    protected string | Closure | null $livewireProperty = null;

    protected string | Closure | null $flagWidth = null;

    protected bool | Closure | null $displayFlagsInLocaleLabels = null;

    protected bool | Closure | null $displayNamesInLocaleLabels = null;

    protected Closure | TranslationMode | null $translationMode = null;

    protected bool | Closure $isVertical = false;

    protected bool | Closure $isScrollable = true;

    protected string $view = 'filament-translatable::forms.components.translatable';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(fn (Translations $component) => [
            $component->getDefaultLocale() => [],
        ]);

        $this->afterStateHydrated(static function (Translations $component, ?array $rawState): void {
            if (empty($rawState) && $component->getContainer()->getOperation() === 'create') {
                $rawState = [$component->getDefaultLocale() => []];
            }

            $component->rawState($rawState);
        });

        $this->mutateDehydratedStateUsing(static function (Translations $component, ?array $state): array {
            return $state;
        });
    }

    public function default(mixed $state): static
    {
        $this->defaultState = [
            $this->getDefaultLocale() => [],
        ];

        $this->hasDefaultState = true;

        $this->shouldMergeHydratedDefaultStateWithItemsStateAfterStateHydrated = true;

        return $this;
    }

    /**
     * @param  Closure|array<string>|Collection<int,string>  $exclude
     */
    public function exclude(Closure | array | Collection $exclude): static
    {
        $this->exclude = $exclude;

        return $this;
    }

    public function translationMode(TranslationMode | Closure | null $mode): static
    {
        $this->translationMode = $mode;

        return $this;
    }

    public function getTranslationMode(): TranslationMode
    {
        return $this->evaluate($this->translationMode ?? FilamentTranslatablePlugin::get()->getTranslationMode());
    }

    public function defaultLocale(string | Closure | null $locale): static
    {
        $this->defaultLocale = $locale;

        return $this;
    }

    public function getDefaultLocale(): ?string
    {
        return $this->evaluate($this->defaultLocale ?? FilamentTranslatablePlugin::get()->getDefaultLocale());
    }

    /**
     * @param  Closure|array<string>|Collection<int,string>|null  $locales
     */
    public function locales(Closure | array | Collection | null $locales): static
    {
        $this->locales = $locales;

        return $this;
    }

    /**
     * @param  Closure|array<string>|Collection<int,string>  $labels
     */
    public function localeLabels(Closure | array | Collection $labels): static
    {
        $this->localeLabels = $labels;

        return $this;
    }

    public function prefixLocaleLabel(Closure | bool $condition = true): static
    {
        $this->hasPrefixLocaleLabel = $condition;

        return $this;
    }

    public function suffixLocaleLabel(Closure | bool $condition = true): static
    {
        $this->hasSuffixLocaleLabel = $condition;

        return $this;
    }

    public function fieldTranslatableLabel(?Closure $fieldTranslatableLabel = null): static
    {
        $this->fieldTranslatableLabel = $fieldTranslatableLabel;

        return $this;
    }

    public function preformLocaleLabelUsing(?Closure $preformLocaleLabelUsing = null): static
    {
        $this->preformLocaleLabelUsing = $preformLocaleLabelUsing;

        return $this;
    }

    /**
     * @param  Closure|Action[]|null  $actions
     */
    public function actions(null | Closure | array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActiveTab(): int | Closure | null | string
    {
        if ($this->getItemsCount()) {
            return collect($this->getItems())->keys()->first();
        }

        return $this->evaluate($this->activeTab, ['locales' => $this->getLocales()]);
    }

    /**
     * @return array<Locale>
     */
    public function getLocales(): array
    {
        $locales = $this->evaluate($this->locales ?? FilamentTranslatablePlugin::get()->getLocales());

        if ($locales instanceof Collection) {
            $locales = $locales->all();
        }

        $preparedLocales = [];

        foreach ($locales as $key => $value) {
            // If the key is an integer, create a new Locale with the code only
            if (is_int($key) && is_string($value)) {
                $preparedLocales[$key] = new Locale($value);

                continue;
            }

            // If the key is a string, create a new Locale with the key as code and value as label
            if (is_string($key)) {
                $preparedLocales[$key] = new Locale($key, $value);

                continue;
            }

            // Otherwise, treat the value as a Locale
            $preparedLocales[] = $value;
        }

        return $preparedLocales;
    }

    public function getLocaleLabel(Locale $locale, bool $withFlag = true): string | Htmlable
    {
        $parts = [];

        if ($this->hasFlagsInLocaleLabels() && $withFlag) {
            $parts[] = '<img src="' . \asset($locale->flag) . '" style="width:' . $this->getFlagWidth() . ';max-width:' . $this->getFlagWidth() . '" alt="' . $locale->label . '" class="inline-block align-middle' . ($this->hasNamesInLocaleLabels() ? ' me-2' : '') . '" />';
        }

        if ($this->hasNamesInLocaleLabels()) {
            $parts[] = $locale->label;
        }

        $label = implode('', $parts) ?: $locale->code;

        if ($this->hasFlagsInLocaleLabels() && $withFlag) {
            return new HtmlString('<div class="text-nowrap">' . $label . '</div>');
        }

        return $label;
    }

    public function hasNamesInLocaleLabels(): bool
    {
        return $this->displayNamesInLocaleLabels !== null ? $this->evaluate($this->displayNamesInLocaleLabels) : FilamentTranslatablePlugin::get()->getDisplayNamesInLocaleLabels();
    }

    public function getFlagWidth(): string
    {
        return $this->flagWidth !== null ? $this->evaluate($this->flagWidth) : FilamentTranslatablePlugin::get()->getFlagWidth();
    }

    public function hasFlagsInLocaleLabels(): bool
    {
        return $this->displayFlagsInLocaleLabels !== null ? $this->evaluate($this->displayFlagsInLocaleLabels) : FilamentTranslatablePlugin::get()->getDisplayFlagsInLocaleLabels();
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

    public function getLocaleAvailableOptions(): array
    {
        $localeUsed = array_keys($this->getRawState() ?? []);

        return Arr::except($this->getLocales(), $localeUsed);
    }

    public function getSelectLocale(): Select
    {
        return Select::make('locale')
            ->hiddenLabel()
            ->allowHtml()
            ->native(false)
            ->options(function () {
                return collect($this->getLocaleAvailableOptions())
                    ->mapWithKeys(function (Locale $locale) {
                        $label = $this->getLocaleLabel($locale);

                        return [
                            $locale->code => $label instanceof Htmlable
                                ? $label->toHtml()
                                : $label,
                        ];
                    })
                    ->toArray();
            })
            ->required();
    }

    public function getCloneAction(): Action
    {
        return parent::getCloneAction()
            ->disabled(fn () => ! count($this->getLocaleAvailableOptions()))
            ->modalWidth(Width::Medium)
            ->icon(FilamentIcon::resolve(FormsIconAlias::COMPONENTS_REPEATER_ACTIONS_CLONE) ?? Heroicon::OutlinedSquare2Stack)
            ->schema([
                $this->getSelectLocale(),
            ])
            ->action(function (array $arguments, array $data, Translations $component): void {
                $locale = $data['locale'];
                $items = $component->getRawState();

                if ($locale) {
                    $items[$locale] = $items[$arguments['item']];
                } else {
                    $items[] = $items[$arguments['item']];
                }

                $component->rawState($items);
                $component->collapsed(false, shouldMakeComponentCollapsible: false);
                $component->callAfterStateUpdated();
                $component->shouldPartiallyRenderAfterActionsCalled() ? $component->partiallyRender() : null;
            });
    }

    public function getAddAction(): Action
    {
        return parent::getAddAction()
            ->icon(Heroicon::Plus)
            ->disabled(fn () => ! count($this->getLocaleAvailableOptions()))
            ->iconButton()
            ->modalWidth(Width::Medium)
            ->schema([
                $this->getSelectLocale(),
            ])
            ->action(function (array $data, Translations $component) {
                $locale = $data['locale'];
                $items = $component->getRawState();

                if ($locale) {
                    $items[$locale] = [];
                } else {
                    $items[] = [];
                }

                $component->rawState($items);
                $component->getChildSchema($locale ?? array_key_last($items))->fill();
                $component->collapsed(false, shouldMakeComponentCollapsible: false);
                $component->callAfterStateUpdated();
                $component->shouldPartiallyRenderAfterActionsCalled() ? $component->partiallyRender() : null;
            });
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
