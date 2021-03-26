<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    /**
     * Metodo para generar la quotes de api de kanye
     */
    public function generator()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.kanye.rest/?format=text",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",            
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->searchQuote(Str::slug($response), $response);
        return $response;
    }

    /**
     * Metodo para buscar  los quotes e incrementar sus vistas o crear
     * quote
     */
    public function searchQuote($quoteSlug, $quote)
    {
        $data = Quote::where('slug', $quoteSlug)->first();
        if ($data == null ) {
            $quote = Quote::create([
                'description' => $quote,
                'slug' => $quoteSlug,
                'date_view' => date("Y-m-d"),
                'num_view' => 1
            ]);
        } else {
            $data->date_view =  date("Y-m-d");
            $data->num_view  = $data->num_view+1;
            $data->save();
        }
    }
}
