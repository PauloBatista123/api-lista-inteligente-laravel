<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;

    const STATUS_QUEUED = 'queued';
    const STATUS_EXECUTING = 'executing';
    const STATUS_FINISHED = 'finished';
    const STATUS_FAILED = 'failed';
    const STATUS_RETRYING = 'retrying';

    public $dates = ['started_at', 'finished_at', 'created_at', 'updated_at'];

    protected $guarded = [];

    protected $casts = [
        'input' => 'array',
        'output' => 'array',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'id');
    }

    /* Accessor */
    public function getProgressPercentageAttribute()
    {
        return $this->progress_max !== 0 ? round(100 * $this->progress_now / $this->progress_max) : 0;
    }

    public function getIsEndedAttribute()
    {
        return \in_array($this->status, [self::STATUS_FAILED, self::STATUS_FINISHED], true);
    }

    public function getIsFinishedAttribute()
    {
        return $this->status === self::STATUS_FINISHED;
    }

    public function getIsFailedAttribute()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function getIsExecutingAttribute()
    {
        return $this->status === self::STATUS_EXECUTING;
    }

    public function getIsQueuedAttribute()
    {
        return $this->status === self::STATUS_QUEUED;
    }

    public function getIsRetryingAttribute()
    {
        return $this->status === self::STATUS_RETRYING;
    }

    public static function getAllowedStatuses()
    {
        return [
            self::STATUS_QUEUED,
            self::STATUS_EXECUTING,
            self::STATUS_FINISHED,
            self::STATUS_FAILED,
            self::STATUS_RETRYING,
        ];
    }
}
