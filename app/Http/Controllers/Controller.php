<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function getDataEntryUserId(): int
    {
        if (session()->has('admin_data_entry_user_id')) {
            return (int) session('admin_data_entry_user_id');
        }

        return Auth::id();
    }

    protected function isAdminDataEntry(): bool
    {
        return session()->has('admin_data_entry_user_id');
    }
}
