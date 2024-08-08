<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property Carbon|null $completed_at
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "description",
        "completed_at",
    ];

    protected $casts = [
        "completed_at" => "datetime",
    ];
}
