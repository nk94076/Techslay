<?php

declare(strict_types=1);

use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\MediaController;
use App\Controllers\Admin\MenuController;
use App\Controllers\Admin\PageController;
use App\Controllers\Admin\PageSectionController;
use App\Controllers\Admin\RoleController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\Admin\UserController;
use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\PermissionMiddleware;

/** @var Router $router */

$router->group('/admin', [], function (Router $router): void {
    // Guest-only auth screens
    $router->get('/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
    $router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class, CsrfMiddleware::class]);
    $router->get('/forgot-password', [AuthController::class, 'showForgotPassword'], [GuestMiddleware::class]);
    $router->post('/forgot-password', [AuthController::class, 'sendResetLink'], [GuestMiddleware::class, CsrfMiddleware::class]);
    $router->get('/reset-password/{token}', [AuthController::class, 'showResetPassword'], [GuestMiddleware::class]);
    $router->post('/reset-password/{token}', [AuthController::class, 'resetPassword'], [GuestMiddleware::class, CsrfMiddleware::class]);

    // Authenticated area
    $router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class, CsrfMiddleware::class]);
    $router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);

    // Media Manager
    $router->group('/media', [AuthMiddleware::class, PermissionMiddleware::require('media.manage')], function (Router $router): void {
        $router->get('', [MediaController::class, 'index']);
        $router->post('/upload', [MediaController::class, 'upload'], [CsrfMiddleware::class]);
        $router->post('/folders', [MediaController::class, 'createFolder'], [CsrfMiddleware::class]);
        $router->post('/{id}/update', [MediaController::class, 'updateMeta'], [CsrfMiddleware::class]);
        $router->post('/{id}/rename', [MediaController::class, 'rename'], [CsrfMiddleware::class]);
        $router->post('/{id}/delete', [MediaController::class, 'delete'], [CsrfMiddleware::class]);
        $router->post('/{id}/restore', [MediaController::class, 'restore'], [CsrfMiddleware::class]);
        $router->post('/{id}/force-delete', [MediaController::class, 'forceDelete'], [CsrfMiddleware::class]);
    });

    // Menus
    $router->group('/menus', [AuthMiddleware::class, PermissionMiddleware::require('menus.manage')], function (Router $router): void {
        $router->get('', [MenuController::class, 'index']);
        $router->post('/items', [MenuController::class, 'storeItem'], [CsrfMiddleware::class]);
        $router->post('/items/{id}', [MenuController::class, 'updateItem'], [CsrfMiddleware::class]);
        $router->post('/items/{id}/delete', [MenuController::class, 'deleteItem'], [CsrfMiddleware::class]);
        $router->post('/reorder', [MenuController::class, 'reorder'], [CsrfMiddleware::class]);
    });

    // Pages + section builder (homepage / footer / header content lives here)
    $router->group('/pages', [AuthMiddleware::class, PermissionMiddleware::require('pages.manage')], function (Router $router): void {
        $router->get('', [PageController::class, 'index']);
        $router->post('', [PageController::class, 'create'], [CsrfMiddleware::class]);
        $router->get('/{id}/edit', [PageController::class, 'edit']);
        $router->post('/{id}', [PageController::class, 'update'], [CsrfMiddleware::class]);
        $router->post('/{id}/duplicate', [PageController::class, 'duplicate'], [CsrfMiddleware::class]);
        $router->post('/{id}/delete', [PageController::class, 'delete'], [CsrfMiddleware::class]);
        $router->post('/{id}/restore', [PageController::class, 'restore'], [CsrfMiddleware::class]);

        $router->post('/{pageId}/sections', [PageSectionController::class, 'store'], [CsrfMiddleware::class]);
        $router->post('/{pageId}/sections/reorder', [PageSectionController::class, 'reorder'], [CsrfMiddleware::class]);
        $router->post('/{pageId}/sections/{id}', [PageSectionController::class, 'update'], [CsrfMiddleware::class]);
        $router->post('/{pageId}/sections/{id}/toggle', [PageSectionController::class, 'togglePublish'], [CsrfMiddleware::class]);
        $router->post('/{pageId}/sections/{id}/delete', [PageSectionController::class, 'delete'], [CsrfMiddleware::class]);
    });

    // Settings
    $router->group('/settings', [AuthMiddleware::class, PermissionMiddleware::require('settings.manage')], function (Router $router): void {
        $router->get('', [SettingsController::class, 'index']);
        $router->get('/{group}', [SettingsController::class, 'index']);
        $router->post('/{group}', [SettingsController::class, 'update'], [CsrfMiddleware::class]);
    });

    // Users
    $router->group('/users', [AuthMiddleware::class, PermissionMiddleware::require('users.manage')], function (Router $router): void {
        $router->get('', [UserController::class, 'index']);
        $router->post('', [UserController::class, 'create'], [CsrfMiddleware::class]);
        $router->post('/{id}', [UserController::class, 'update'], [CsrfMiddleware::class]);
        $router->post('/{id}/delete', [UserController::class, 'delete'], [CsrfMiddleware::class]);
    });

    // Roles & Permissions
    $router->group('/roles', [AuthMiddleware::class, PermissionMiddleware::require('roles.manage')], function (Router $router): void {
        $router->get('', [RoleController::class, 'index']);
        $router->post('', [RoleController::class, 'create'], [CsrfMiddleware::class]);
        $router->post('/{id}', [RoleController::class, 'update'], [CsrfMiddleware::class]);
        $router->post('/{id}/delete', [RoleController::class, 'delete'], [CsrfMiddleware::class]);
    });
});
