<?php

namespace App\Http\Controllers;

use App\Gpp\Users\User;
use Illuminate\Support\Str;
use App\Mail\TruckApprouved;
use Illuminate\Http\Request;
use App\Mail\TruckUnapprouved;
use App\Traits\UploadableTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\EmailNotSendException;
use Symfony\Component\Console\Input\Input;
use App\Gpp\Trucks\Requests\CreateTruckRequest;
use App\Gpp\Trucks\Requests\UpdateTruckRequest;
use App\Gpp\Trucks\Repositories\Interfaces\TruckRepositoryInterface;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Gpp\Decisions\Repositories\Interfaces\DecisionRepositoryInterface;

class TruckController extends Controller
{
    private $truckRepo;
    private $decisionRepo;
    private $companyRepo;
    use UploadableTrait;

    /**
     * Constructeur
     */
    public function __construct(TruckRepositoryInterface $truckRepository,DecisionRepositoryInterface $decisionRepository,CompanyRepositoryInterface $companyRepository)
    {
        $this->truckRepo = $truckRepository;
        $this->decisionRepo = $decisionRepository;
        $this->companyRepo = $companyRepository;
    }

    public function listTrucks()
    {
        $trucks = $this->truckRepo->listTrucks();
        return response()->json(['trucks' => $trucks],200);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

        $trucks = $this->truckRepo->findAll();
        return response()->json(['trucks' => $trucks],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTruckRequest $request)
    {
        if($request['pdf_gauging_certificate_file']){
            $filename_file_pdf_gauging_certificate_file = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_gauging_certificate_file'.'_'.time())->slug('_').'.pdf';
        }

        if($request['pdf_assurance_file']){
            $filename_file_pdf_assurance_file = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_assurance_file'.'_'.time())->slug('_').'.pdf';
        }

        if($request['pdf_car_registration']){
            $filename_file_pdf_car_registration = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_car_registration'.'_'.time())->slug('_').'.pdf';
        }

        $request['gauging_certificate_file'] = $filename_file_pdf_gauging_certificate_file;
        $request['assurance_file'] = $filename_file_pdf_assurance_file;
        $request['car_registration'] = $filename_file_pdf_car_registration;

        $file_pdf_gauging_certificate_file = $this->uploadOne($request['pdf_gauging_certificate_file'],'/truck_files', $filename_file_pdf_gauging_certificate_file, 'private');
        $file_pdf_assurance_file = $this->uploadOne($request['pdf_assurance_file'],'/truck_files', $filename_file_pdf_assurance_file, 'private');
        $file_pdf_car_registration = $this->uploadOne($request['pdf_car_registration'],'/truck_files', $filename_file_pdf_car_registration, 'private');

        $truckSave = $this->truckRepo->save($request->all());

        
        return response()->json(['message' => "Camion enregistré"],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $truck = $this->truckRepo->find($id);

        return response()->json(['truck' => $truck],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTruckRequest $request, $id)
    {
        if($request->file('pdf_gauging_certificate_file')){
            $filename_file_pdf_gauging_certificate_file = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_gauging_certificate_file'.'_'.time())->slug('_').'.pdf';
            $request['gauging_certificate_file'] = $filename_file_pdf_gauging_certificate_file;
            $file_pdf_gauging_certificate_file = $this->uploadOne($request->file('pdf_gauging_certificate_file'),'/truck_files', $filename_file_pdf_gauging_certificate_file, 'private');
        }

        if($request->file('pdf_assurance_file')){
            $filename_file_pdf_assurance_file = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_assurance_file'.'_'.time())->slug('_').'.pdf';
            $request['assurance_file'] = $filename_file_pdf_assurance_file;
            $file_pdf_assurance_file = $this->uploadOne($request->file('pdf_assurance_file'),'/truck_files', $filename_file_pdf_assurance_file, 'private');
        }

        if($request->file('pdf_car_registration')){
            $filename_file_pdf_car_registration = Str::of('transporter_'.$request->transporter.'_'.strtolower(trim($request->truck_number)).'_'.'pdf_car_registration'.'_'.time())->slug('_').'.pdf';
            $request['car_registration'] = $filename_file_pdf_car_registration;
            $file_pdf_car_registration = $this->uploadOne($request->file('pdf_car_registration'),'/truck_files', $filename_file_pdf_car_registration, 'private');
    
        }
        
        $lslip = $this->truckRepo->update($request->all(),$id);
        
        return response()->json([
            'message'=>"Camion mise à jour"
        ],200);
    }

    public function download ($files)
    {
        return Storage::download("private/truck_files/$files");
    }

    public function decision (Request $request, $id) {
        $station = $this->truckRepo->approuved(
                [
                    "approuved" =>$request->decision,
                    "approuved_by" => $request->approuved_by,
                    "approuved_date" =>date("Y-m-d"),
                    "is_submit" => ($request->decision == 1) ? 1 : 0
                ]
            ,$id);
        
        if ($station) {
            $decision = $this->decisionRepo->save([
                "truck_id" => $id,
                "user_id" => $request->user_id,
                "decision" => $request->decision,
                "motif" => $request->motif,
            ]);
        }

        $truck  = $this->truckRepo->find($id);
        $company = $this->companyRepo->find($truck->transporter);

        $admin = User::where('role',"admin")->where('company_id',$id)->get("email");

        try {
            if ($request->decision == 1) {
                Mail::to($admin)->send(new TruckApprouved([
                    'company'=>$company->social_reason,
                    'truck'=> $truck->truck_number,

                ]));
            } else {
                Mail::to($admin)->send(new TruckUnapprouved([
                    'company'=> $company->social_reason,
                    'truck'=> $truck->truck_number,
                    "decision" => $request->decision,
                    "motif"=> $request->motif 
                ]));
            }
        } catch (\Throwable $th) {
            throw new EmailNotSendException($th);
        }
        
        return response()->json([
            'message'=>"Camion mise a jour"
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
        $delete = $this->truckRepo->destroy($id);
        return response()->json([
            'message' => "Camion supprimé"
        ],200);
    }
}
