<?php

// admin root
Breadcrumbs::register('admin::root', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin::root'));
});

// admin menus
Breadcrumbs::register('admin::menus', function($breadcrumbs)
{
    $breadcrumbs->parent('admin::root');
    $breadcrumbs->push('Menus', route('admin::menus'));
});
