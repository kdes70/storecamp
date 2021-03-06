<?php

namespace App\Core\Transformers;

use App\Core\Models\Parser;
use League\Fractal\TransformerAbstract;

/**
 * Class ParserTransformer.
 */
class ParserTransformer extends TransformerAbstract
{
    /**
     * Transform the \Parser entity.
     *
     * @param \Parser $model
     *
     * @return array
     */
    public function transform(Parser $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
