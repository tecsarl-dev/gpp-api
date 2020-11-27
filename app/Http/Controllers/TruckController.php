<?php

namespace App\Http\Controllers;

use App\Gpp\Trucks\Repositories\Interfaces\TruckRepositoryInterface;
use App\Gpp\Trucks\Requests\CreateTruckRequest;
use App\Http\Controllers\Controller;
use App\Traits\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TruckController extends Controller
{
    private $truckRepo;
    use UploadableTrait;

    /**
     * Constructeur
     */
    public function __construct(TruckRepositoryInterface $capacityRepository)
    {
        $this->truckRepo = $capacityRepository;
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

    public function uploadFiles()
    {
        # code...
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
        $lslip = $this->truckRepo->update($request->all(),$request->id);

        return response()->json([
            'message'=>"Camion mise à jour"
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
    }
}
