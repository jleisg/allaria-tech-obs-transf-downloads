<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Sheets;
use Illuminate\Http\Response;

class SpreadsheetController extends Controller
{
    // Method to handle exporting data from the observations spreadsheet
    public function exportObservations()
    {
        $spreadsheetId = '1iiCXs2Jhc-9BKE2wephq3FG1EJeGKfRx6EKFcGHHhW0'; // Spreadsheet ID for observations
        $sheetName = 'OBS'; // Sheet name for observations
        return $this->exportToCSV($spreadsheetId, $sheetName, 'observations.csv');
    }

    // Method to handle exporting data from the mesa spreadsheet
    public function exportMesa()
    {
        $spreadsheetId = '1h1P0BcdGtV_5L23bZyV8-ZYVErloaBtKfY0xX6KFw58'; // New Spreadsheet ID for mesa
        $sheetName = 'Respuestas de formulario 1'; // Sheet name for mesa
        return $this->exportToCSV($spreadsheetId, $sheetName, 'mesa.csv');
    }

    // Reusable method to handle CSV export
    private function exportToCSV($spreadsheetId, $sheetName, $fileName)
    {
        // Initialize Google Client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/private/sheets-export-437318-0a99555dd9d4.json'));
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        // Initialize Google Sheets Service
        $service = new Google_Service_Sheets($client);

        // Fetch data from the spreadsheet and sheet
        $response = $service->spreadsheets_values->get($spreadsheetId, $sheetName);
        $values = $response->getValues();

        // Check if values are returned
        if (empty($values)) {
            return response('No data found.', 404);
        }

        // Create CSV content
        $csvContent = '';
        foreach ($values as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        // Return as CSV download
        return response($csvContent, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
