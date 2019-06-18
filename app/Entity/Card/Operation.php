<?php

namespace App\Entity\Card;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    CONST TYPE_CREATE = 0;
    CONST TYPE_RECHARGE = 1;
    CONST TYPE_WITHDRAW = 2;
    CONST TYPE_TRANSFER = 3;

    protected $fillable = ['type', 'description', 'card_id'];
}