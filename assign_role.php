<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

// Assign Super Admin role to admin user
$admin = User::where('email', 'admin@tamiratt.local')->first();
if ($admin) {
    $admin->assignRole('super_admin');
    echo "Super Admin role assigned to {$admin->email}\n";
} else {
    echo "Admin user not found\n";
}
