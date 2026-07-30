<?php

use App\Livewire\ContactForm;
use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\ContactMessageReceived;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

test('a visitor can send a message to the shop', function () {
    Notification::fake();

    $admin = User::factory()->admin()->create();
    User::factory()->create(); // A customer must not be notified.

    Livewire::test(ContactForm::class)
        ->set('name', 'Grace Halloran')
        ->set('email', 'grace@example.com')
        ->set('phone', '(313) 555-0188')
        ->set('service', 'Custom orthotics and insoles')
        ->set('message', 'I need insoles for my work clogs, I am on my feet all day.')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('sent', true)
        ->assertSet('message', '');

    $stored = ContactMessage::sole();

    expect($stored->name)->toBe('Grace Halloran')
        ->and($stored->email)->toBe('grace@example.com')
        ->and($stored->service)->toBe('Custom orthotics and insoles')
        ->and($stored->handled_at)->toBeNull();

    Notification::assertSentTo($admin, ContactMessageReceived::class);
    Notification::assertSentToTimes($admin, ContactMessageReceived::class, 1);
    Notification::assertCount(1);
});

test('the message is stored even when no administrator exists', function () {
    Notification::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'Lonely Visitor')
        ->set('email', 'visitor@example.com')
        ->set('message', 'Do you repair hiking boots?')
        ->call('send')
        ->assertHasNoErrors();

    expect(ContactMessage::count())->toBe(1);
});

test('the contact form validates its fields', function () {
    Livewire::test(ContactForm::class)
        ->set('name', '')
        ->set('email', 'not-an-email')
        ->set('message', 'too short')
        ->call('send')
        ->assertHasErrors(['name', 'email', 'message'])
        ->assertSet('sent', false);

    expect(ContactMessage::count())->toBe(0);
});

test('a visitor cannot flood the shop with messages', function () {
    Notification::fake();
    RateLimiter::clear('contact-form:127.0.0.1');

    $component = Livewire::test(ContactForm::class);

    foreach (range(1, ContactForm::MAX_PER_HOUR) as $attempt) {
        $component
            ->set('name', 'Spammer')
            ->set('email', 'spam@example.com')
            ->set('message', "Message number {$attempt} with enough characters.")
            ->call('send')
            ->assertHasNoErrors()
            ->call('sendAnother');
    }

    $component
        ->set('name', 'Spammer')
        ->set('email', 'spam@example.com')
        ->set('message', 'One message too many for this hour.')
        ->call('send')
        ->assertHasErrors('message');

    expect(ContactMessage::count())->toBe(ContactForm::MAX_PER_HOUR);
});

test('a service card can preselect the service', function () {
    Livewire::test(ContactForm::class)
        ->call('selectService', 'Premium shoe restoration')
        ->assertSet('service', 'Premium shoe restoration')
        ->call('selectService', 'Made up service')
        ->assertSet('service', 'Premium shoe restoration');
});
