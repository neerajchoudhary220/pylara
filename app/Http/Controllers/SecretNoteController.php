<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Secretnote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SecretNoteController extends Controller
{
    public function index()
    {
        $page = "create_secret_notes";
        return view('secret_note.index', compact('page'))->with('success', 'Welcome Secret Notepad');
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notes' => ['required', 'string', 'min:2', 'max:20000']
        ],[
            'notes.required'=>'Please write some text'
        ]);
        $errors=[]; $msg ='Success';

        if ($validator->fails()) {
            // return back()->withErrors($validator->errors());
            $msg ='Error';
            $errors = $validator->errors();

            return response()->json([
                'msg'=>$msg,
                'errors'=>$errors,
                'link'=>null,
            ]);
        }



        $data = $request->except('_token');
        $random = rand(100, 1000);
        $data['link_token'] = $random;
        $data['link'] = route('secret.notepad.privatelink', $random);
        $notes = Secretnote::create($data);

        return response()->json([
            'msg'=>$msg,
            'errors'=>$errors,
            'link'=>$notes->link
        ]);
    }
    public function view(Secretnote $notes)
    {
        $notes = $notes->where('expired', false)->get();
        return view('secret_note.view', compact('notes'));
    }
    public function privatelink(Request $request)
    {
        $notes = Secretnote::where('link_token',$request->e)->first();
        if(!$notes){
            return "Not Found";
        }
        if($notes->expired){
            $create_new_note = route('secret.notepad');
            return "link Expired<br> <a href='$create_new_note'><Create New Secret Note/a>";
        }

        $notes->update(['expired'=>true]);
        return view('secret_note.link-details',compact('notes'));
    }
}
