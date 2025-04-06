<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ProductImportController extends Controller
{
    public function show()
    {
        return view('backend.product.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $import = new ProductsImport;
            Excel::import($import, $request->file('excel_file'));

            if (count($import->getErrors()) > 0) {
                return redirect()->back()
                    ->with('error', 'Import had errors: ' . implode(', ', $import->getErrors()));
            }

            return redirect()->route('product.index')
                ->with('success', 'Products imported successfully');
                
        } catch (\Exception $e) {
            Log::error('Import failed:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
