<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretnote extends Model
{
    use HasFactory;
    protected $fillable =['link_token','link','notes','expired'];
}
