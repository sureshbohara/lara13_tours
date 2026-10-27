<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Backup;
use Illuminate\Support\Facades\DB;

class BackupService
{
    public function createBackup(int $adminId): array
    {
        $fileName = 'backup_' . now()->format('Y_m_d_His') . '.sql';
        $filePath = storage_path('app/backups/' . $fileName);

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $tableKey = "Tables_in_{$dbName}";
        
        $sql = "-- Database Backup\n-- Generated: " . now() . "\n\nSET FOREIGN_KEY_CHECKS=0;\n\n";
        
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            // Table Structure
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
            
            // Table Data
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function($value) {
                    if (is_null($value)) return 'NULL';
                    if (is_bool($value)) return $value ? '1' : '0';
                    return "'" . addslashes((string)$value) . "'";
                }, (array)$row);
                
                $columns = implode('`, `', array_keys((array)$row));
                $sql .= "INSERT INTO `{$tableName}` (`{$columns}`) VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        // File Save 
        file_put_contents($filePath, $sql);

        // Database  Record 
        $backup = Backup::create([
            'file_name' => $fileName,
            'file_size' => round(filesize($filePath) / 1024, 2) . ' KB',
            'file_path' => 'backups/' . $fileName,
            'created_by' => $adminId,
        ]);

        return [
            'success' => true,
            'message' => 'Backup created successfully!',
            'data' => $backup,
        ];
    }

    public function deleteBackup(int $id): bool
    {
        $backup = Backup::findOrFail($id);
        
        // File  Delete 
        $filePath = storage_path('app/' . $backup->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $backup->delete();
    }
}