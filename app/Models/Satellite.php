<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Satellite extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'satellites';
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
    public function timeprofile(){
        return $this->belongsTo('App\Models\Clientprofile', 'timeprofile_id');
    }

    public function dataprofile(){
        return $this->belongsTo('App\Models\Clientprofile', 'dataprofile_id');
    }

    public function clientprofiles(){
        return $this->hasMany('App\Models\Clientprofile');
    } 

    public function chargeprofile(){
        return $this->belongsTo('App\Models\Chargeprofile', 'chargeprofile_id');
    }    
    public function pinprofile(){
        return $this->belongsTo('App\Models\Pinprofile', 'pinprofile_id');
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
