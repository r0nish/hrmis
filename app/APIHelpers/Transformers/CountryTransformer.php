<?php

namespace App\APIHelpers\Transformers;

class CountryTransformer extends Transformer
{
    public function transform($country, $permission)
    {
        $data = [
            'id_country' => isset($country['id_country']) ? $country['id_country'] : null,
            'desc' => isset($country['desc']) ? $country['desc'] : null,
            'status' => isset($country['status']) ? $country['status'] : null,
            'created_by' => isset($country['created_by']) ? $country['created_by'] : null,
            'updated_by' => isset($country['updated_by']) ? $country['updated_by'] : null
        ];
        return $data;
    }
}
