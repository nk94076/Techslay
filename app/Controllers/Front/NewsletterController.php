<?php

declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;
use App\Models\NewsletterSubscriber;

final class NewsletterController extends Controller
{
    public function subscribe(): void
    {
        $email = (string) $this->input('email', '');

        $validator = $this->validate(['email' => $email], ['email' => 'required|email|max:150']);

        if ($validator->fails()) {
            Session::flash('error', 'Please enter a valid email address.');
            $this->back();

            return;
        }

        $existing = NewsletterSubscriber::firstWhere(['email' => $email]);

        if ($existing === null) {
            NewsletterSubscriber::create(['email' => $email]);
        } elseif ($existing['status'] !== 'subscribed') {
            NewsletterSubscriber::update((int) $existing['id'], ['status' => 'subscribed']);
        }

        Session::flash('success', 'You are subscribed! Thanks for joining.');
        $this->back();
    }
}
