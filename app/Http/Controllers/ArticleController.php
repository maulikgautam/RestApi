<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Validator;
use DB;


class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }
    /*public function where($id)
    {
        return Article::find($id);
    }*/
    public function where(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required'
        ]);    
        if ($validator->fails()) {
            // get first error message
            $error = $validator->errors()->first();
            // get all errors 
            //$errors = $validator->errors()->all();
            return response()->json([
                //"success" => false,
               // "message" => "Validation Error",
                "error" => $error 
            ]);
        }else{

           $data= DB::table('articles')->where('id',$request->input('id'))->first();
           if($data){
                 return response()->json($data) ;
           }else{
               return  'wrong id';
           }

        }            
       //// return $article;
    }
    /*public function store(Request $request)
    {
        return Article::create($request->all());
    }*/
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'body'=>'required'
        ]);
    
        if ($validator->fails()) {
            // get first error message
            $error = $validator->errors()->first();
            // get all errors 
            //$errors = $validator->errors()->all();
            return response()->json([
                //"success" => false,
               // "message" => "Validation Error",
                "error" => $error 
            ]);
        }else{

        $article = Article::create($request->all());
        if(!empty($article->id)){
        return response()->json(['Success'=>'data added'], 201);
        }else{
            return response()->json(['Error'=>'data not added.Try again'],404 );
        }
        }
    }

    /*public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return $article;
    }*/
    public function update(Request $request)
    {
        //$name = $request->all('title');
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'id'=>'required'
        ]);
    
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                "error" => $error 
            ]);
        }
       $result= DB::table('articles')->where('id',$request->input('id'))->update(['title' => $request->input('title')]);

        ///Article::where('id',$id)->update(['title' => $name]);

      ///DB::update('update articles set title = ? where id = ?',[$name,$id]);
      if($result){
        return response()->json(['Success'=>'data updated'], 200);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
       /// return response()->json(['Success'=>'data updated'], 200);
    }



    /*public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return 204;
    }*/
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required'
        ]);
    
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                "error" => $error 
            ]);
        }
        $result=DB::table('articles')->where('id',$request->input('id'))->delete();
        if($result){
                return response()->json(['Success'=>'data deleted'], 200);
         }else{
                return response()->json(['Success'=>'cannot deleted.Try again'],404);
            }

    }


    public function like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required'
        ]);    
        if ($validator->fails()) {

            $error = $validator->errors()->first();
            return response()->json([
                "error" => $error 
            ]);
        }else{
            $search=$request->input('title');
           $data= DB::table('articles')->where('title','LIKE',"%{$search}%")->get();
           if($data){
                 return response()->json($data) ;
           }else{
               return  'wrong title';
           }

        }            
    }
    public function orderby(Request $request)
    {
        $result= DB::table('articles')->select('*')->orderBy('id','ASC')->get();
      if($result){
        return response()->json($result);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
                    
    }
    public function innerjoin(Request $request)
    {
        $result= DB::table('articles')
                ->select(['articles.id','users.name','articles.created_at'])
                ->join('users','articles.id','=','users.id')
                ->get();
      if($result){
        return response()->json($result);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
                    
    }

    public function leftjoin(Request $request)
    {
        $result= DB::table('users')
                ->select(['users.name','articles.id'])
                ->leftjoin('articles','articles.id','=','users.id')
                ->get();
      
      if($result){
        return response()->json($result);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
                    
    }

    public function rightjoin(Request $request)
    {
        $result= DB::table('articles')
                ->select(['articles.id','users.name'])
                ->rightjoin('users','articles.id','=','users.id')
                ->orderBy('users.id','ASC')
                ->get();
      
      if($result){
        return response()->json($result);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
                    
    }

    public function fullouterjoin(Request $request)
    {
        $union=DB::table('users')
                ->select(['users.name','articles.id'])
                ->rightjoin('articles','articles.id','=','users.id');

        $result= DB::table('users')
                ->select(['users.name','articles.id'])
                ->leftjoin('articles','users.id','=','articles.id')
                ->union($union)
                ->get();
      
      if($result){
        return response()->json($result);
     }else{
        return response()->json(['Success'=>'cannot update data.Try again'],404);
    }
                    
    }



}