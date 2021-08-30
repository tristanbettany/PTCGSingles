<?php

namespace App;

final class CSV
{
    public static function download(
        string $filename,
        array $headers,
        array $rows,
    ): void {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv";');

        $handle = fopen('php://output', 'w');

        fputcsv($handle, $headers);

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        exit(0);
    }
}
