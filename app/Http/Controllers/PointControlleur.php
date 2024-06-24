<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
class PointControlleur extends Controller
{
    public function csv_to_array($file) {
        if (!file_exists($file)) {
            throw new \Exception("File not found: ".$file);
        }
        $contents = file_get_contents($file);
        $lines = explode(PHP_EOL, $contents);
        $csvData = [];

        for ($i=1; $i <count($lines) ; $i++) { 
            $line = $lines[$i];
            if ($line == '') {
                continue;
            }
            $values = str_getcsv($line); 
            $csvData[] = $values;
        }
        // dd($csvData);
        return $csvData;
    }

    public  function processCSV($file)
    {
        $csvData = $this->csv_to_array($file);
        $data = [];
        $data['data'] = $csvData;
        for ($i = 1 ; $i<count($csvData);$i++ ) {
            $row = $csvData[$i];

            $validator = Validator::make(
                [
                    'classement' => $row[0],
                    'points' => $row[1]
                ]
                , [
                'classement' => 'required|string',
                'points' => 'required|string'
            ], [
                'classement.required' => 'Le champ classement est requis. Numéro de ligne : '.($i+1),
                'points.required' => 'Le champ points est requis. Numéro de ligne : '.($i+1),                
            ]);
            
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data['error'][] = $errors;
                continue;
            }else {
                
            }
        }
       return $data; 
    }
    
    public function insert_table_temporaire(Request $request){
        
        if ($request->hasFile('file_point')) {
            $file = $request->file('file_point');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $filePath = public_path('uploads') . '/' . $fileName;

            $data = $this->processCSV($filePath);
            if (isset($data['error'])) {
                dd($data['error']);
                return back()->with('error', $data['error'])->withInput();
            } else{
                for ($i = 0 ; $i<count($data['data']);$i++ ) {
                    $row = $data['data'][$i];
                    DB::table('point_temporaire')
                    ->insert(
                        [
                            'classement' => $row[0],
                            'points' => $row[1],
                        ]
                        );
                        DB::commit();
                }
                return back()->with('success', 'upload success')->withInput();
            }
        }
    }

    public function import_csv_etape_resultat(Request $request){
        try {
            DB::beginTransaction();
            $this->insert_table_temporaire($request);
            $this->insert_point();
            DB::commit();
            return back()->with('success','upload successfull');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function insert_point(){
        $sql = 'select * from point_temporaire';
        $data = DB::select($sql);
        foreach ($data as $item) {
            $point = new Point();
            $point->classement = $item->classement;
            $point->points = $item->points;
            $point->save();
        }
    }

}
