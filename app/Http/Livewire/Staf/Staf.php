<?php

namespace App\Http\Livewire\Staf;

use App\Exports\StafExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use function GuzzleHttp\Promise\all;

class Staf extends Component
{
    use WithPagination;

    // set status deactive
    public $status_deactive_staf;

    // listener event
    protected $listeners = ['activedStaf', 'deactiveStaf', 'deletedStaf', 'filterStatus', 'exportPdf', 'exportExcel'];

    // mount
    public function mount()
    {
        $this->status_deactive_staf = null;
    }

    // delete staf inactive
    public function deactiveStaf($stafId)
    {
        $staf = \App\Models\Staf::find($stafId);
        if ($staf) {
            $staf->delete();
            session()->flash('message', "Staf $staf->nama inactive successfully!");
        } else {
            session()->flash('error', 'Staf not found!');
        }
    }

    // restore staf active
    public function activedStaf($stafId)
    {
        $staf = \App\Models\Staf::onlyTrashed()->find($stafId);
        if ($staf) {
            $staf->restore();
            session()->flash('message', "Staf $staf->nama active successfully!");
        } else {
            session()->flash('error', 'Staf not found!');
        }
    }

    // delete permanen staf
    public function deletedStaf($stafId)
    {
        $staf = \App\Models\Staf::withTrashed()->find($stafId);
        $pemrosessanBarang = \App\Models\PemrosessanBarang::where('id_staf', $stafId)->get();

        $masihBerlangsung = $pemrosessanBarang->contains(function ($item) {
            return $item->status_proses !== 'diterima';
        });

        if ($masihBerlangsung) {
            session()->flash('error', 'Staf tidak bisa dihapus karena masih ada proses barang yang belum selesai.');
            return;
        }
        foreach ($pemrosessanBarang as $pemrosessan) {
            $pemrosessan->delete();
        }

        if ($staf) {
            $staf->forceDelete();
            session()->flash('message', "Staf berhasil dihapus permanen!");
        } else {
            session()->flash('error', 'Staf tidak ditemukan!');
        }
    }



    // filtering status
    public function filterStatus($status)
    {
        if ($status === '1') {
            $this->status_deactive_staf = 1;
        } elseif ($status === '0') {
            $this->status_deactive_staf = 0;
        } else {
            $this->status_deactive_staf = null;
        }
    }


    // data staf
    public function dataStaf()
    {
        if ($this->status_deactive_staf === 1) {
            $staf = \App\Models\Staf::paginate(5);
        } elseif ($this->status_deactive_staf === 0) {
            $staf = \App\Models\Staf::onlyTrashed()->paginate(5);
        } else {
            $staf = \App\Models\Staf::withTrashed()->paginate(5);
        }

        // $staf->appends(request()->query());
        // $staf->

        return $staf->through(function ($staf) {
            $staf->profile = $staf->profile ??= "default.jpeg";
            $staf->created_at_human = $staf->created_at->diffForHumans();
            $staf->status_deactive_staf = $staf->deleted_at === null ? 1 : 0;
            return $staf;
        });
    }


    // file name
    private function fileNameExport($file)
    {
        return $this->status_deactive_staf === null ? "report-staf-all.{$file}" : (
            $this->status_deactive_staf === 1 ? "report-staf-active.{$file}" : "report-staf-inactive.{$file}"
        );
    }

    // export pdf
    public function exportPdf()
    {
        if ($this->status_deactive_staf === 1) {
            $staf = \App\Models\Staf::all();
        } elseif ($this->status_deactive_staf === 0) {
            $staf = \App\Models\Staf::onlyTrashed()->get();
        } else {
            $staf = \App\Models\Staf::withTrashed()->get();
        }
        $data = $staf->map(function ($staf) {
            $staf->profile = $staf->profile ??= "default.jpeg";
            $staf->created_at_human = $staf->created_at->diffForHumans();
            $staf->status_deactive_staf = $staf->deleted_at === null ? 1 : 0;
            return $staf;
        });

        $name_pdf = $this->fileNameExport('pdf');

        $title = $this->status_deactive_staf === null ? 'Report staf All' : (
            $this->status_deactive_staf === 1 ? 'Report staf Active' : 'Report staf Inactive'
        );

        $mpdf = new Mpdf();
        $mpdf->WriteHTML(view('report.staf.pdf.content', [
            'data' => $data,
            'title' => $title
        ]));
        return response()->stream(
            function () use ($mpdf, $name_pdf) {
                $mpdf->Output($name_pdf, 'I');
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "inline; filename=$name_pdf",
            ]
        );
    }

    // export excel
    public function exportExcel()
    {
        return Excel::download(new StafExport($this->status_deactive_staf), $this->fileNameExport('xlsx'));
    }

    // render
    public function render()
    {
        return view('livewire.staf.staf', [
            'staf' => $this->dataStaf()
        ]);
    }
}
