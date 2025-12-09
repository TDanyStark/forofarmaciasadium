<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\RegistroModel;
use App\Models\CertificadoModel;

class CertificadosSeeder extends Seeder
{
    public function run()
    {
        $csvPath = WRITEPATH . 'uploads/seeds/Certificados.csv';

        // If the CSV exists in app/Database/Seeds, prefer that path
        $alt = APPPATH . 'Database/Seeds/Certificados.csv';
        if (file_exists($alt)) {
            $csvPath = $alt;
        }

        if (! file_exists($csvPath)) {
            echo "CSV file not found: $csvPath\n";
            return;
        }

        $registroModel = new RegistroModel();
        $certModel = new CertificadoModel();

        if (($handle = fopen($csvPath, 'r')) !== false) {
            $header = fgetcsv($handle);
            if ($header === false) {
                fclose($handle);
                echo "Empty CSV\n";
                return;
            }

            // Normalize header columns
            $cols = array_map(function ($c) {
                return strtolower(trim($c));
            }, $header);

            $emailIdx = array_search('email', $cols);
            $firstIdx = array_search('first name', $cols);
            $lastIdx = array_search('last name', $cols);
            $isDownloadedIdx = array_search('is downloaded', $cols);

            if ($emailIdx === false) {
                echo "CSV does not contain 'Email' column\n";
                fclose($handle);
                return;
            }

            $inserted = 0;
            $skipped = 0;

            while (($row = fgetcsv($handle)) !== false) {
                $email = isset($row[$emailIdx]) ? trim($row[$emailIdx]) : '';
                if ($email === '') {
                    $skipped++;
                    continue;
                }

                // Find user by email (case-insensitive)
                $user = $registroModel->where('LOWER(email)', strtolower($email))->first();
                if (empty($user)) {
                    // Try other common email column names if needed
                    $user = $registroModel->where('email', $email)->first();
                }

                if (empty($user) || empty($user->id)) {
                    // no matching user, skip
                    $skipped++;
                    continue;
                }

                $firstName = $firstIdx !== false && isset($row[$firstIdx]) ? trim($row[$firstIdx]) : '';
                $lastName = $lastIdx !== false && isset($row[$lastIdx]) ? trim($row[$lastIdx]) : '';
                $isDownloadedRaw = $isDownloadedIdx !== false && isset($row[$isDownloadedIdx]) ? trim($row[$isDownloadedIdx]) : '';
                $isDownloaded = (strtolower($isDownloadedRaw) === 'yes' || strtolower($isDownloadedRaw) === 'si' || $isDownloadedRaw === '1') ? 1 : 0;

                $downloadDate = $isDownloaded ? date('Y-m-d H:i:s') : null;

                // Check existing certificado by user_id or email
                $existing = $certModel->where('user_id', $user->id)->orWhere('email', $email)->first();

                $data = [
                    'user_id' => $user->id,
                    'first_name' => $firstName ?: ($user->nombres ?? ''),
                    'last_name' => $lastName ?: ($user->apellidos ?? ''),
                    'email' => $email,
                    'is_downloaded' => $isDownloaded,
                    'download_date' => $downloadDate,
                ];

                if ($existing) {
                    $certModel->update($existing['id'], $data);
                } else {
                    $certModel->insert($data);
                }

                $inserted++;
            }

            fclose($handle);

            echo "Processed CSV: inserted/updated={$inserted}, skipped={$skipped}\n";
        } else {
            echo "Unable to open CSV file: $csvPath\n";
        }
    }
}
