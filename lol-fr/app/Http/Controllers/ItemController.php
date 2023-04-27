<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            $yol= Http::get('http://127.0.0.1:8001/api/items')->json();
           
            
            return view ('item',compact('yol') );
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = [
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'quantity'=>$request->quantity
        ];
    
        $yol = Http::post('http://127.0.0.1:8001/api/item', $data)->json();
    
        $yol = Http::get('http://127.0.0.1:8001/api/items')->json();

        // item.blade.php görünümüne tüm öğeleri aktarın
        return view('item', compact('yol'));
 
       
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client();
        $yol = $client->get("http://127.0.0.1:8001/api/item/{$id}");
        $item = json_decode($yol->getBody(), true)['item'];
    
        return view('edit', compact('item'));
    }
    
    public function update(Request $request, $id)
    {
        $client = new Client();
        $yol = $client->put("http://127.0.0.1:8001/api/item/{$id}", [
            'form_params' => [
                'name' => $request->input('name'),
                'quantity' => $request->input('quantity'),
                'description' => $request->input('description'),
            ],
        ]);
    
        return redirect()->back()->with('success', 'Ürün güncellendi.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id){
        $yol = Http::withToken(session('token'))->delete('http://127.0.0.1:8001/api/items/'.$id);
    
        if ($yol->status() === 204) {
            return response()->json([
                'message' => 'silindi',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'silinemedi',
            ], 500);
    
        }
    }


}
