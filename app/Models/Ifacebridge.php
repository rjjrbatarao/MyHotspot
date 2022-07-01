<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Ifacebridge extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'ifacebridges';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function bridgeethernets(){
        return $this->belongstoMany('App\Models\Ifaceethernet','bridgeethernets');
    }
    public function bridgevlans(){
        return $this->belongstoMany('App\Models\Ifacevlan','bridgevlans');
    }    
    public function bridgewlans(){
        return $this->belongstoMany('App\Models\Ifacewlan','bridgewlans');
    }
    public function bridgetuns(){
        return $this->belongstoMany('App\Models\Ifacetun','bridgetuns');
    }
    public function bridgebondings(){
        return $this->belongstoMany('App\Models\Ifacebonding','bridgebondings');
    }            
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
