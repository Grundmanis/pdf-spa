<?php

namespace App\Http\Controllers\API;

use App\Pdf;
use App\Services\PdfThumbCreator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{

    /**
     * @var Pdf
     */
    private $pdf;

    /**
     * @var PdfThumbCreator
     */
    private $pdfThumbCreator;

    /**
     * PdfController constructor.
     * @param Pdf $pdf
     * @param PdfThumbCreator $pdfThumbCreator
     */
    public function __construct(Pdf $pdf, PdfThumbCreator $pdfThumbCreator)
    {
        $this->pdf = $pdf;
        $this->pdfThumbCreator = $pdfThumbCreator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
           'pdfs' => $this->pdf->paginate(PDF::PER_PAGE)
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

        $thumb = $this->pdfThumbCreator->create($name);

        $pdf = $this->pdf->create([
            'url' => asset('storage/' . $name),
            'thumb' => $thumb
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
