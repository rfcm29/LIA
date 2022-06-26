<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Redirect;
use PDF;
   
class PdfController extends Controller
{
   
    public function pdfForm()
    {
        return view('.pdf.pdf');
    }
 
    public function pdfDownload(Request $request){
 
       
       $pdf = PDF::loadView('.pdf.pdfDownload');
   
       return $pdf->download('Requisicao.pdf');
    }
    
 
}

