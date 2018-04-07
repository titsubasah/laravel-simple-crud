<?php namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\User;
use Session;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{

	}

    private function create()
    {

    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        if(!empty($id)){            
            return $this->update($id, $request);
        }
        
        $messages = [
            'uuid.required' => 'ID harus diisi!',
            'nama.required' => 'Nama harus diisi!',
            'alamat.required' => 'Alamat harus diisi!',
            'nama.unique' => 'Nama tersebut sudah ada, coba gunakan kode lain!',
            'uuid.unique' => 'ID tersebut sudah ada, coba gunakan kode lain!',
        ];
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|unique:user',
            'nama' => 'required|unique:user',
            'alamat' => 'required',
        ], $messages);
        
        if ($validator->fails()) {
            $result = [
                'error' => true,
                'error_list' => $validator->errors()
            ];
            return $result;
        }

        $user = new User();
        $uuid = $request->input('uuid');
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');        
        
        $user->uuid = $uuid;
        $user->nama = $nama;
        $user->alamat = $alamat;
        $user->save();
        
        $result = [
            'error' => false,
            'flash_message' => "User has been created",
            'user' => $user
        ];

        return $result;
    }

    public function edit($id, Request $request)
    {        
        $contextTitle = 'User';
        $contextAction = 'Edit';        
        
        $user = User::where('uuid', '=', $id)->firstOrFail();        
    	// return view('user.edit')
        // 		->with('user', $user);    	
        return $user;
    }

    private function update($id, Request $request)
    {
        
        $messages = [            
            'nama.required' => 'Nama harus diisi!',
            'alamat.required' => 'Alamat harus diisi!',
            
        ];
        
        $validator = Validator::make($request->all(), [        
            'nama' => 'required',
            'alamat' => 'required',
        ], $messages);
        
        if ($validator->fails()) {                        
            $result = [
                'error' => true,
                'error_list' => $validator->errors()
            ];
            return $result;
        }

        $user = User::findOrFail($id);        
        
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $user->nama = $nama;
        $user->alamat = $alamat;
        
        $user->save();
        
        $result = [
            'error' => false,
            'flash_message' => "User has been updated",
            'user' => $user
        ];

        return $result;
    }

    public function show($id, Request $request)
    {

    }

    public function destroy($id, Request $request)
    {
        $nerd = User::findOrFail($id);
        $nerd->delete();

        return ['flash_message' => "User has been deleted"];
    }


}
