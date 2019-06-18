<?php

namespace App\Http\Controllers\Api;

use App\Entity\Book;
use App\Entity\Card\Card;
use App\Http\Controllers\Controller;
use App\Http\Repository\BookRepository;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    public function store()
    {
//        dump(\Auth::user()); die;
        $value = !empty($_GET['dashboard_or_event']) && in_array($_GET['dashboard_or_event'], $options) ?
            object(['id' => $_GET['dashboard_or_event'], 'name' => array_search($_GET['dashboard_or_event'], $options)]) : null;

        _D($value); die;


        return Card::create([
            'owner_id' => \Auth::user()->id,
            'number' => mt_rand(pow(10, 15), pow(10, 16) - 1),
            'amount' => 0,
            'pin' => mt_rand(1000, 9999)
        ]);
    }
}