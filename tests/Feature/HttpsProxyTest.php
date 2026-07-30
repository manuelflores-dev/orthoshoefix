<?php

use App\Models\User;

test('livewire urls stay on https behind a tls terminating proxy', function () {
    $this->actingAs(User::factory()->create());

    $html = $this->get(route('orders.create'), ['X-Forwarded-Proto' => 'https'])
        ->assertOk()
        ->getContent();

    // Livewire prints absolute URLs, so any http:// one is blocked as mixed content.
    expect($html)->toContain('data-update-uri="https://')
        ->and($html)->not->toContain('data-update-uri="http://');
});

test('the forwarded protocol is honoured for generated urls', function () {
    $this->get('/', ['X-Forwarded-Proto' => 'https'])->assertOk();

    expect(request()->isSecure())->toBeTrue()
        ->and(route('register'))->toStartWith('https://');
});
