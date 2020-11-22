<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    private function getData()
    {
        return DB::table('monitor')->get();
    }


    public function add(Request $request)
    {

        if ($request->isMethod('post') and ($request->has('name')) and ($request->has('URL'))) {
            DB::table('monitor')->insert(
                ['name' => $request->input('name'), 'URL' => $request->input('URL')]
            );
        }
        return redirect('/');
    }

    public function del($name)
    {
        DB::table('monitor')->where('name', '=', $name)->delete();
        return redirect('/');
    }

    public function checkSite(mailController $mail)
    {
        $data = $this->getData();
        foreach ($data as $elem)
        {
            $check = $this->check($elem->URL);
            $name = $elem->name;
            $url = $elem->URL;
            if ($check=='FAIL')
            {
                $mail->send($name);
            }
            $arr[] = [
                'name' => $name,
                'URL' => $url,
                'check' => $check
            ];
        }
        return view('monitor', ['monitor'=>$arr]);
    }

    private function check($url)
    {
        /*if(!filter_var($url, FILTER_VALIDATE_URL)){
            return false;
        }

        // Инициализация cURL
        $curlInit = curl_init($url);

        // Установка параметров запроса
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        // Получение ответа
        $response = curl_exec($curlInit);

        // закрываем CURL
        curl_close($curlInit);*/

        return 'OK'; //$response ? 'OK' : 'FAIL';
    }

}
