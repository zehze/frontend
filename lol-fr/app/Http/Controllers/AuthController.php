<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function login(){
        $client=new Client([
            'base_uri'=>'http://127.0.0.1:8001',
            'timeout'=>2.0,
            ]);
            $response= $client->post('/api/login', [
                'form_params'=>[
                    'email'=>request('email'),
                    'password'=>request('password'),
                ],
            ]); 
            if($response->getStatusCode()===200){
                $body=json_decode($response->getBody(),true);
                $token=$body['success'];
                //dd($token);
                session(['success'=>$token]);
                return redirect()->route('home');
            }  
    }
    public function login_show(){
        return view('login');
    }
    public function register(){
        $client = new Client([
            'base_uri' => 'http://127.0.0.1:8001/api/register', // API'nin temel URL'si
            'timeout' => 5.0, // İsteklerin maksimum süresi
        ]);
    
        // Kaydedilecek kullanıcının verileri
        $data = [
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
            'c_password' => request('c_password'),
        ];
    
        // POST isteği gönderme
        $response = $client->post('register', [
            'form_params' => $data, // İstek gövdesinde gönderilecek veriler
        ]);
    
        // İstek sonucunu işleme
        if ($response->getStatusCode() === 200) {
            $body = json_decode($response->getBody(), true); // JSON cevabını PHP dizisine dönüştürme
            //echo "Yeni kullanıcı kaydedildi!\n";
            return view('/login');
    
            
        } else {
            $body = json_decode($response->getBody(), true);
           // echo "Kayıt hatası: ";
           return('/register');
        }
    }
    public function register_show(){
        return view('register');
    }

}
