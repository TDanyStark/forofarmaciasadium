<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoDocumentModel extends Model
{
    protected $table = 'video_documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['video_id', 'title', 'file_path'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
