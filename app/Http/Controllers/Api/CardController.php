<?php

namespace App\Http\Controllers\Api;

use App\Entity\Book;
use App\Entity\Card\Card;
use App\Entity\Card\Operation;
use App\Http\Controllers\Controller;
use App\Http\Repository\BookRepository;
use App\Http\Requests\BookRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CardController extends Controller
{
    public function store()
    {
        return Card::create([
            'owner_id' => \Auth::user()->id,
            'number' => mt_rand(pow(10, 15), pow(10, 16) - 1),
            'amount' => 0.0,
            'pin' => mt_rand(1000, 9999)
        ]);
    }

    public function addMoney()
    {
        $card = Card::find(request('id'));
        if (!$card) throw new HttpException(404, 'Card not found');

        $amount = request('amount');
        if ($amount < 0) throw new HttpException(400, 'Wrong money amount');

        $card->addAmount($amount)
             ->addOperation(['type' => Operation::TYPE_RECHARGE,
                'description' => $amount . ' was put on your card ' . $card->number
             ])->save();

        return new JsonResponse(['success' => true, 'operation' => $card->operations()->getResults()->first()]);
    }

    public function withdrawMoney()
    {
        $card = Card::find(request('id'));
        if (!$card) throw new HttpException(404, 'Card not found');

        $amount = request('amount');
        if ($amount > $card->amount) return new JsonResponse(['error' => 'Wrong money amount']);

        $card->addAmount(-1 * $amount)
            ->addOperation([
                'type' => Operation::TYPE_WITHDRAW,
                'description' => $amount . ' was withdrawn from your card '. $card->number
            ])->save();
        return new JsonResponse(['success' => true, 'operation' => $card->operations()->getResults()->first()]);
    }

    public function moneyTransfer()
    {
        $sourceCard = Card::where('number', request('source'))->first();
        if (!$sourceCard) return new JsonResponse(['error' => 'Source card not found']);

        $destinationCard = Card::where('number', request('destination'))->first();
        if (!$destinationCard) return new JsonResponse(['error' => 'Destination card not found']);

        if ($destinationCard == $sourceCard) return new JsonResponse(['error' => 'Wrong destination card']);

        $amount = request('amount');
        if ($sourceCard->amount < $amount) return new JsonResponse(['error' => 'You don\'t have enough money']);

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

        return new JsonResponse(['success' => true,
            'sourceCardOperation' => $sourceCard->operations()->getResults()->first(),
            'destinationCardOperation' => $destinationCard->operations()->getResults()->first(),
        ]);
    }

    public function checkPin()
    {
        $card = Card::where('number', request('number'))->first();
        if (!$card) return new JsonResponse(['error' => 'Card not found']);

        return $card->pin == request('code')  ? new JsonResponse(['success' => true])
            : new JsonResponse(['error' => 'Wrong pin code']);
    }

    public function changePinCode()
    {
        $card = Card::find(request('id'));
        if (!$card) return new JsonResponse(['error' => 'Card not found']);

        $card->pin = mt_rand(1000, 9999);
        $card->save();

        return new JsonResponse(['success' => true, 'pin' => $card->pin]);
    }

}