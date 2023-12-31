<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Models\Service;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dateTime',
        'status',
        'notes',
        'userId',
        'serviceId'
    ];

    public function setStatusAttribute($value)
    {
        $statuses = StatusEnum::getStatuses();
        $this->attributes['status'] = in_array($value, $statuses) ? $value : null;
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceId');
    }
}
