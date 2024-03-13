<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\UpdateUrlRequest;
use App\Models\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUrlRequest $request): RedirectResponse
    {
        $request->validate([
            "url" => ['required', 'url:http,https']
        ]);

        //crypt($request->url, 100)
        //md5($request->url)
        //crc32($request->url)
//        $key = env("VIRUS_TOTAL_KEY", null);
//        if ($key == "") {
//            $key = null;
//        }
//        if ($key == null) {
//            dd("Add VIRUS_TOTAL_KEY in .env file");
//        }
//        $response = Http::withHeaders([
//            "x-apikey" => $key
//        ])->get('https://www.virustotal.com/api/v3/analyses/u-51c26ffaa37c7a019a6fc71fa5266034b768d312df8fe49f5926cef49b5f9b47-1710343281');
//
//        $body = json_decode($response->body());
//
//
//        dd($body->data->attributes->malicious);
        ///////// virus total async processing does not fit with sync style of this application//////////

//        dd($key);

        $good = null;
        $exists = Url::where("org_url", $request->url)->first();
        //dd($exists);
        if ($exists) {
           $good = $exists->new_url;



        } else {
//            $urls = Url::orderBy('created_at', 'desc')->get();
//            return Inertia::render('Home', [
//                'added' => $url,
//                'urls' => $urls
//            ]);
            $latest = Url::latest()->first();
            $url = $this->convBase($latest->id ?? 0, "0123456789", "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");

            //dd($latest);
            Url::create([
                "org_url" => $request->url,
                "new_url" => $url
            ]);

            $good = $url;

        }



        return to_route('home')->with([
            "good" => $good
        ]);


//        return redirect()->route('home', [
//            "good" => "sfsdfsdfsdfsd"
//        ]);
//        return to_route('home')->withInput([
//            "good" => "sfsdfsdfsdfsd"
//        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url, string $id): RedirectResponse
    {
        $url = Url::where("new_url", $id)->first();
        return Redirect::to($url->org_url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUrlRequest $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        //
    }


    function convBase($numberInput, $fromBaseInput, $toBaseInput)
    {
        if ($fromBaseInput==$toBaseInput) return $numberInput;
        $fromBase = str_split($fromBaseInput,1);
        $toBase = str_split($toBaseInput,1);
        $number = str_split($numberInput,1);
        $fromLen=strlen($fromBaseInput);
        $toLen=strlen($toBaseInput);
        $numberLen=strlen($numberInput);
        $retval='';
        if ($toBaseInput == '0123456789')
        {
            $retval=0;
            for ($i = 1;$i <= $numberLen; $i++)
                $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
            return $retval;
        }
        if ($fromBaseInput != '0123456789')
            $base10=convBase($numberInput, $fromBaseInput, '0123456789');
        else
            $base10 = $numberInput;
        if ($base10<strlen($toBaseInput))
            return $toBase[$base10];
        while($base10 != '0')
        {
            $retval = $toBase[bcmod($base10,$toLen)].$retval;
            $base10 = bcdiv($base10,$toLen,0);
        }
        return $retval;
    }
}
