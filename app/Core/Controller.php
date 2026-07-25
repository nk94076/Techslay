<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = [], ?string $layout = null): void
    {
        View::output($view, $data, $layout);
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    protected function redirect(string $path, int $status = 302): void
    {
        header('Location: ' . View::url($path), true, $status);
        exit;
    }

    protected function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? View::url('/');
        header('Location: ' . $referer);
        exit;
    }

    protected function abort(int $status, string $message = ''): void
    {
        http_response_code($status);
        echo $message !== '' ? $message : 'Error ' . $status;
        exit;
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        return Request::input($key, $default);
    }

    protected function validate(array $data, array $rules): Validator
    {
        return new Validator($data, $rules);
    }

    protected function requireCsrf(): void
    {
        if (!Csrf::verify(Request::input('_csrf_token'))) {
            $this->abort(419, 'Invalid or expired security token. Please refresh and try again.');
        }
    }
}
