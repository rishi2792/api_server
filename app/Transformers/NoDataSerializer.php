<?php namespace App\Transformers;
/**
 * Created by PhpStorm.
 * User: ATUL
 * Date: 3/6/16
 * Time: 5:55 PM
 */

use League\Fractal\Serializer\ArraySerializer;

class NoDataSerializer extends ArraySerializer {
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}