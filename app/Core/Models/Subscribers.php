<?php

namespace App\Core\Models;

use App\Core\Base\Model;
use App\Core\Components\Auditing\Auditable;
use App\Core\Support\Cacheable\CacheableEloquent;
use App\Core\Traits\GeneratesUnique;
use Illuminate\Database\Eloquent\SoftDeletes;
use RepositoryLab\Repository\Contracts\Transformable;
use RepositoryLab\Repository\Traits\TransformableTrait;

/**
 * Class Subscribers.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $unique_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Models\Campaign[] $campaign
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereUniqueId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers mails($mail)
 * @mixin \Eloquent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Components\Auditing\Auditing[] $audits
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers idOrUuId($id_or_uuid, $first = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Models\Subscribers uuid($unique_id, $first = true)
 */
class Subscribers extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;
    use GeneratesUnique;
    use Auditable;
    use CacheableEloquent;
    /**
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'unique_id',
    ];

    /**
     * bootable methods fix.
     */
    public static function boot()
    {
        parent::boot();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaign()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_subscribers', 'subscriber_id', 'campaign_id')->withTimestamps();
    }

    /**
     * @param $query
     * @param $mail
     */
    public function scopeMails($query, $mail)
    {
        $query->where('email', $mail);
    }
}
