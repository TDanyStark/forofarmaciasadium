<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InscritosSeeder extends Seeder
{
    public function run()
    {
        $file = APPPATH . 'Database' . DIRECTORY_SEPARATOR . 'Seeds' . DIRECTORY_SEPARATOR . 'csv.csv';

        if (! is_file($file)) {
            throw new \RuntimeException("CSV file not found: $file");
        }

        $handle = fopen($file, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Unable to open CSV file: $file");
        }

        // Read header
        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return;
        }

        $batch = [];
        $inserted = 0;

        while (($row = fgetcsv($handle)) !== false) {
            // Ensure we have expected columns (skip malformed rows)
            if (count($row) < 15) {
                continue;
            }

            $fecha_nac = $this->parseDate($row[5] ?? '');

            $registrationRaw = trim($row[14] ?? '');
            $registration = $this->parseDateTime($registrationRaw);

            $batch[] = [
                'nombres' => $this->nullString($row[2] ?? ''),
                'apellidos' => $this->nullString($row[3] ?? ''),
                'cedula' => $this->nullString($row[4] ?? ''),
                'fecha_nacimiento' => $fecha_nac,
                'genero' => $this->nullString($row[6] ?? ''),
                'email' => $this->nullString($row[7] ?? ''),
                'celular' => $this->nullString($row[8] ?? ''),
                'nombre_farmacia' => $this->nullString($row[9] ?? ''),
                'ciudad' => $this->nullString($row[10] ?? ''),
                'direccion_farmacia' => $this->nullString($row[11] ?? ''),
                'nombre_cadena_distribuidor' => $this->nullString($row[12] ?? ''),
                'acepta_politica_datos' => $this->boolInt($row[13] ?? '0'),
                'registration_date' => $registration ?? date('Y-m-d H:i:s'),
                'status' => $this->boolInt($row[15] ?? '0'),
            ];

            if (count($batch) >= 500) {
                $this->db->table('inscritos')->insertBatch($batch);
                $inserted += count($batch);
                $batch = [];
            }
        }

        if (count($batch) > 0) {
            $this->db->table('inscritos')->insertBatch($batch);
            $inserted += count($batch);
        }

        fclose($handle);

        echo "Inserted $inserted rows into `inscritos`.\n";
    }

    private function nullString($value)
    {
        $v = trim((string) $value);
        return $v === '' ? null : $v;
    }

    private function nullInt($value)
    {
        $v = trim((string) $value);
        if ($v === '' || strtoupper($v) === 'N/A') {
            return null;
        }
        if (is_numeric($v)) {
            return (int) $v;
        }
        return null;
    }

    private function boolInt($value)
    {
        $v = trim((string) $value);
        return ($v === '1' || strtolower($v) === 'true') ? 1 : 0;
    }

    private function parseDate($value)
    {
        $v = trim((string) $value);
        if ($v === '') {
            return null;
        }

        $patterns = [
            'd/m/Y',
            'd/m/y',
            'd-m-Y',
            'd-m-y',
            'Y-m-d',
            'Y/m/d',
            'd M Y',
        ];

        foreach ($patterns as $p) {
            $dt = \DateTime::createFromFormat($p, $v);
            if ($dt !== false) {
                // Validate year plausibility
                $year = (int) $dt->format('Y');
                if ($year < 1900 || $year > 2100) {
                    // treat as invalid
                    break;
                }
                return $dt->format('Y-m-d');
            }
        }

        // Try strtotime fallback
        $ts = strtotime($v);
        if ($ts !== false && $ts !== -1) {
            $year = (int) date('Y', $ts);
            if ($year >= 1900 && $year <= 2100) {
                return date('Y-m-d', $ts);
            }
        }

        return null;
    }

    private function parseDateTime($value)
    {
        $v = trim((string) $value);
        if ($v === '') {
            return null;
        }

        // Common full datetime format
        $dt = \DateTime::createFromFormat('Y-m-d H:i:s', $v);
        if ($dt !== false) {
            return $dt->format('Y-m-d H:i:s');
        }

        // Fallback to strtotime
        $ts = strtotime($v);
        if ($ts !== false && $ts !== -1) {
            return date('Y-m-d H:i:s', $ts);
        }

        return null;
    }
}
