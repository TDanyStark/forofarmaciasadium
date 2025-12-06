<?php
namespace App\Models;

use CodeIgniter\Model;

class VideoViewModel extends Model
{
    protected $table = 'video_views';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'video_id', 'ip', 'user_agent', 'viewed_at'];
    protected $useTimestamps = false;
}
