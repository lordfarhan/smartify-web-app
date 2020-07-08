<?php

namespace App\Imports;

use App\InstitutionActivationCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class InstitutionActivationCodesImport implements ToModel
{
  use Importable;
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    return new InstitutionActivationCode([
      'institution_id' => $row[0],
      'code' => $row[1],
    ]);
  }
}
