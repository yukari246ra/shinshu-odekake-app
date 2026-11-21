<?php

test('guests can visit the home page', function () {
    $this->get('/')->assertStatus(200);
});

test('authenticated users can visit the home page', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $this->get('/')->assertStatus(200);
});