<?php

namespace App\Http\Controllers\Staf;

use App\Exports\PdfExport;
use App\Exports\StafExport;
use App\Http\Controllers\Controller;
use App\Models\Staf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StafExportController extends Controller
{
    /**
     * Summary of exportStaf
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportStaf(Request $request)
    {
        
        $status_deactive_staf = $request->status_deactive_staf;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;


        if ($status_deactive_staf == 1 && $status_deactive_staf !== null) {
            $title = "Report Staf Active";
            $staf = Staf::orderByDesc('created_at')->get();
            $name_pdf = "report-staf-active.pdf";
        } elseif ($status_deactive_staf == 0 && $status_deactive_staf !== null) {
            $title = "Report Staf Inactive";
            $name_pdf = "report-staf-inactive.pdf";
            $staf = Staf::onlyTrashed()->orderByDesc('created_at')->get();
        } elseif ($dateFrom && $dateTo) {
            $title = "Report Staf {$dateFrom} sampai {$dateTo}";
            $name_pdf = "report-staf-{$dateFrom}-{$dateTo}.pdf";
            $staf = Staf::whereBetween('created_at', [$dateFrom, $dateTo])->orderByDesc('created_at')->get();
        } else {
            $title = "Report All Staf";
            $name_pdf = "report-all-staf.pdf";
            $staf = Staf::withTrashed()->orderByDesc('created_at')->get();
        }
        $data = $staf->map(function ($staf) {
            $staf->profile = $staf->profile ??= "default.jpeg";
            $staf->created_at_human = $staf->created_at->diffForHumans();
            $staf->status_deactive_staf = $staf->deleted_at == null ? 1 : 0;
            return $staf;
        });

        $pdfExport = new PdfExport($data, $name_pdf, 'report.staf.pdf.content', $title);
        return $pdfExport->export();
    }

    public function exportExcelStaf(Request $request)
    {
        return Excel::download(new StafExport(
            $request->status_deactive_staf,
            $request->dateFrom,
            $request->dateTo
        ), $request->fileNameExport);
    }
}
