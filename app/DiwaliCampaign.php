<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiwaliCampaign extends Model
{
    public $table = 'diwalicampaign';
    public $fillable = ['name','email','phone','address1','address2','pin','invoice_no','invoice_image','model_no'];
}
