<?php

use App\Enums\PortfolioLayout;
use App\Livewire\Admin\Portfolio\Edit;
use App\Livewire\Admin\Portfolio\Index;
use App\Models\PortfolioItem;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('customers cannot reach the portfolio manager', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.portfolio.index'))->assertForbidden();
    $this->get(route('admin.portfolio.create'))->assertForbidden();
});

test('an administrator can create a case with photos', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    Livewire::test(Edit::class)
        ->set('title', 'Boots — Rocker Sole')
        ->set('summary', 'Rocker sole added to relieve forefoot pressure.')
        ->set('layout', PortfolioLayout::BeforeAfter->value)
        ->set('badge', 'Real Case')
        ->set('tagList', 'Forefoot Relief, Rocker Sole , Rx Required')
        ->set('is_published', true)
        ->set('uploads', [
            UploadedFile::fake()->image('before.jpg'),
            UploadedFile::fake()->image('after.jpg'),
        ])
        ->call('save')
        ->assertHasNoErrors();

    $item = PortfolioItem::sole();

    expect($item->title)->toBe('Boots — Rocker Sole')
        ->and($item->layout)->toBe(PortfolioLayout::BeforeAfter)
        ->and($item->is_published)->toBeTrue()
        ->and($item->created_by)->toBe($admin->id)
        ->and($item->sort_order)->toBe(1)
        ->and($item->tags)->toBe(['Forefoot Relief', 'Rocker Sole', 'Rx Required'])
        ->and($item->photos)->toHaveCount(2);

    Storage::disk('public')->assertExists($item->photos->first()->path);
});

test('a case without photos cannot be published', function () {
    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(Edit::class)
        ->set('title', 'Empty case')
        ->set('is_published', true)
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('is_published', false);

    expect(PortfolioItem::sole()->is_published)->toBeFalse();
});

test('an administrator can caption, reorder and remove photos', function () {
    Storage::fake('public');

    $this->actingAs(User::factory()->admin()->create());

    $component = Livewire::test(Edit::class)
        ->set('title', 'Diadora — Process')
        ->set('layout', PortfolioLayout::Process->value)
        ->set('uploads', [
            UploadedFile::fake()->image('one.jpg'),
            UploadedFile::fake()->image('two.jpg'),
        ])
        ->call('save');

    $item = PortfolioItem::sole();
    [$first, $second] = $item->photos->all();

    // Caption the first photo.
    $component
        ->set("photoDetails.{$first->id}.label", 'Original')
        ->set("photoDetails.{$first->id}.caption", 'No modification')
        ->call('savePhotoDetails', $first->id);

    expect($first->refresh()->label)->toBe('Original')
        ->and($first->caption)->toBe('No modification');

    // Send it down one position.
    $component->call('movePhoto', $first->id, 'down');

    expect($item->refresh()->photos->pluck('id')->all())->toBe([$second->id, $first->id]);

    // And drop it.
    $component->call('deletePhoto', $first->id);

    expect($item->refresh()->photos->pluck('id')->all())->toBe([$second->id]);
    Storage::disk('public')->assertMissing($first->path);
});

test('an administrator can publish, reorder and delete cases', function () {
    $this->actingAs(User::factory()->admin()->create());

    $first = PortfolioItem::factory()->withPhotos()->draft()->create(['sort_order' => 1]);
    $second = PortfolioItem::factory()->withPhotos()->create(['sort_order' => 2]);

    $component = Livewire::test(Index::class);

    $component->call('togglePublished', $first->id);
    expect($first->refresh()->is_published)->toBeTrue();

    $component->call('togglePublished', $first->id);
    expect($first->refresh()->is_published)->toBeFalse();

    $component->call('move', $second->id, 'up');
    expect($second->refresh()->sort_order)->toBe(1)
        ->and($first->refresh()->sort_order)->toBe(2);

    $component->call('delete', $second->id);
    expect(PortfolioItem::count())->toBe(1);
});

test('an empty case cannot be published from the list either', function () {
    $this->actingAs(User::factory()->admin()->create());

    $item = PortfolioItem::factory()->draft()->create();

    Livewire::test(Index::class)->call('togglePublished', $item->id);

    expect($item->refresh()->is_published)->toBeFalse();
});
