<?php

namespace App\Http\Controllers;

use App\MeduzaNew;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MeduzaNewController extends Controller
{
    //
    /*
     * POST /news/update
     * Получение новостей с сайта meduza.io. Параметров запроса нет.
     */
    public function update()
    {
        try {
            $client = new Client;

            $response = $client->request(
                'GET',
                'https://meduza.io/api/v3/index',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                ]
            );

            $data = json_decode($response->getBody()->getContents());

            foreach ($data->documents as $id => $document) {
                if (isset($document->pub_date)) {
                    MeduzaNew::updateOrCreate(
                        [
                            'id' => $id
                        ],
                        [
                            'date' => $document->pub_date,
                            'title' => $document->title,
                            'url' => $document->url,
                            'image' => isset($document->image) ? $document->image->small_url : NULL,
                            'document_type' => $document->document_type,
                            'json' => $document
                        ]
                    );
                }
            }
        }
        catch (\Exception $e)
        {
            return response()->json([ 'success' => false, 'error' => $e->getMessage() ], 500);
        }
        return response()->json([ 'success' => true ]);
    }

    public function list(Request $request)
    {
        try
        {
            $type = $request->document_type ?? 'news';
            $news = MeduzaNew::whereDocumentType($type)
                ->whereDate('date', $request->day == 'today' ? Carbon::now() : $request->day )
                ->select('title', 'url')
                ->get();
            return response()->json([ 'success' => true, 'news' => $news ]);
        }
        catch (\Exception $e)
        {
            return response()->json([ 'success' => false, 'error' => $e->getMessage() ], 500);
        }
    }

    public function image($type, $id, $year = null, $month = null, $day = null)
    {
        $meduzaNew = $year
            ? MeduzaNew::find($type . '/' . $id . '/'. $year . '/' . $month . '/' . $day)
            : MeduzaNew::find($type . '/' . $id);
        $error = 'News with this Id is missing';
        if ($meduzaNew)
        {
            if ($meduzaNew->image)
            {
                $from = strrpos($meduzaNew->image, '/') + 1;
                $name = substr($meduzaNew->image, $from);
                Image::make('https://meduza.io' . $meduzaNew->image)->save($name);
                return response()->download($name)->deleteFileAfterSend();
            }
            $error = 'News without a picture';
        }
        return response()->json([ 'success' => false, 'error' => $error ], 422);
    }
}
