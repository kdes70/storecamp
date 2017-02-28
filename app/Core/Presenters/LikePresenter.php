<?php

namespace App\Core\Presenters;

use App\Core\Transformers\LikeTransformer;
use RepositoryLab\Repository\Presenter\FractalPresenter;

/**
 * Class LikePresenter
 *
 * @package namespace App\Core\Presenters;
 */
class LikePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LikeTransformer();
    }
}
