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

        // I add the array keys as CSV headers
       // fputcsv($fp, array_keys($data[0]), $delimiter, $enclosure);

        // Add all the data in the file
        foreach ($data as $fields) {
            fputcsv($fp, $fields,$delimiter,$enclosure);
        }

        // Close the file
        fclose($fp);

        // Stop the script
        die();
    }

    private function arrayToCSV($rows) {
        $fp = fopen('php://temp', 'r+b');
        foreach($rows as $fields) {
            fputcsv($fp, $fields);
        }
        rewind($fp);
        // Convert CRLF
        $tmp = str_replace(PHP_EOL, "\r\n", stream_get_contents($fp));
        fclose($fp);
        // Convert row data from UTF-8 to Shift-JS
        return mb_convert_encoding($tmp, 'SJIS', 'UTF-8');
    }

}