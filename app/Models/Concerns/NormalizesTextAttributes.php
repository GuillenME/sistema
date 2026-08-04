<?php

namespace App\Models\Concerns;

trait NormalizesTextAttributes
{
    /**
     * Normaliza los campos configurados antes de crear o actualizar un registro.
     *
     * Cada modelo puede declarar $titleCaseAttributes y/o $sentenceCaseAttributes.
     */
    public static function bootNormalizesTextAttributes()
    {
        static::saving(function ($model) {
            foreach ($model->titleCaseAttributes ?? [] as $attribute) {
                $model->normalizeAttribute($attribute, true);
            }

            foreach ($model->sentenceCaseAttributes ?? [] as $attribute) {
                $model->normalizeAttribute($attribute, false);
            }
        });
    }

    protected function normalizeAttribute($attribute, $titleCase)
    {
        $value = $this->getAttribute($attribute);

        if (!is_string($value)) {
            return;
        }

        // Elimina espacios duplicados sin alterar saltos de línea en textos largos.
        $value = trim(preg_replace('/[ \t]+/u', ' ', $value));

        if ($value === '') {
            return;
        }

        $value = mb_strtolower($value, 'UTF-8');
        $value = $titleCase
            ? mb_convert_case($value, MB_CASE_TITLE, 'UTF-8')
            : mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8')
                . mb_substr($value, 1, null, 'UTF-8');

        $this->setAttribute($attribute, $value);
    }
}
