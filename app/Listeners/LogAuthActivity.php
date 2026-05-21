<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;

class LogAuthActivity
{
    public function handleLogin(Login $event): void
    {
        ActivityLog::create([
            'user_id'     => $event->user->id,
            'action'      => 'login',
            'module'      => 'Auth',
            'description' => "{$event->user->name} login",
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }

    public function handleLogout(Logout $event): void
    {
        ActivityLog::create([
            'user_id'     => $event->user->id,
            'action'      => 'logout',
            'module'      => 'Auth',
            'description' => "{$event->user->name} logout",
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
