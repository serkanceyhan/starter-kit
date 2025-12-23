<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Tamiratt', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_active', 'value' => '1', 'group' => 'general', 'type' => 'boolean'],
            
            // Contact
            ['key' => 'phone', 'value' => '+90 850 123 45 67', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'email', 'value' => 'info@tamiratt.com', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'whatsapp', 'value' => '+90 850 123 45 67', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'address', 'value' => 'İstanbul, Türkiye', 'group' => 'contact', 'type' => 'text'],
            
            // SEO
            ['key' => 'meta_title', 'value' => 'Tamiratt - Ofis Mobilyası Tamiri', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_description', 'value' => 'Ofis koltuğu tamiri ve döşeme hizmetleri. Uzman ustalarla hızlı çözüm.', 'group' => 'seo', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Settings seeded successfully!');
    }
}
