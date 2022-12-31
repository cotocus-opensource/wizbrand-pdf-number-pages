<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
// require_once('vendor/autoload.php');


class mainController extends Controller
{
    public function index(){
        return view('index');
    }

    public function upload(Request $req){
        $req->validate([
            'pdf'=>"file",

        ]);
        $originalName = $req->file('pdf')->getClientOriginalName();
        $filename = time()."file.". $req ->file('pdf')->getClientOriginalExtension();  //setting filename
        $relativeFilepath =  $req->file('pdf')->storeAs('uploads', $filename);
        $extensionOfFile = $req->file('pdf')->getClientOriginalExtension();

        $filepath = storage_path("app\uploads\\".$filename);   // Total file path
        $fileOutputPath = storage_path("app\uploads\\".$originalName);  // Output file path should be this
        //Check upload is pdf?
        if($extensionOfFile == 'pdf'){
            $this->ModifyPdf($filepath, $fileOutputPath, $req['position'], $req['fontsize']);
            return response()->file($fileOutputPath);
        }
        else{
            // Upload only PDf
            session()->flash("errorMsg", "Please upload only PDF file");
            return redirect()->back();
        }
    }

    public function ModifyPdf($filepath, $fileOutputPath, $position, $fontsize){
        $fpdi = new Fpdi();

        $count = $fpdi->setSourceFile($filepath);
        for ($i=1; $i <= $count; $i++) { 
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);

            // $size container orienttaion, height, width of tamplate
            // apply size to new generated template
            $fpdi->addPage($size["orientation"], array($size["width"], $size["height"]));
            $fpdi->useTemplate($template);

            $fpdi->SetFont('helvetica','',$fontsize);
            // set position
            switch ($position) {
                case 'T':
                    $x = $size['width']/2;
                    $y = 10;
                    break;
                case 'TR':
                    $x = $size['width']-15;
                    $y = 10;
                    break;
                case 'TL':
                    $x = 15;
                    $y = 10;
                    break;
                case 'BR':
                    $x = $size['width']-15;
                    $y = $size['height']-10;
                    break;
                case 'BL':
                    $x = 15;
                    $y = $size['height']-10;
                    break;
                default:
                    $x = $size['width']/2;
                    $y= $size['height']-10;
                    break;
            }
            $text = "$i/$count";

            $fpdi->Text($x, $y, $text);  // add text
        }
        return $fpdi->Output($fileOutputPath, "F");
    }
}
