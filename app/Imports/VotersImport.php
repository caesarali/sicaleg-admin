<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Models\Voter;
use App\Models\VotingPlace;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

use Carbon\Carbon;

class VotersImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    public function model(array $row)
    {
        $tps = VotingPlace::find(request()->tps_id);
        return new Voter([
            'voting_place_id' => $tps->id,
            'kk' => $row['2'],
            'nik' => $row['3'],
            'name' => $row['4'],
            'birth_place' => $row['5'],
            'birth_date' => Date::excelToDateTimeObject($row['6'])->format('d/m/Y'),
            'marital_status' => strtolower($row['7']),
            'gender' => strtolower($row['8']),
            'addr_street' => $row['9'],
            'addr_rt' => $row['10'],
            'addr_rw' => $row['11'],
            'disability_id' => $row['12'] != 0 ? $row['12'] : null,
            'information' => $row['13'] ?? null,
            'locationable_type' => Village::class ?? null,
            'locationable_id' => $tps->village_id ?? null
        ]);
    }

    public function headingRow(): int
    {
        return 4;
    }
}
