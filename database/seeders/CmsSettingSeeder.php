<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CmsSetting;

class CmsSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hero_title', 'value' => 'Welcome to Madrasa Dar-ul-Falah', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hero_subtitle', 'value' => 'Empowering minds with Islamic and modern education', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'about_text', 'value' => 'Madrasa Dar-ul-Falah is a premier Islamic educational institute...', 'type' => 'textarea', 'group' => 'about'],
            ['key' => 'contact_email', 'value' => 'info@madrasa.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+1234567890', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'address', 'value' => '123 Islamic Center, City', 'type' => 'textarea', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            CmsSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
