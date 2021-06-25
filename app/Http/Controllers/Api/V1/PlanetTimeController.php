<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Libs\PlanetTimeFactory;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlanetTimeController extends Controller
{
    //
    private $form_rules = [
        'earthDate'        => 'date_format:j M Y G:i:s T',

    ];
    public function getPlanetTime(String $planet,Request  $request):?String{
        try {
            //Validate the dateTime request format
           $this->validate($request, $this->form_rules);
           //get the PlanetTime Object
            $oPlantTime=PlanetTimeFactory::getPlanetTimeObject($planet  );
           $aPlanetTimeResponse =  $oPlantTime->timeConverter(new DateTimeImmutable($request->earthDate));
            return response()->json(['data'=>$aPlanetTimeResponse],200)->getContent();;
        } catch (ValidationException $e) {
            return response()->json(['errorMsg' => $e->getMessage()], 400)->getContent();;
        }catch (Exception $exception){
            return response()->json(['errorMsg' => $exception->getMessage()], 400)->getContent();;
        }
    }
}
