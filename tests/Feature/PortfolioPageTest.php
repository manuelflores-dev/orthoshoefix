<?php

use App\Enums\PortfolioLayout;
use App\Livewire\Home;
use App\Models\PortfolioItem;
use Livewire\Livewire;

test('the public portfolio page only shows published cases', function () {
    $published = PortfolioItem::factory()->withPhotos()->create(['title' => 'Published case']);
    $draft = PortfolioItem::factory()->withPhotos()->draft()->create(['title' => 'Draft case']);
    $empty = PortfolioItem::factory()->create(['title' => 'Case with no photos']);

    $this->get(route('portfolio'))
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title)
        ->assertDontSee($empty->title);
});

test('the portfolio page invites visitors when there is nothing published yet', function () {
    $this->get(route('portfolio'))->assertOk()->assertSee('Coming soon');
});

test('the landing page features published cases and links to the full portfolio', function () {
    PortfolioItem::factory()->withPhotos()->create(['title' => 'Featured case']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Featured case')
        ->assertSee(route('portfolio'));
});

test('the landing page features at most three cases', function () {
    PortfolioItem::factory(5)->withPhotos()->sequence(
        ['title' => 'Case one', 'sort_order' => 1],
        ['title' => 'Case two', 'sort_order' => 2],
        ['title' => 'Case three', 'sort_order' => 3],
        ['title' => 'Case four', 'sort_order' => 4],
        ['title' => 'Case five', 'sort_order' => 5],
    )->create();

    $component = Livewire::test(Home::class);

    expect($component->get('portfolioItems'))->toHaveCount(Home::FEATURED_CASES);

    $component->assertSee('Case three')->assertDontSee('Case four');
});

test('process cases render full width and before after cases in the grid', function () {
    $process = PortfolioItem::factory()->withPhotos(4)->create([
        'title' => 'Process case',
        'layout' => PortfolioLayout::Process,
        'sort_order' => 1,
    ]);

    $beforeAfter = PortfolioItem::factory()->withPhotos()->create([
        'title' => 'Split case',
        'layout' => PortfolioLayout::BeforeAfter,
        'sort_order' => 2,
    ]);

    $component = Livewire::test(Home::class);

    expect($component->get('portfolioWideItems')->pluck('id')->all())->toBe([$process->id])
        ->and($component->get('portfolioGridItems')->pluck('id')->all())->toBe([$beforeAfter->id]);
});
