<?php

namespace App\Entity\Card;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['number', 'amount', 'owner_id', 'pin'];

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function operations()
    {
        return $this->hasMany('App\Entity\Card\Operation', 'card_id')->orderBy('created_at', 'desc');
    }

    public function addAmount($amount)
    {
        $this->amount = $this->amount + (float) $amount;
        return $this;
    }

    public function addOperation($data)
    {
        $this->operations()->create([
            'type' => $data['type'],
            'description' => $data['description'],
            'card_id' => $this->id
        ]);

        return $this;
    }

}