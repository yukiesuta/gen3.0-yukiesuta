<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"         => '管理者',
            "email"        => 'admin@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getAdminId(),
        ]);
        User::create([
            "name"         => '料理クラブ',
            "email"        => 'user1@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getUserId(),
        ]);
        User::create([
            "name"         => 'キツネカフェ',
            "email"        => 'user2@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getUserId(),
        ]);
        User::create([
            "name"         => '佐藤真澄',
            "email"        => 'delivery_agent1@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getDeliveryAgentId(),
        ]);
        User::create([
            "name"         => '渡辺誠',
            "email"        => 'delivery_agent2@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getDeliveryAgentId(),
        ]);
        User::create([
            "name"         => '三島海斗',
            "email"        => 'delivery_agent3@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getDeliveryAgentId(),
        ]);
        User::create([
            "name"         => '鈴木美心',
            "email"        => 'delivery_agent4@gmail.com',
            "password"     => Hash::make('password'),
            "company_name" => 'テスト株式会社',
            "role_id"      => Role::getDeliveryAgentId(),
        ]);
    }
}
