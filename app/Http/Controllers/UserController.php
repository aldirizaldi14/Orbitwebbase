<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Model\UserModel;
use Session;
use Storage;
use DB;
use Response;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.user');
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'user_username'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(user_username) LIKE '%".strtolower($filter)."%'
            OR LOWER(user_fullname) LIKE '%".strtolower($filter)."%'
        )");

        $data = UserModel::orderBy($sort, $dir)
            ->whereRaw($filter);
        if ($length) {  
            $data->skip($start)->take($length); 
        }
        $data = $data->get();
        
        $count = UserModel::whereRaw($filter)
            ->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];

        return $result;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'user_username' => 'required',
            'user_fullname' => 'required',
            'user_group_id' => 'required',
            'user_password' => 'required',
        ]);
        $data = new UserModel;
        $data->user_created_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }
        return $response;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'user_username' => 'required',
            'user_fullname' => 'required',
            'user_group_id' => 'required',
        ]);

        $data = UserModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->user_updated_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }

        return $response;
    }

    private function save(Request $request, UserModel $data)
    {
        $data->user_username = $request->input('user_username');
        $data->user_fullname = $request->input('user_fullname');
        $data->user_group_id = $request->input('user_group_id');
        if($request->input('user_password')){
            $data->user_password = bcrypt($request->input('user_password'));
        }
        $process = $data->save();

        return $process;
    }

    public function delete($id, Request $request)
    {
        $data = UserModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->user_updated_by = $request->user()->user_username;
        $data->save();
        $process = $data->delete();
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Data berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Data gagal dihapus'];
        }

        return $response;
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
        $mc = 'D';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$mc.'1');
        $sheet->getStyle('A1:'.$mc.'1')->applyFromArray($style);
        $sheet->setCellValue('A1', '');

        $spreadsheet->getActiveSheet()->mergeCells('A2:'.$mc.'2');
        $sheet->getStyle('A2:'.$mc.'2')->applyFromArray($style);
        $sheet->setCellValue('A2', 'User Data');

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
            switch ($sub->user_group_id) {
                case '1':
                    $group = 'System Admin';
                    break;
                case '2':
                    $group = 'Production';
                    break;
                case '3':
                    $group = 'Warehouse';
                    break;
                case '9':
                    $group = 'Viewer';
                    break;
                default:
                    $group = '';
                    break;
            }
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $sub->user_username);
            $sheet->setCellValue('C'.$i, $sub->user_fullname);
            $sheet->setCellValue('D'.$i, $group);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'user.xlsx';
        $writer->save(storage_path('app/public').$path.$filename);

        return Response::download(storage_path('app/public').$path.$filename);
    }
}
