<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\ModelBook;
use App\Models\User;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{

    private $objUser;
    private $objBook;

    public function __construct()
    {
        $this->objUser=new User();
        $this->objBook=new ModelBook();
    }

    public function index()
    {
        $book=$this->objBook->paginate(2);
        //$book=ModelBook::all();
        return view('index',compact('book'));
    }

    public function create()
    {

        $users=$this->objUser->all();
        return view('create',compact('users'));
    }

    public function store(BookRequest $request)
    {
        $cad=$this->objBook->create([
           'title'=>$request->title,
           'pages'=>$request->pages,
           'price'=>$request->price,
           'id_user'=>$request->id_user
        ]);
        if($cad){
            return redirect('books');
        }
    }

    public function show($id)
    {
        $book=ModelBook::find($id);
        return view('show',compact('book'));
    }

    public function edit($id)
    {
        $book=$this->objBook->find($id);
        $users=$this->objUser->all();
        return view('create',compact('book','users'));
    }

    public function update(BookRequest $request, $id)
    {
        $this->objBook->where(['id'=>$id])->update([
            'title'=>$request->title,
            'pages'=>$request->pages,
            'price'=>$request->price,
            'id_user'=>$request->id_user
        ]);
        return redirect('books');
    }

    public function destroy($id)
    {
        $del=$this->objBook->destroy($id);
        return($del)?"sim":"não";
    }
}
