<?php

namespace App\Http\Controllers;

use App\Entity\Card\Card;

class FrontController extends Controller
{
    public function account()
    {
        $cards = Card::where('owner_id', auth()->user()->id)
                    ->select('id', 'number', 'amount', 'created_at', 'pin')
                    ->orderBy('created_at', 'desc')
                    ->with('operations')
                    ->get();

        return view('front.account', [
            'cards' => $cards
        ]);
    }

    public function homepage()
    {
        return view('front.home');
    }
}