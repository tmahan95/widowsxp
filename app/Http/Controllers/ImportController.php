<?php

namespace WidowsXP\Http\Controllers;

use Illuminate\Http\Request;
use WidowsXP\Logs;
use WidowsXP\Http\Controllers\Controller;
use WidowsXP\Http\Requests\CsvImportRequest;
use WidowsXP\CsvData;

class ImportController extends Controller{

	public function getImport(){
		return view('import.index');
	}

	public function parseImport(CsvImportRequest $request){
		$path = $request->file('csv_file')->getRealPath();
		$data = array_map('str_getcsv', file($path));

		$csv_data_file = CsvData::create([
			'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
			'csv_header' => $request->has('header'),
			'csv_data' => json_encode($data)
		]);


		$csv_data = array_slice($data, 0, 2);
		return view('import.import_fields', compact('csv_data_file', 'csv_data'));

	}

	public function processImport(Request $request){
		$data = CsvData::find($request->csv_data_file_id);
		$csv_data = json_decode($data->csv_data, true);
		foreach ($csv_data as $row) {
			$contact = new Logs();
				foreach (config('app.db_fields') as $index => $field) {
					$contact->$field = $row[$request->fields[$index]];
				}
        		$contact->save();
    		}

	    	return view('import_success');
	}
}
?>
