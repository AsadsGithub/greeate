<?php

namespace Greeate\Greeate\Support;

class GreeateModuleRegistry
{
    public static function get(string $module): ?array
    {
        return self::all()[$module] ?? null;
    }

    public static function all(): array
    {
        return [
            'admins' => [
                'permission' => 'admins.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'email', 'label' => 'Email'],
                    ['key' => 'phone', 'label' => 'Phone'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                    ['key' => 'roles', 'label' => 'Role', 'type' => 'roles'],
                    ['key' => 'created_at', 'label' => 'Created', 'type' => 'date'],
                ],
                'fields' => [
                    ['name' => 'name', 'type' => 'text', 'label' => 'Name', 'required' => true],
                    ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'required' => true],
                    ['name' => 'phone', 'type' => 'text', 'label' => 'Phone'],
                    ['name' => 'password', 'type' => 'password', 'label' => 'Password', 'required' => true],
                    ['name' => 'role', 'type' => 'select', 'label' => 'Role', 'options' => 'roles'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']],
                ],
                'editFields' => [
                    ['name' => 'name', 'type' => 'text', 'label' => 'Name', 'required' => true],
                    ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'required' => true],
                    ['name' => 'phone', 'type' => 'text', 'label' => 'Phone'],
                    ['name' => 'password', 'type' => 'password', 'label' => 'Password (leave blank to keep)'],
                    ['name' => 'role', 'type' => 'select', 'label' => 'Role', 'options' => 'roles'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']],
                ],
            ],
            'roles' => [
                'permission' => 'roles.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'alias', 'label' => 'Alias'],
                    ['key' => 'created_at', 'label' => 'Created', 'type' => 'date'],
                ],
                'fields' => [
                    ['name' => 'name', 'type' => 'text', 'label' => 'Name', 'required' => true],
                    ['name' => 'alias', 'type' => 'text', 'label' => 'Alias'],
                ],
            ],
            'banners' => [
                'permission' => 'banners.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                    ['key' => 'sort_order', 'label' => 'Order'],
                ],
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'label' => 'Title', 'required' => true],
                    ['name' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
                    ['name' => 'link', 'type' => 'text', 'label' => 'Link'],
                    ['name' => 'sort_order', 'type' => 'number', 'label' => 'Sort order'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']],
                ],
            ],
            'faqs' => [
                'permission' => 'faqs.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'question', 'label' => 'Question'],
                    ['key' => 'category', 'label' => 'Category'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ],
                'fields' => [
                    ['name' => 'question', 'type' => 'text', 'label' => 'Question', 'required' => true],
                    ['name' => 'answer', 'type' => 'textarea', 'label' => 'Answer', 'required' => true],
                    ['name' => 'category', 'type' => 'text', 'label' => 'Category'],
                    ['name' => 'sort_order', 'type' => 'number', 'label' => 'Sort order'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']],
                ],
            ],
            'languages' => [
                'permission' => 'languages.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'code', 'label' => 'Code'],
                    ['key' => 'is_default', 'label' => 'Default', 'type' => 'boolean'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ],
                'fields' => [
                    ['name' => 'name', 'type' => 'text', 'label' => 'Name', 'required' => true],
                    ['name' => 'code', 'type' => 'text', 'label' => 'Code', 'required' => true],
                    ['name' => 'direction', 'type' => 'select', 'label' => 'Direction', 'options' => ['ltr' => 'LTR', 'rtl' => 'RTL']],
                    ['name' => 'is_default', 'type' => 'checkbox', 'label' => 'Default language'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive']],
                ],
            ],
            'static-pages' => [
                'permission' => 'static-pages.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'slug', 'label' => 'Slug'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                ],
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'label' => 'Title', 'required' => true],
                    ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'required' => true],
                    ['name' => 'content', 'type' => 'textarea', 'label' => 'Content'],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['published' => 'Published', 'draft' => 'Draft']],
                ],
            ],
            'contact-messages' => [
                'permission' => 'contact-messages.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'email', 'label' => 'Email'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                    ['key' => 'created_at', 'label' => 'Date', 'type' => 'date'],
                ],
                'fields' => [],
                'readonly' => true,
            ],
            'permissions' => [
                'permission' => 'permissions.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'guard_name', 'label' => 'Guard'],
                ],
                'fields' => [],
                'readonly' => true,
            ],
            'broadcasts' => [
                'permission' => 'broadcasts.view',
                'columns' => [
                    ['key' => 'id', 'label' => 'ID'],
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'status', 'label' => 'Status', 'type' => 'status'],
                    ['key' => 'scheduled_at', 'label' => 'Scheduled', 'type' => 'date'],
                ],
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'label' => 'Title', 'required' => true],
                    ['name' => 'body', 'type' => 'textarea', 'label' => 'Message', 'required' => true],
                    ['name' => 'status', 'type' => 'select', 'label' => 'Status', 'options' => ['draft' => 'Draft', 'scheduled' => 'Scheduled', 'sent' => 'Sent']],
                ],
            ],
        ];
    }

    public static function urlSegment(string $module): string
    {
        return str_replace('_', '-', $module);
    }
}
