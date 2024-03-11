<?php

namespace App\Services;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductExportService
{
    public function exportToExcel(string $filename): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $activeSheet = $spreadsheet->getActiveSheet();

        $products = Product::with(['category:id,name', 'stock:id,product_id,quantity'])
            ->withCount('sales')
            ->get();

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $activeSheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Header
        $activeSheet->setCellValue('A1', 'Products');
        $activeSheet->setCellValue('B1', "Generated on " . now());
        $activeSheet->setCellValue('A3', 'Product Name');
        $activeSheet->setCellValue('B3', 'Category');
        $activeSheet->setCellValue('C3', 'Stock');
        $activeSheet->setCellValue('D3', 'Unit Price');
        $activeSheet->setCellValue('E3', 'Sales');
        $activeSheet->setCellValue('F3', 'Revenue');

        // Rows
        $row = 4;
        foreach ($products as $product) {
            $activeSheet->setCellValue("A{$row}", $product->name);
            $activeSheet->setCellValue("B{$row}", $product->category->name);
            $activeSheet->setCellValue("C{$row}", $product->stock->quantity);
            $activeSheet->setCellValue("D{$row}", number_format($product->price, 2));
            $activeSheet->setCellValue("E{$row}", $product->sales_count);
            $activeSheet->setCellValue("F{$row}", number_format($product->sales_count * $product->price, 2));

            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save(storage_path($filename));

        return response()->download(storage_path($filename))->deleteFileAfterSend();
    }
}
