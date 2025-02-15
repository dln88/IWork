<?php


namespace App\Utils;

/**
 * Export CSV
 * Class Csv
 * @package App\Utils
 * @author TriTD
 */
class Csv
{
    /**
     * Download CSV
     * @param array $data
     * @param string $filename
     * @param string $delimiter
     * @param string $enclosure
     */
    public static function downloadCSV($data = [], $filename='i-work', $delimiter = ',',$enclosure = '"')
    {
        header("Content-disposition: attachment; filename=$filename.csv");
        // Tells to the browser that the content is a csv file
        header("Content-Type: text/csv");

        // I open PHP memory as a file
        $fp = fopen("php://output", 'w+');

        // Insert the UTF-8 BOM in the file
        fputs($fp, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        // Add all the data in the file
        foreach ($data as $fields) {
            fputcsv($fp, $fields,$delimiter,$enclosure);
        }

        // Close the file
        fclose($fp);

        // Stop the script
        die();
    }
}