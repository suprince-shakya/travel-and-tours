<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $password = Hash::make('password');
        $users = [];

        $users[] = [
            'name' => 'Admin',
            'email' => 'admin@travels.com',
            'email_verified_at' => $now,
            'password' => $password,
            'phone' => '+977-9851234567',
            'avatar' => 'https://i.pravatar.cc/150?img=20',
            'role' => 'admin',
            'status' => 1,
            'last_login_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $users[] = [
            'name' => 'Staff One',
            'email' => 'staff1@travels.com',
            'email_verified_at' => $now,
            'password' => $password,
            'phone' => '+977-9851234568',
            'avatar' => 'https://i.pravatar.cc/150?img=21',
            'role' => 'staff',
            'status' => 1,
            'last_login_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $users[] = [
            'name' => 'Staff Two',
            'email' => 'staff2@travels.com',
            'email_verified_at' => $now,
            'password' => $password,
            'phone' => '+977-9851234569',
            'avatar' => 'https://i.pravatar.cc/150?img=22',
            'role' => 'staff',
            'status' => 1,
            'last_login_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'name' => "Customer $i",
                'email' => "customer{$i}@travels.com",
                'email_verified_at' => $now,
                'password' => $password,
                'phone' => '+977-9851234' . str_pad(($i + 69), 3, '0', STR_PAD_LEFT),
                'avatar' => 'https://i.pravatar.cc/150?img=' . (30 + $i),
                'role' => 'customer',
                'status' => 1,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $users[] = [
            'name' => 'Guide User',
            'email' => 'guide@travels.com',
            'email_verified_at' => $now,
            'password' => $password,
            'phone' => '+977-9851234580',
            'avatar' => 'https://i.pravatar.cc/150?img=24',
            'role' => 'guide',
            'status' => 1,
            'last_login_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('users')->insert($users);
    }
}
