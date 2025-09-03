<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminConfirm;

class BadgeController extends Controller
{
    public function confirm(Request $request)
    {
        $uris = $request->input('uris', []);
        if (!is_array($uris)) {
            $uris = [$uris];
        }

        foreach ($uris as $uri) {
            if (!is_string($uri) || $uri === '') {
                continue;
            }
            AdminConfirm::updateOrCreate(['uri' => $uri], ['confirmed_at' => now()]);
        }

        return response()->json(['success' => true]);
    }
}


