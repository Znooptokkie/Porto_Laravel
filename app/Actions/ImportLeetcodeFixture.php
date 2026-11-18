<?php

namespace App\Actions;

use App\Enums\LeetcodeConceptType;
use App\Enums\LeetcodeDifficulty;
use App\Models\LeetcodeConcept;
use App\Models\LeetcodeProblem;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ImportLeetcodeFixture
{
    private const string PIVOT_TABLE = 'leetcode_concept_leetcode_problem';

    /**
     * The fixture model name of each concept table.
     */
    private const array CONCEPT_TYPES = [
        'core.leetcodefunction' => LeetcodeConceptType::Function,
        'core.leetcodemethod' => LeetcodeConceptType::Method,
        'core.leetcodeoperator' => LeetcodeConceptType::Operator,
        'core.leetcodedatastructure' => LeetcodeConceptType::DataStructure,
        'core.leetcodecontrolstructure' => LeetcodeConceptType::ControlStructure,
        'core.leetcodealgorithm' => LeetcodeConceptType::Algorithm,
    ];

    /**
     * The fixture field that lists the concept ids a problem uses, mapped to the fixture model it refers to.
     */
    private const array USED_CONCEPT_FIELDS = [
        'used_functions' => 'core.leetcodefunction',
        'used_methods' => 'core.leetcodemethod',
        'used_operators' => 'core.leetcodeoperator',
        'used_data_structures' => 'core.leetcodedatastructure',
        'used_control_structures' => 'core.leetcodecontrolstructure',
        'used_algorithms' => 'core.leetcodealgorithm',
    ];

    /**
     * The fixture stores difficulty as a number. Only 1 and 2 occur in the data; 3 = hard is an assumption.
     */
    private const array DIFFICULTIES = [
        1 => LeetcodeDifficulty::Easy,
        2 => LeetcodeDifficulty::Medium,
        3 => LeetcodeDifficulty::Hard,
    ];

    /**
     * Replaces all problems with the ones in the Django-style fixture file and upserts the concepts they use.
     */
    public function handle(string $path): void
    {
        if (! is_file($path)) {
            throw new RuntimeException("Leetcode fixture not found: {$path}");
        }

        /** @var list<array{model: string, pk: int, fields: array<string, mixed>}> $records */
        $records = json_decode(file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($records): void {
            $conceptIds = $this->importConcepts($records);

            LeetcodeProblem::query()->delete();

            $this->importProblems($records, $conceptIds);
        });
    }

    /**
     * Upserts every concept and returns the new concept id per fixture key (`model:pk`).
     *
     * @param  list<array{model: string, pk: int, fields: array<string, mixed>}>  $records
     * @return array<string, int>
     */
    private function importConcepts(array $records): array
    {
        $now = now();
        $concepts = collect($records)
            ->filter(fn (array $record): bool => isset(self::CONCEPT_TYPES[$record['model']]))
            ->map(fn (array $record): array => [
                'type' => self::CONCEPT_TYPES[$record['model']]->value,
                'name' => $record['fields']['name'],
                'description' => $record['fields']['description'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        LeetcodeConcept::query()->upsert($concepts->all(), ['type', 'name'], ['description', 'updated_at']);

        $conceptIdsByTypeAndName = LeetcodeConcept::query()
            ->get(['id', 'type', 'name'])
            ->mapWithKeys(fn (LeetcodeConcept $concept): array => [$concept->type->value.'|'.$concept->name => $concept->id]);

        return collect($records)
            ->filter(fn (array $record): bool => isset(self::CONCEPT_TYPES[$record['model']]))
            ->mapWithKeys(fn (array $record): array => [
                $record['model'].':'.$record['pk'] => $conceptIdsByTypeAndName[self::CONCEPT_TYPES[$record['model']]->value.'|'.$record['fields']['name']],
            ])
            ->all();
    }

    /**
     * @param  list<array{model: string, pk: int, fields: array<string, mixed>}>  $records
     * @param  array<string, int>  $conceptIds
     */
    private function importProblems(array $records, array $conceptIds): void
    {
        $pivotRows = [];

        foreach ($records as $record) {
            if ($record['model'] !== 'core.leetcode') {
                continue;
            }

            $fields = $record['fields'];
            $problem = LeetcodeProblem::query()->create([
                'problem_number' => $fields['problem_number'],
                'name' => $fields['problem_name'],
                'url' => $fields['problem_url'],
                'rating' => $fields['rating'],
                'difficulty' => self::DIFFICULTIES[$fields['difficulty']],
                'language' => $fields['language'],
                'runtime_ms' => $fields['runtime_ms'],
                'runtime_percentage' => $fields['runtime_perc'],
                'memory_mb' => $fields['memory_mb'],
                'memory_percentage' => $fields['memory_perc'],
                'code' => str_replace("\r\n", "\n", $fields['code']),
            ]);

            foreach (self::USED_CONCEPT_FIELDS as $field => $conceptModel) {
                foreach ($fields[$field] ?? [] as $conceptPk) {
                    $pivotRows[] = [
                        'leetcode_problem_id' => $problem->id,
                        'leetcode_concept_id' => $conceptIds[$conceptModel.':'.$conceptPk],
                    ];
                }
            }
        }

        foreach (array_chunk($pivotRows, 500) as $chunk) {
            DB::table(self::PIVOT_TABLE)->insert($chunk);
        }
    }
}
