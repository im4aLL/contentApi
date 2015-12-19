<?php

// admin root
Breadcrumbs::register('admin.root', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin.root'));
});

// admin menus
Breadcrumbs::register('admin.menu', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.root');
    $breadcrumbs->push('Menus', route('admin.menu'));
});

Breadcrumbs::register('admin.menu.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.menu');
    $breadcrumbs->push('Add menu', route('admin.menu.create'));
});

Breadcrumbs::register('admin.menu.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.menu');
    $breadcrumbs->push('Edit menu', route('admin.menu.edit'));
});

// admin category
Breadcrumbs::register('admin.cat', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.root');
    $breadcrumbs->push('Categories', route('admin.cat'));
});

Breadcrumbs::register('admin.cat.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.cat');
    $breadcrumbs->push('Add category', route('admin.cat.create'));
});

Breadcrumbs::register('admin.cat.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.cat');
    $breadcrumbs->push('Edit category', route('admin.cat.edit'));
});
