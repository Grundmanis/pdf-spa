<?php

namespace App\Http\Controllers\API;

use App\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{

    /**
     * @var Pdf
     */
    private $pdf;

    /**
     * PdfController constructor.
     * @param Pdf $pdf
     */
    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
           'pdfs' => $this->pdf->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request
            ->file('pdf')
            ->store('pdfs');

        // TODO refactor

        $pdfName = str_replace('.pdf', '', $name);
        $imgName = 'img/' . $pdfName . '.jpg';

        $image = new \Imagick(storage_path('app/' . $name . '[0]'));
        $image->setImageColorspace(255); // prevent image colors from inverting
        $image->setimageformat("jpeg");
        $image->thumbnailimage(60, 120);
        $image->writeimage($imgName);

        $pdf = $this->pdf->create([
            'url' => $name,
            'thumb' => $imgName
        ]);

        return response()->json([
            'pdf' => $pdf
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
