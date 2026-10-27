<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class SubscriberService
{
    public function getSubscribers(array $filters = [])
    {
        return Subscriber::getFilteredRecords($filters);
    }

    public function toggleStatus(int $id): bool
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->status = !$subscriber->status;
        $subscriber->unsubscribed_at = $subscriber->status ? null : now();
        $subscriber->save();
        return $subscriber->status;
    }

    public function deleteSubscriber(int $id): bool
    {
        return Subscriber::findOrFail($id)->delete();
    }

    public function importFromCsv(string $filePath): array
    {
        $handle = fopen($filePath, 'r');
        $imported = 0;
        $failed = 0;

        fgetcsv($handle);

        DB::beginTransaction();
        try {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $email = trim($data[0] ?? '');
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Subscriber::updateOrCreate(
                        ['email' => $email],
                        ['status' => true, 'subscribed_at' => now()]
                    );
                    $imported++;
                } else {
                    $failed++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            fclose($handle);
        }

        return ['imported' => $imported, 'failed' => $failed];
    }
}