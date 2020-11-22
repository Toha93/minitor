<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendMessege;
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

    public function checkSite(mailController $mail)  //Основной метод. Внедряем объект класса отвечающего за отправку Email
    {
        $data = $this->getData();
        foreach ($data as $elem)
        {

            $check = $this->check($elem->URL);
            $name = $elem->name;
            $url = $elem->URL;
            $text = '';
            if ($check=='FAIL') //Если сайт недоступен обращаемся к методу SendMessege для постановки в очеердь отправки сообщения
            {
                $text .= $name.', '; //формируем текст со списком недоступных сайтов
                $send = new SendMessege($mail, $text);
                $send->handle();
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
        if(!filter_var($url, FILTER_VALIDATE_URL)){    //честно стыренная (и проверенная на хостинге)с интерне функция по проверки доступности сайтов
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
        curl_close($curlInit);

        return $response ? 'OK' : 'FAIL';
    }

}
