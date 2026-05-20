<?php

use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Repositories\AdminRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an admin via repository', function () {
    $repo = new AdminRepository;
    $admin = $repo->create([
        'uuid' => \Illuminate\Support\Str::uuid()->toString(),
        'name' => 'Test Admin',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'status' => 'active',
        'language' => 'en',
        'timezone' => 'UTC',
    ]);

    expect($admin)->toBeInstanceOf(Admin::class)
        ->and($admin->email)->toBe('test@example.com');
});

it('paginates admins', function () {
    Admin::factory()->count(5)->create();
    $repo = new AdminRepository;
    $result = $repo->paginate(request());

    expect($result->total())->toBe(5);
});
