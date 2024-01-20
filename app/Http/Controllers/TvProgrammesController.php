<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\TvProgrammes;
use Illuminate\Support\Facades\Validator;

class TvProgrammesController extends Controller
{
    /**
     * Show on air programmes - return in json
     * @param int $channelNr
     * @return string
     */
    public function onAir(int $channelNr): string {
        $tvProgrammesModel = new TvProgrammes();
        return $tvProgrammesModel->getOnAirProgrammes($channelNr);
    }

    /**
     * Show 'today' programmes for concrete channel by date - return in json
     * @param int $channelNr
     * @param string $date
     * @return string
     */
    public function guide(int $channelNr, string $date):string {
        $validator = Validator::make(['date' => $date], [
            'date' => 'required|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $tvProgrammesModel = new TvProgrammes();
        return $tvProgrammesModel->getGuide($channelNr, $date);
    }

    /**
     * Show 10 upcoming programmes for concrete channel start with on-air programme - return in json
     * @param int $channelNr
     * @return string
     */
    public function upcoming(int $channelNr):string {
        $tvProgrammesModel = new TvProgrammes();
        return $tvProgrammesModel->upcomingProgrammes($channelNr);    }

    /**
     * Add new programme to database, validate fields, return created record in json
     * In the future: move validation to requestRule file.
     * @param Request $request
     * @return JsonResponse
     */
    public function addProgram(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'channel_nr' => 'required|regex:/^[1-3]+/',
            'name' => 'required|max:100',
            'begin_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $tvProgrammesModel = new TvProgrammes();
        return $tvProgrammesModel->addNewProgramme($request);
    }
}
