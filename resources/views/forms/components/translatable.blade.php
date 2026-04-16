@php
    use Filament\Support\Enums\Alignment;

    $fieldWrapperView = $getFieldWrapperView();
    $items = $getItems();
    $addAction = $getAction($getAddActionName());
    $cloneAction = $getAction($getCloneActionName());
    $deleteAction = $getAction($getDeleteActionName());
    $moveDownAction = $getAction($getMoveDownActionName());
    $moveUpAction = $getAction($getMoveUpActionName());
    $extraItemActions = $getExtraItemActions();

    $hasItemNumbers = $hasItemNumbers();
    $isAddable = $isAddable();
    $isCloneable = $isCloneable();
    $isDeletable = $isDeletable();
    $isReorderableWithButtons = $isReorderableWithButtons();
    $isReorderableWithDragAndDrop = $isReorderableWithDragAndDrop();

    $key = $getKey();
    $statePath = $getStatePath();

    // Tabs
    $isContained = $isContained();
    $isVertical = $isVertical();
    $isScrollable = $isScrollable();
    $getActiveTab = $getActiveTab();
@endphp

<x-dynamic-component :component="$fieldWrapperView" :field="$field">
    <div
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'fi-tab-repeater',
                    'fi-sc-tabs',
                    'fi-contained' => $isContained,
                    'fi-vertical' => $isVertical,
                ])
        }}
        x-data="{
            activeTab: @js($getActiveTab),
            isScrollable: @js($isScrollable)
        }"
    >

        <x-filament::tabs
            :contained="$isContained"
            :vertical="$isVertical"
            x-bind:style="!isScrollable && {'flex-wrap': 'wrap'}"
        >
            @foreach ($items as $itemKey => $item)
                @php
                    $locale = $getLocales()[$itemKey] ?? new \Jegex\FilamentTranslatable\Dto\Locale($itemKey);
                    $itemLabel = $getLocaleLabel($locale);
                    $visibleExtraItemActions = array_filter(
                        $extraItemActions,
                        fn ($action): bool => $action(['item' => $itemKey])->isVisible(),
                    );
                    $cloneAction = $cloneAction(['item' => $itemKey]);
                    $cloneActionIsVisible = $isCloneable && $cloneAction->isVisible();
                    $deleteAction = $deleteAction(['item' => $itemKey]);
                    $deleteActionIsVisible = $isDeletable && $deleteAction->isVisible();
                    $moveUpAction = $moveUpAction(['item' => $itemKey])->disabled($loop->first);
                    $moveUpActionIsVisible = $isReorderableWithButtons && $moveUpAction->isVisible();
                    $moveDownAction = $moveDownAction(['item' => $itemKey])->disabled($loop->last);
                    $moveDownActionIsVisible = $isReorderableWithButtons && $moveDownAction->isVisible();
                    $index = $loop->index;
                @endphp
                <x-filament::tabs.item
                    tag="div"
                    :active="$itemKey === $getActiveTab"
                    x-bind:active="activeTab === '{{ $itemKey }}'"
                    x-on:click="activeTab = '{{ $itemKey }}'"
                    alpineActive="activeTab === '{{ $itemKey }}'"
                    wire:ignore.self
                    wire:key="{{ $item->getLivewireKey() }}.item"
                >
                    @if (filled($itemLabel))
                        <span>
                            {{ $itemLabel }}
                            @if ($hasItemNumbers)
                                {{ $loop->iteration }}
                            @endif
                        </span>
                    @else
                        <span>
                            {{ $loop->iteration }}
                        </span>
                    @endif
                    @if ($moveUpActionIsVisible || $moveDownActionIsVisible || $cloneActionIsVisible || $deleteActionIsVisible || $visibleExtraItemActions)
                        <span x-on:click.stop style="display: flex;align-items: center;gap: 0.25rem">
                            @foreach ($visibleExtraItemActions as $extraItemAction)
                                {{ $extraItemAction(['item' => $itemKey]) }}
                            @endforeach

                            @if ($cloneActionIsVisible)
                                {{ $cloneAction }}
                            @endif

                            @if ($deleteActionIsVisible && $itemKey !== $getDefaultLocale())
                                {{ $deleteAction }}
                            @endif
                        </span>
                    @endif
                </x-filament::tabs.item>
            @endforeach
            @if($isAddable)
                <x-filament::tabs.item tag="div">
                    {{ $addAction }}
                </x-filament::tabs.item>
            @endif
        </x-filament::tabs>

        @forelse ($items as $itemKey => $item)
            <div
                wire:ignore.self
                wire:key="{{ $item->getLivewireKey() }}.item"
                x-bind:class="{'fi-active': activeTab === @js($itemKey)}"
                class="fi-sc-tabs-tab"
                role="tabpanel"
                x-show="activeTab === @js($itemKey)"
                x-cloak
            >
                {{ $item }}
            </div>
        @empty
            <div class="fi-sc-tabs-tab fi-active">
                <x-filament::empty-state icon="heroicon-o-square-2-stack">
                    <x-slot name="heading">
                        {{ __('filament-translatable::translatable.empty', ['name' => $getName()]) }}
                    </x-slot>
                </x-filament::empty-state>
            </div>
        @endforelse
    </div>
</x-dynamic-component>
