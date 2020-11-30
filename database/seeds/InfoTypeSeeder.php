<?php

namespace Database\Seeders;

use App\Models\Proctoring\InfoType;
use Illuminate\Database\Seeder;

class InfoTypeSeeder extends Seeder
{
    /**
     * Info типы.
     *
     */
    private $_types = [
        ['info_en' => "no_student",            'info_ru' => "Нет студента"],
        ['info_en' => "not_recognized",        'info_ru' => "Чужой студент за экзаменом"],
        ['info_en' => "too_many_people",       'info_ru' => "Два или больше человек"],
        ['info_en' => "look_away",             'info_ru' => "Смотрит не туда"],
        ['info_en' => "tab_focus",             'info_ru' => "Открыл другую страницу в хроме"],
        ['info_en' => "browser_focus",         'info_ru' => "Браузер вышел из фокуса"],
        ['info_en' => "paste",                 'info_ru' => "Вставил текст"],
        ['info_en' => "copy",                  'info_ru' => "Скопировал текст"],
        ['info_en' => "audio",                 'info_ru' => "Аудио ученика"],
        ['info_en' => "webcam_access_denied",  'info_ru' => "Не дал доступ от камеры"],
        ['info_en' => "webcam_access_removed", 'info_ru' => "Убрал доступ от камеры"],
        ['info_en' => "screen_access_denied",  'info_ru' => "Не дал доступ от экрана"],
        ['info_en' => "screen_access_removed", 'info_ru' => "Убрал доступ от экрана"],
        ['info_en' => "audio_access_denied",   'info_ru' => "Не дал доступ от аудио"],
        ['info_en' => "audio_access_removed",  'info_ru' => "Убрал доступ от аудио"],
        ['info_en' => "suspicious",            'info_ru' => "Подозрительно"],
        ['info_en' => "no_encodings",          'info_ru' => "Нет энкодингов"],
        ['info_en' => "desktop_image",         'info_ru' => "Фото рабочего стола"],
        ['info_en' => "dual_screen",           'info_ru' => "Два монитора"],
        ['info_en' => "offline",               'info_ru' => "Был оффлайн"],
        ['info_en' => "face_image",            'info_ru' => "Фото лица"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->_types as $type) {
            InfoType::create([
                'info_en' => $type['info_en'],
                'info_ru' => $type['info_ru']
            ]);
        }
    }
}
