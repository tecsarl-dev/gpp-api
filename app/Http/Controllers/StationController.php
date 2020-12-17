<?php

namespace App\Http\Controllers;

use App\Gpp\Users\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\StationApprouved;
use App\Traits\UploadableTrait;
use App\Mail\StationUnapprouved;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\EmailNotSendException;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Gpp\Stations\Requests\CreateStationRequest;
use App\Gpp\Stations\Requests\UpdateStationRequest;
use App\Gpp\Stations\Repositories\Interfaces\StationRepositoryInterface;
use App\Gpp\Decisions\Repositories\Interfaces\DecisionRepositoryInterface;

class StationController extends Controller
{
    use UploadableTrait;
    private $stationRepo;
    private $decisionRepo;
    private $companyRepo;

    /**
     * Constructeur
     */
    public function __construct(StationRepositoryInterface $stationRepository, DecisionRepositoryInterface $decisionRepository, CompanyRepositoryInterface $companyRepository)
    {
        $this->stationRepo = $stationRepository;
        $this->decisionRepo = $decisionRepository;
        $this->companyRepo = $companyRepository;
    }

    public function listStations()
    {
        $stations = $this->stationRepo->listStations();
        return response()->json(['stations' => $stations],200);
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
        $station = $this->stationRepo->find($id);

        return response()->json(['station' => $station],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStationRequest $request, $id)
    {
         if ($request->file('authorization_file')) {
            $filename_authorization_file = Str::of('certificate_'.$request->petroleum.'_'.strtolower(trim($request->code_station)).'_'.'authorization_file'.'_'.time())->slug('_').'.pdf';

            $this->uploadOne($request->file('authorization_file'),'/station_files', $filename_authorization_file, 'private');

            $request['authorization_file_name'] = $filename_authorization_file;
         }
        
        $p = $this->stationRepo->update($request->all(),$id);

        return response()->json([
            'message'=>"Station mise à jour"
        ],200);
    }

    public function download ($files)
    {
        return Storage::download("private/station_files/$files");
    }

    public function decision (Request $request, $id) {
        $station = $this->stationRepo->approuved(
                [
                    "approuved" =>$request->decision,
                    "approuved_by" => $request->approuved_by,
                    "approuved_date" =>date("Y-m-d"),
                    "is_submit" => ($request->decision == 1) ? 1 : 0
                ]
            ,$id);
        
        if ($station) {
            $decision = $this->decisionRepo->save([
                "station_id" => $id,
                "user_id" => $request->user_id,
                "decision" => $request->decision,
                "motif" => $request->motif,
            ]);
        }

        $station  = $this->stationRepo->find($id);
        $company = $this->companyRepo->find($station->petroleum);

        $admin = User::where('role',"admin")->where('company_id',$id)->get("email");

        try {
            if ($request->decision == 1) {
                Mail::to($admin)->send(new StationApprouved([
                    'company'=>$company->social_reason,
                    'station'=> $station->code_station,

                ]));
            } else {
                Mail::to($admin)->send(new StationUnapprouved([
                    'company'=> $company->social_reason,
                    'station'=> $station->code_station,
                    "decision" => $request->decision,
                    "motif"=> $request->motif 
                ]));
            }
        } catch (\Throwable $th) {
            throw new EmailNotSendException($th);
        }

        return response()->json([
            'message'=>"Station mise a jour"
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
        $delete = $this->stationRepo->destroy($id);

        return response()->json([
            'message' => "Station supprimée"
        ],200);
    }
}
