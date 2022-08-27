<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'pengajuan_ormawa';
    public $timestamps = true;
    public $remember_token = false;
    protected $guarded = [];

    public function ormawa()
    {
        return $this->belongsTo('App\Models\Ormawa', 'id_ormawa');
    }

    public function proposal_parent()
    {
        return $this->belongsTo('App\Models\Proposal', 'id_parent');
    }
}
