<?php

namespace Admark\GoContact;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\DatabaseManager;

class DatabaseRouter
{
    public function __construct(
        private DatabaseManager $database,
        private ConfigRepository $config
    ) {
    }

    public function databaseFor(?string $formId): string
    {
        if ($formId === null || !ctype_digit($formId) || (int) $formId < 1) {
            throw new GoContactException('GoContact routing requires a persisted forms.id');
        }

        $connection = $this->database->connection();
        $existing = $connection->table('gocontact_routing_assignments')->where('form_id', $formId)->first();

        if ($existing !== null) {
            return $existing->database_id;
        }

        return $connection->transaction(function () use ($connection, $formId) {
            // Take the shared write lock before reading, including on SQLite previews.
            $connection->table('gocontact_routing_counters')->where('id', 'default')
                ->update(['updated_at' => now()]);
            $counter = $connection->table('gocontact_routing_counters')->where('id', 'default')->first();

            if ($counter === null) {
                throw new GoContactException('GoContact routing counter is missing; run migrations');
            }

            // A concurrent request may have assigned this form while we waited.
            $existing = $connection->table('gocontact_routing_assignments')->where('form_id', $formId)->first();
            if ($existing !== null) {
                return $existing->database_id;
            }

            if (!$connection->table('forms')->where('id', $formId)->exists()) {
                throw new GoContactException('GoContact routing requires an existing forms.id');
            }

            [$primary, $alternate, $percentage] = $this->settings();
            $policy = hash('sha256', json_encode([$primary, $alternate, $percentage]));
            $remainder = ($counter->policy_key === $policy ? (int) $counter->remainder : 0) + $percentage;
            $databaseId = $remainder >= 100 ? $alternate : $primary;

            $connection->table('gocontact_routing_assignments')->insert([
                'form_id' => $formId,
                'database_id' => $databaseId,
                'alternate_percentage' => $percentage,
                'created_at' => now(),
            ]);
            $connection->table('gocontact_routing_counters')->where('id', 'default')->update([
                'policy_key' => $policy,
                'remainder' => $remainder % 100,
                'updated_at' => now(),
            ]);

            return $databaseId;
        }, 5);
    }

    private function settings(): array
    {
        $primary = $this->config->get('gocontact.database_id');
        $alternate = $this->config->get('gocontact.routing.alternate_database_id');
        $percentage = $this->config->get('gocontact.routing.alternate_percentage', 40);

        if ((!is_int($percentage) && !(is_string($percentage) && ctype_digit($percentage)))
            || (int) $percentage < 0 || (int) $percentage > 100) {
            throw new GoContactException('GoContact alternate percentage must be an integer from 0 to 100');
        }

        foreach ([$primary, $alternate] as $id) {
            if ((!is_string($id) && !is_int($id)) || trim((string) $id) === '') {
                throw new GoContactException('GoContact routing requires primary and alternate database IDs');
            }
        }

        if ((string) $primary === (string) $alternate) {
            throw new GoContactException('GoContact routing database IDs must be different');
        }

        return [(string) $primary, (string) $alternate, (int) $percentage];
    }
}
