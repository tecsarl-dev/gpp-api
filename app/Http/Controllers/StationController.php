<?php

namespace App\Http\Controllers;

use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Stations\Requests\CreateStationRequest;
use App\Http\Controllers\Controller;
use App\Traits\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StationController extends Controller
{
    use UploadableTrait;
    private $stationRepo;

    /**
     * Constructeur
     */
    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepo = $stationRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = $this->stationRepo->findAll();
        return response()->json(['stations' => $stations],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStationRequest $request)
    {
        if($request['authorization_file']){
            $filename_authorization_file = Str::of('certificate_'.$request->petroleum.'_'.strtolower(trim($request->code_station)).'_'.'authorization_file'.'_'.time())->slug('_').'.pdf';
            $request['authorization_file_name'] = $filename_authorization_file;
        }
        
        $this->uploadOne($request['authorization_file'],'/station_files', $filename_authorization_file, 'private');
        

        $station = $this->stationRepo->save($request->all());
        
        return response()->json(['message' => "station enregistré"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payslstationip = $this->stationRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Station mise à jour"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $delete = $this->payslipRepo->deletePayslip($payslip);

        // return response()->json([
        //     'message' => "Fiche supprimée"
        // ],200);
    }
}
