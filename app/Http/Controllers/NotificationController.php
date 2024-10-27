<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth('doctor')->user()->notifications()->find($id);
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        return back();
    }

}
