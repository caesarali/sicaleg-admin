<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Models\Voter;
use App\Models\VotingPlace;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class VotersImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    public $tpsId;
    public $success;
    public $error;

    public function __construct($tpsId)
    {
        $this->tpsId = $tpsId;
        $this->success = [];
        $this->errors = [];
    }

    public function model(array $row)
    {
        $tps = VotingPlace::find($this->tpsId);
        if ($tps) {
            $voter = Voter::firstOrCreate(
                ['kk' => $row['2'], 'nik' => $row['3'], 'name' => $row['4']],
                [
                    'voting_place_id' => $this->tpsId,
                    'birth_place' => $row['5'],
                    'birth_date' => Date::excelToDateTimeObject($row['6'])->format('d/m/Y'),
                    'marital_status' => strtolower($row['7']),
                    'gender' => strtolower($row['8']),
                    'addr_street' => $row['9'],
                    'addr_rt' => $row['10'],
                    'addr_rw' => $row['11'],
                    'disability_id' => $row['12'] != 0 ? $row['12'] : null,
                    'information' => $row['13'] ?? null
                ]
            );
            $this->success[] = $voter;
        } else {
            $this->errors[] = $row;
        }
    }

    public function headingRow(): int
    {
        return 4;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
