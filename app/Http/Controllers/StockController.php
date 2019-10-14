<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Model\AreaProductQty;
use Session;
use Storage;
use DB;
use Response;

class StockController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.stock');
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'area_name'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(area_name) LIKE '%".strtolower($filter)."%'
            OR LOWER(product_code) LIKE '%".strtolower($filter)."%'
            OR LOWER(product_description) LIKE '%".strtolower($filter)."%'
        )");

        $data = AreaProductQty::orderBy($sort, $dir)
            ->whereRaw($filter)
            ->leftJoin('area', 'area.area_id', '=', 'area_product_qty.area_id')
            ->leftJoin('warehouse', 'warehouse.warehouse_id', '=', 'area.area_warehouse_id')
            ->leftJoin('product', 'product.product_id', '=', 'area_product_qty.product_id');
        if ($length) {  
            $data->skip($start)->take($length); 
        }
        $data = $data->get();
        
        $count = AreaProductQty::whereRaw($filter)
            ->leftJoin('area', 'area.area_id', '=', 'area_product_qty.area_id')
            ->leftJoin('warehouse', 'warehouse.warehouse_id', '=', 'area.area_warehouse_id')
            ->leftJoin('product', 'product.product_id', '=', 'area_product_qty.product_id')
            ->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];

        return $result;
    }

    public function export(Request $request)
    {
        $data = $this->data($request);

        $tanggal = date('Y-m');
        $tanggal = explode('-', $tanggal);
        $path = '/files/'.$tanggal[0].'/'.$tanggal[1].'/';
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path, $mode = 0744, true, true);
        }

        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );

        setlocale(LC_TIME, 'id_utf8', 'Indonesian', 'id_ID.UTF-8', 'Indonesian_indonesia.1252', 'WINDOWS-1252');
        $mc = 'C';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$mc.'1');
        $sheet->getStyle('A1:'.$mc.'1')->applyFromArray($style);
        $sheet->setCellValue('A1', '');

        $spreadsheet->getActiveSheet()->mergeCells('A2:'.$mc.'2');
        $sheet->getStyle('A2:'.$mc.'2')->applyFromArray($style);
        $sheet->setCellValue('A2', 'Stock Data');

        $spreadsheet->getActiveSheet()->mergeCells('A3:'.$mc.'3');
        $sheet->setCellValue('A3', '');

        $spreadsheet->getActiveSheet()->mergeCells('A4:'.$mc.'4');
        $sheet->getStyle('A4:'.$mc.'4')->applyFromArray($style);
        $sheet->setCellValue('A4', 'Download Time : '. strftime('%A, %d-%m-%Y %H:%M:%S'));

        $sheet->setCellValue('A5', '#');
        $sheet->setCellValue('B5', 'Name');
        $sheet->setCellValue('C5', 'Description');
        
        $data = $data['listData'];
        $i = 5;
        foreach ($data as $sub) {
            $no = $i-4;
            $i++;
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $sub->stock_code);
            $sheet->setCellValue('C'.$i, $sub->stock_time);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'stock.xlsx';
        $writer->save(storage_path('app/public').$path.$filename);

        return Response::download(storage_path('app/public').$path.$filename);
    }
}
