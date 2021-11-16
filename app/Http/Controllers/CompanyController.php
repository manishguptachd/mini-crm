<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Validator;
use Image;
// use Intervention\Image\Facades\Image as Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_list = Company::orderBy('id','desc')->simplePaginate(10);
        return view('company', compact('company_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'website' => 'required|string'
            ]);

            if($validator->passes())
            {
                if(!empty($request))
                {
                    $imageName = time().'.'.$request->file->extension();
                    $files = $_FILES;
                    $data['destination'] = storage_path('app/public/');
                    $data['filetype']   = $files['file']['type'];
                    $data['path']       = $files['file']['tmp_name'];
                    $data['filename']   = $files['file']['name'];

                    if(file_exists($data['destination']))
                    {
                        $img = \Image::make($data['path'])->resize(100, 100)->save(storage_path() .'/app/public/'.$imageName);
                    }

                    // storage/app/images/file.png
                    $path = '/app/public/'.$imageName;

                    $company = Company::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'logo' => $path,
                        'website' => $request->website,
                    ]);

                    return response()->json(array('success' => true, 'msg' => 'Company created successfully.'));
                }
            }
            
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::find($id);
        $data->toArray();

        return response()->json(['success' => true, 'data' => $data]);        
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
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'website' => 'required|string'
            ]);

            if($validator->passes())
            {
                if(!empty($request))
                {
                    $company = Company::where('id', $id)->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'website' => $request->website,
                    ]);

                    return response()->json(array('success' => true, 'msg' => 'Company updated successfully.'));
                }
            }
            
        }
        catch (\Exception $e) 
        {
            return response()->json(array('success' => false, 'msg' => 'Error on line '.$e->getLine().' in '.$e->getFile().': <b>'.$e->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Company::find($id)->delete();
     
        return response()->json(['success' => true, 'msg' => 'Company deleted successfully.']);
    }
}
