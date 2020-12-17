<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailNotSendException;
use App\Gpp\Users\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CompanyApprouved;
use App\Traits\UploadableTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Gpp\Companies\Requests\UpdateCompanyRequest;
use App\Gpp\Companies\Requests\ApprouvedCompanyRequest;
use App\Gpp\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Gpp\Decisions\Repositories\Interfaces\DecisionRepositoryInterface;
use App\Mail\CompanyUnapprouved;

class CompanyController extends Controller
{

    use UploadableTrait;

    private $companyRepo;
    private $decisionRepo;

    /**
     * Constructeur
     */
    public function __construct(CompanyRepositoryInterface $companyRepository, DecisionRepositoryInterface $decisionRepository)
    {
        $this->companyRepo = $companyRepository;
        $this->decisionRepo = $decisionRepository;
    }

    public function index()
    {
        $companies = $this->companyRepo->findAll();
        return response()->json([
            'companies' => $companies,
        ]);
    }

    public function listTransporters()
    {
        $transporters = $this->companyRepo->listTransporters();
        return response()->json(['transporters' => $transporters],200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = $this->companyRepo->find($id);
        return response()->json([
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        if($request->file('file')){
            $filename_file_approval_file_pdf = Str::of('company_'.$request->id.'_'.strtolower(trim($request->social_reason)).'_'.'approval_file_pdf'.'_'.time())->slug('_').'.pdf';
            $request['approval_file_pdf'] = $filename_file_approval_file_pdf;
            $file_approval_file_pdf = $this->uploadOne($request->file('file'),'/company_files', $filename_file_approval_file_pdf, 'private');
        }
        $lslip = $this->companyRepo->update($request->all(),$id);
        return response()->json([
            'message'=>"Entreprise mise à jour"
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
        //
    }

    public function decision (ApprouvedCompanyRequest $request, $id) {
        $approuvedCompany = $this->companyRepo->approuved(
                [
                    "approuved" =>$request->decision,
                    "approuved_by" => $request->approuved_by,
                    "approuved_date" =>date("Y-m-d"),
                    "is_submit" => ($request->decision == 1) ? 1 : 0
                ]
            ,$id);
        
        if ($approuvedCompany) {
            $decision = $this->decisionRepo->save([
                "company_id" => $id,
                "user_id" => $request->user_id,
                "decision" => $request->decision,
                "motif" => $request->motif,
            ]);
        }

        $admin = User::where('role',"admin")->where('company_id',$id)->get("email");
        $company = $this->companyRepo->find($id);
        
        try {
            if ($request->decision == 1) {
                Mail::to($admin)->send(new CompanyApprouved([
                    'company'=>$company->social_reason,
                ]));
            } else {
                Mail::to($admin)->send(new CompanyUnapprouved([
                    'company'=> $company->social_reason,
                    "decision" => $request->decision,
                    "motif"=> $request->motif 
                ]));
            }
        } catch (\Throwable $th) {
            throw new EmailNotSendException($th);
        }
        
        return response()->json([
            'user'=> $admin[0]->email
        ],200);
    }

    public function download ($files)
    {
        return Storage::download("private/company_files/$files");
    }
}
