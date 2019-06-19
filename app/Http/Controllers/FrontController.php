<?php

namespace App\Http\Controllers;

use App\Entity\Book;
use App\Entity\Card\Card;
use App\Entity\Card\Operation;
use App\User;

class BookController extends Controller
{
    public function create()
    {

        $user = User::find(1);
        $user->addCard([
            'number' => 1112,
            'amount' => 200.35,
        ]);
//        Card::create([
//            'number' => 1112,
//            'amount' => 200.35,
//        ]);
        
        dump('fdasdfd'); die;

        $data = [
            ['name' => 'First', 'author' => 'Vayn', 'tags' => 't1'],
            ['name' => 'Second', 'author' => 'Esgras', 'tags' => 't2'],
            ['name' => 'Third', 'author' => 'Uzek', 'tags' => 't3'],
        ];

        foreach ($data as $elem) {
            Book::create($elem);
        }

        die('check');
    }

    public function check()
    {
        $user = User::find(1);
        dump($user->cards()->getResults()->first()->id); die;
        
        $cards = $user->cards();
        dump($cards->getResults()); die;
    }

    public function add($id)
    {
        $card = Card::findOrFail($id);

        return view('card.add', compact('card'));
    }

    public function addHandle($id)
    {
        $card = Card::findOrFail($id);
        $amount = request('amount');
        $card->addAmount($amount)
             ->addOperation(['type' => Operation::TYPE_RECHARGE,
                 'description' => $amount . ' was put on your card ' . $card->number
             ])->save();

        session()->flash('success', 'Your balance has been changed');

        return back();
    }

    public function sub($id)
    {
        $card = Card::findOrFail($id);

        return view('card.sub', compact('card'));
    }

    public function subHandle($id)
    {
        $card = Card::findOrFail($id);
        $amount = request('amount');
        if ($card->amount < $amount) {
            return back()->withErrors(['amount' => 'You don\'t have enough money']);
        }
        $card->addAmount(-1 * $amount)
             ->addOperation([
                'type' => Operation::TYPE_WITHDRAW,
                'description' => $amount . ' was withdrawn from your card '. $card->number
             ])->save();

        session()->flash('success', 'Your balance has been changed');

        return back();
    }

    public function transfer()
    {
        return view('card.transfer', ['cards' => Card::all()]);
    }

    public function transferHandle()
    {
        $sourceCard = Card::find(request('source_card'));
        if (!$sourceCard) return back()->withErrors(['source_card' => 'Source card doesn\'t exist']);

        $destinationCard = Card::where('number', request('destination_card'))->first();
        if (!$destinationCard) return back()->withErrors(['destination_card' => 'Destination card doesn\'t exist']);

        if ($destinationCard == $sourceCard) return back()->withErrors(['amount' => 'Choose another card']);

        $amount = request('amount');
        if ($sourceCard->amount < $amount) {
            return back()->withErrors(['amount' => 'You don\'t have enough money']);
        }

        $sourceCard->addAmount(-1 * $amount)
            ->addOperation([
                'type' => Operation::TYPE_TRANSFER,
                'description' => $amount . ' was moved to card ' . $destinationCard->number
            ])->save();
        $destinationCard->addAmount($amount)
            ->addOperation([
                'type' => Operation::TYPE_TRANSFER,
                'description' => $amount . ' was received from card ' . $sourceCard->number
            ])->save();

        session()->flash('success', 'You have transfer money to card ' . $destinationCard->number);

        return back();
    }

    public function history($id)
    {
        $card = Card::findOrFail($id);
        
        return view('card.history', compact('card'));
    }

    public function vue()
    {

//        RunUser::where('user_id',$id)->leftjoin('runs','runs.id','=','run_user.run_id')->first();
//
//        Product::from('products as p')
//            ->join('product_category as pc','p.id','=','pc.product_id')
//            ->select('p.*')
//            ->where('p.active',1)
//            ->whereIn('pc.category_id', ['223', '15'])
//            ->get();

        $cards = Card::where('owner_id', auth()->user()->id)
                    ->select('id', 'number', 'amount', 'created_at', 'pin')
                    ->orderBy('created_at', 'desc')
                    ->with('operations')
                    ->get();

//        $cards = Card::from('cards ac c')
//            ->leftJoin('operations op', 'op.card_id', '=', 'c.id')
//            ->where('owner_id', \Auth::user()->id)
//            ->get();

        return view('vue', [
//            'cards' => Card::where('owner_id', \Auth::user()->id)
//                ->orderBy('created_at', 'DESC')->get()
            'cards' => $cards
        ]);
    }
}