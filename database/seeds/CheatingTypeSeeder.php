<?php

namespace Database\Seeders;

use App\Models\Proctoring\CheatingType;
use Illuminate\Database\Seeder;

class CheatingTypeSeeder extends Seeder
{
    /**
     * Cheating типы.
     *
     */
    private $_types = [
        "face_rec"      => "Face Recognition",
        "screen"        => "Webpage tracking",
        "copy"          => "Copied some text",
        "paste"         => "Pasted some text",
        "audio"         => "Audio Recognition",
        "access_denied" => "Camera access denied",
        "verification"  => "Verification",
        "offline"       => "Offline",
        "desktop"       => "Desktop"
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->_types as $name => $description) {
            CheatingType::create([
                'name'           => $name,
                'description_en' => $description
            ]);
        }
    }
}
