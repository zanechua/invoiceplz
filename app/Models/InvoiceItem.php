<?php

namespace App\Models;

use App\Library\Poowf\Unicorn;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceItem extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes, HasFactory, CascadeSoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoice_items';

    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = Unicorn::stripUnwantedTagsAndAttrs($description, ENT_COMPAT, 'UTF-8');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id');
    }

    public function moneyFormatPrice()
    {
        $amount = new \NumberFormatter('en_US.UTF-8', \NumberFormatter::PATTERN_DECIMAL, '* #####.00 ;(* #####.00)');

        return $amount->format($this->price);
    }

    public function modified($name, $description, $quantity, $price)
    {
        $ismodified = false;
        $original = $this;
        $price = number_format($price, 3, '.', '');

        if ($original->name != $name) {
            $ismodified = true;
        }

        if ($original->description != $description) {
            $ismodified = true;
        }

        if ($original->quantity != $quantity) {
            $ismodified = true;
        }

        if ($original->price != $price) {
            $ismodified = true;
        }

        return $ismodified;
    }

    public function scopeDuplicateCheck($query, $price, $quantity, $invoiceid)
    {
        return $query
            ->where('price', $price)
            ->where('quantity', $quantity)
            ->where('invoice_id', $invoiceid);
    }
}
