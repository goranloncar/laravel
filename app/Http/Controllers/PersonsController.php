<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\PublitioAPI;

class PersonsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = Person::all();
        
        return view('person',compact('persons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')) {
            $this->validate($request, [
                'image' => 'file|mimes:jpeg,jpg,png',
                'name' => 'required',
                'email' => 'required|max:191|email|unique:users,email'
            ]);
            $person = new Person;

            //$person->image = request('image');
            $person->name = request('name');
            $person->email = request('email');

            $image = $person->image;
            //$image = request('image');
            if ($request->hasFile('image')) {
//                $publitio_api  = new PublitioAPI('ihjdi3bhbuPihHT0scQa','G9bjB6x14tWcB8gPZhZ1Dy9PbRPtVrup');
                //    $currentDir = getcwd();
                //  $uploadDirectory = config('filesystems.pages-uploads-path');
//                $errors = []; // Store all possible errors here
//                $fileExtensions = ['jpeg','jpg','png', 'webp']; // Show only this extensions and make sure we upload only them
//                $fileName = $_FILES['image']['name'];
//                $fileSize = $_FILES['image']['size'];
//                $fileTmpName = $_FILES['image']['tmp_name'];
//                $fileType = $_FILES['image']['type'];
//                $fileExtension = @strtolower(end(explode('.',$fileName)));
//
//                    if (! in_array($fileExtension,$fileExtensions)) {
//                        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
//                    }
//                    if ($fileSize > 5000000000) {
//                        $errors[] = "This file is more than 5GB. Sorry, it has to be less than or equal to 5000MB";
//                    }
//                    if (empty($errors)) {
//                        //dd($image);
//                        $response = $publitio_api->upload_file($fileTmpName, "file");
//                        dd($response);
//                    } else {
//                        foreach ($errors as $error) {
//                            echo $error . "These are the errors" . "\n";
//                        }
//                    }

                $directory = config('filesystems.uploads-path');
                $fileName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path($directory), $fileName);
                $image =  $directory . $fileName;

            }


            $person->image = $image;

            $person->save();

            session()->flash('message','Thank you for adding person.');

        }

        return back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
        return redirect('/people')->with('message','You delete a person');
    }
}
