<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AssignSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@tamiratt.local')->first();
        
        if ($admin) {
            $admin->assignRole('super_admin');
            $this->command->info("Super Admin role assigned to {$admin->email}");
        } else {
            $this->command->warn("Admin user not found");
        }
    }
}
