<?php

use App\Enums\UserRole;
use App\Livewire\Admin\Customers\Index;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('an administrator can register a customer with a generated password', function () {
    $this->actingAs(User::factory()->admin()->create());

    $component = Livewire::test(Index::class)
        ->set('name', 'Marta Reyes')
        ->set('email', 'marta@example.com')
        ->set('phone', '3135550199')
        ->call('createCustomer')
        ->assertHasNoErrors();

    $customer = User::whereEmail('marta@example.com')->sole();

    expect($customer->role)->toBe(UserRole::Client)
        ->and($customer->phone)->toBe('3135550199')
        ->and($customer->email_verified_at)->not->toBeNull();

    // The generated password is shown once so the shop can hand it over.
    $temporary = $component->get('temporaryPassword');

    expect($temporary)->not->toBeNull()
        ->and(Hash::check($temporary, $customer->password))->toBeTrue();
});

test('an administrator can choose the password of a customer', function () {
    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(Index::class)
        ->set('generatePassword', false)
        ->set('name', 'Owen Blake')
        ->set('email', 'owen@example.com')
        ->set('password', 'shoe-repair-2026')
        ->call('createCustomer')
        ->assertHasNoErrors()
        ->assertSet('temporaryPassword', null);

    expect(Hash::check('shoe-repair-2026', User::whereEmail('owen@example.com')->sole()->password))->toBeTrue();
});

test('customers are registered without a phone number', function () {
    $this->actingAs(User::factory()->admin()->create());

    Livewire::test(Index::class)
        ->set('name', 'No Phone')
        ->set('email', 'nophone@example.com')
        ->set('phone', '')
        ->call('createCustomer')
        ->assertHasNoErrors();

    expect(User::whereEmail('nophone@example.com')->sole()->phone)->toBeNull();
});

test('duplicated emails are rejected', function () {
    $this->actingAs(User::factory()->admin()->create());

    User::factory()->create(['email' => 'taken@example.com']);

    Livewire::test(Index::class)
        ->set('name', 'Copy Cat')
        ->set('email', 'taken@example.com')
        ->call('createCustomer')
        ->assertHasErrors(['email']);
});

test('the customer list only shows customers and can be searched', function () {
    $admin = User::factory()->admin()->create(['name' => 'Shop Owner']);
    $ada = User::factory()->create(['name' => 'Ada Kowalski']);
    $ben = User::factory()->create(['name' => 'Ben Ortiz']);

    $this->actingAs($admin);

    Livewire::test(Index::class)
        ->assertSee($ada->name)
        ->assertSee($ben->name)
        ->assertDontSee('Shop Owner')
        ->set('search', 'Kowalski')
        ->assertSee($ada->name)
        ->assertDontSee($ben->name);
});
