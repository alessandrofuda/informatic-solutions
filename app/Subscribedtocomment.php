<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribedtocomment extends Model
{
    protected $guarded = [];



    //relationships

    //ogni Subscriber appartiene a molti Posts
    public function post() {
    	return $this->belongsTo('App\Post');  //verificare la correttezza ???  ???? o belongsToMany ??????????
    }


}

// http://www.html.it/pag/55383/eloquent-e-le-relazioni/
// entità principale (modello "Forte") --> App\Post --> necessita del metodo hasOne
// modello "debole" (presenta, tra le sue colonne, il riferimento al modello “forte” [post_id]) --> App\Subscribedtocomment --> necessita del metodo belongsTo
// 