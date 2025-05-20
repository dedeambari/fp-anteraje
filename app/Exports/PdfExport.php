<?php

namespace App\Exports;

use Mpdf\Mpdf;

class PdfExport
{
	protected $data;
	protected string $title;
	protected string $fileName;
	protected string $locationView ;

	public function __construct($data, $fileName, $locationView, $title = null)
	{
		$this->data = $data;
		$this->fileName = $fileName;
		$this->locationView = $locationView;
		$this->title = $title;
	}

	public function export()
	{
		$mpdf = new Mpdf();

		$html = view($this->locationView, [
			'data' => $this->data,
			'title' => $this->title,
		])->render();

		$mpdf->WriteHTML($html);
		return response()->stream(
			function () use ($mpdf) {
				$mpdf->Output('', 'I');
			},
			200,
			[
				'Content-Type' => 'application/pdf',
				'Content-Disposition' => "inline; filename=\"{$this->fileName}.pdf\"",
			]
		);
	}
}

