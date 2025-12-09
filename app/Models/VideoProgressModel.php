<?php
namespace App\Models;

use CodeIgniter\Model;

class VideoProgressModel extends Model
{
    protected $table = 'video_progress';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'video_id', 'seconds'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
