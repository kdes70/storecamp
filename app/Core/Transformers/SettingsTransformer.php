<?php

namespace App\Core\Transformers;

use League\Fractal\TransformerAbstract;
use App\Core\Models\Settings;

/**
 * Class SettingsTransformer
 * @package namespace App\Core\Transformers;
 */
class SettingsTransformer extends TransformerAbstract
{

    /**
     * Transform the \Settings entity
     * @param \Settings $model
     *
     * @return array
     */
    public function transform(Settings $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
