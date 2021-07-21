<?php

namespace App\Http\Controllers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Credentias;
use Illuminate\Http\Request;


class CredentiasController extends Controller
{
    public function setCredentias(Request $request)
    {
//        echo '<pre>';
//        var_dump($request->all());
//        echo '</pre>';
//        die();

        $record = new Credentias;
        $record->domain = $request->DOMAIN;
        $record->lang = $request->LANG;
        $record->app_sid = $request->APP_SID;
        $record->auth_id = $request->AUTH_ID;
        $record->auth_expire = $request->AUTH_EXPIRES;
        $record->refresh_id = $request->REFRESH_ID;
        $record->member_id = $request->member_id;
        $record->save();

        return view('install.install');
    }

    public function getUser()
    {
        $record = Credentias::oldest()
                            ->first();

        $arParams['B24_APPLICATION_ID'] = 'local.60f6f2cf9f75e2.74118486';
        $arParams['B24_APPLICATION_SECRET'] = 'RIANpCVgdOmh0nwdW09oP6zMNgDfbhka0SXAAXTw5CRdIZ3egw';
        $arParams['B24_APPLICATION_SCOPE'] = array('user');

// create a log channel
        $log = new Logger('bitrix24');
        $log->pushHandler(new StreamHandler('path/to/your.log', Logger::DEBUG));

// init lib
        $obB24App = new \Bitrix24\Bitrix24(false, $log);
        $obB24App->setApplicationScope($arParams['B24_APPLICATION_SCOPE']);
        $obB24App->setApplicationId($arParams['B24_APPLICATION_ID']);
        $obB24App->setApplicationSecret($arParams['B24_APPLICATION_SECRET']);

// set user-specific settings
        $obB24App->setDomain($record->domain);
        $obB24App->setMemberId($record->member_id);
        $obB24App->setAccessToken($record->auth_id);
        $obB24App->setRefreshToken($record->refresh_id);

// get information about current user from bitrix24
        $obB24User = new \Bitrix24\User\User($obB24App);
        $arBX24Users = $obB24User->get('', '', '');


        return view('userList.index', ['credentias' => $arBX24Users]);
    }
}
