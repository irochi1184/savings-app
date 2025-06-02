<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'sort_order',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDefaultCategories()
    {
        return [
            ['name' => '食費',     'icon' => 'fa-utensils'],       // 飲食
            ['name' => '日用品',   'icon' => 'fa-pump-soap'],      // 石鹸や生活用品
            ['name' => '交通費',   'icon' => 'fa-bus'],            // 交通
            ['name' => '光熱費',   'icon' => 'fa-bolt'],           // 電気やガス
            ['name' => '家賃',     'icon' => 'fa-house'],          // 家
            ['name' => '通信費',   'icon' => 'fa-wifi'],           // ネットや通信
            ['name' => '娯楽費',     'icon' => 'fa-gamepad'],        // ゲームなどの娯楽
            ['name' => '給与',     'icon' => 'fa-coins'],          // お金
            ['name' => '副業',     'icon' => 'fa-briefcase'],      // 仕事・副業
            ['name' => 'お小遣い', 'icon' => 'fa-hand-holding-usd'], // ポケットマネー
        ];
    }
}
