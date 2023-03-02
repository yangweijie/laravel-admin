<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected  $table = 'todo';
    use HasFactory;

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    protected $guarded = [];

    public static function lists($type = 'all'){
        switch($type){
            case 'active':
                return self::where('completed', false)->orderBy('id','desc')->get()->toArray();
                break;
            case 'completed':
                return self::where('completed', true)->orderBy('id','desc')->get()->toArray();
                break;
            default:
                return self::orderBy('id', 'DESC')->get()->toArray();
        }
    }

    public static function left(){
        return self::where('completed', 'false')->count();
    } 
}
