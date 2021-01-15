<?php

namespace App\Transformers;
use App\Models\Proctoring\IdentificationPhoto;

/**
 * Трансформирует фотки студентов в массив
 * Class IdentificationPhotoTransformer
 * @package App\Transformers
 */
class IdentificationPhotoTransformer
{
    /**
     * Трансформирует фото в массив
     *
     * @param IdentificationPhoto $identificationPhoto
     * @return array
     */
    public static function oneToArray(IdentificationPhoto $identificationPhoto) : array
    {
        $student = $identificationPhoto->student;
        if ($student) {
            $student = $student->getFullName();
        }

        $deleted_at = $identificationPhoto->deleted_at;
        if ($deleted_at) {
            $deleted_at = $deleted_at->format('Y-m-d H:i:s');
        }

        return [
            'id'         => $identificationPhoto->id,
            'pk'         => $identificationPhoto->pk,
            'old_image'  => $identificationPhoto->old_image,
            'new_image'  => $identificationPhoto->new_image,
            'student'    => $student,
            'created_at' => $identificationPhoto->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $identificationPhoto->created_at->format('Y-m-d H:i:s'),
            'deleted_at' => $deleted_at
        ];
    }

    /**
     * Трансформирует коллекцию фото в массив
     *
     * @param $photos
     * @return array
     */
    public static function manyToArray($photos) : array
    {
        $result = [];

        foreach ($photos as $photo) {
            $result[] = self::oneToArray($photo);
        }

        return $result;
    }
}