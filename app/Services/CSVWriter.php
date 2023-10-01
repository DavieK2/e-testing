<?php

namespace App\Services;
use Illuminate\Support\Str;

class CSVWriter {

    /** 
     * @param resource
    */
    protected $file;

    protected string $path;

    protected array $headers; 


    public function writeToCSV(array $data, string $path, array $header_row = []) : void
    {
        if( ! file_exists( public_path($path) ) ){
                        
            mkdir( public_path($path), recursive: true );
        }
        
        if( ! $this->file ){

            $this->path = $path.Str::random().'_'.now()->format('Y_m_d').'.csv';
            
            $this->file = fopen( public_path($this->path), 'a' );

            $this->headers = array_keys($data);

            if( ! empty($header_row) ){
                
                fputcsv($this->file, $header_row);
            }
            
        }

        dd($this->file);

        fputcsv($this->file, $data);
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getFilePath() : string
    {
        return $this->path;
    }

    public function close() : void
    {
        if( $this->file ) fclose($this->file);
    }
}