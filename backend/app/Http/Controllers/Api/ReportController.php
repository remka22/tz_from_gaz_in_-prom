<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Получаем продажи за последний месяц
        $sales = Sale::selectRaw('DATE(sale_date) as date, COUNT(*) as purchase_count')
            ->where('sale_date', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Проверяем, какой формат запрашивается (json или csv)
        $format = $request->query('format', 'json'); // По умолчанию 'json'

        if ($format === 'csv') {
            // Генерация CSV-файла
            $filename = 'sales_report_' . Carbon::now()->format('Y-m-d') . '.csv';
            $csvData = "Дата,Количество покупок\n";
            foreach ($sales as $sale) {
                $csvData .= "{$sale->date},{$sale->purchase_count}\n";
            }

            return Response::make($csvData, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$filename",
            ]);
        }

        // Если формат 'json' или по умолчанию
        if ($format === 'json') {
            return response()->json($sales);
        }

        // Если формат не распознан
        return response()->json(['error' => 'Invalid format'], 400);
    }

    // protected function generateCsv($sales)
    // {
    //     $csvFileName = 'daily_purchases_report_' . now()->format('Y_m_d_H_i_s') . '.csv';
    //     $handle = fopen('php://output', 'w');

    //     // Устанавливаем заголовки для CSV
    //     header('Content-Type: text/csv');
    //     header('Content-Disposition: attachment; filename="' . $csvFileName . '"');

    //     // Записываем заголовки
    //     fputcsv($handle, ['Sale Date', 'Purchase Count']);

    //     // Записываем данные
    //     foreach ($sales as $sale) {
    //         fputcsv($handle, [
    //             $sale->sale_date,
    //             $sale->purchase_count,
    //         ]);
    //     }

    //     fclose($handle);
    //     exit; // Завершаем выполнение скрипта после отправки CSV
    // }
}
