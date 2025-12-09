<?php
namespace App\Models;

use CodeIgniter\Model;

class CertificadoModel extends Model
{
    protected $table = 'certificados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'first_name', 'last_name', 'email', 'is_downloaded', 'download_date'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
