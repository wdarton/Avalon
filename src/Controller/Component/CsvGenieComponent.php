<?php
namespace Avalon\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * CsvGenie component
 */
class CsvGenieComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $output;
    public $controller;

    public function initialize(array $config)
    {
        $this->controller = $this->_registry->getController();
    }

    /**
     * This funciton compiles a CSV and returns a downloadable response
     * @param  array  $data     An array of arrays to output. The sub arrays
     *                          provide the rows for the data and the columns are
     *                          destinguished by the elements in each sub array
     * @param  string $filename The name of the file to be downloaded. The .csv
     *                          extension will be automatically added
     * @param  array  $header   An array of arrays to output before the data. The
     *                          sub arrays provide the rows for the data and the
     *                          columns are destinguished by the elements in each sub array
     * @param  array  $footer   An array of arrays to output after the data. The
     *                          sub arrays provide the rows for the data and the
     *                          columns are destinguished by the elements in each sub array
     * @return [type]           This is a response object packaged with the download file.
     *                          To initiate the download you must return the response from
     *                          this function in the calling controller.
     */
    public function createCsv($data, $filename, $header = [], $footer = [])
    {
        if (!empty($header)) {
        	$this->output .= implode(',', $header) . "\r\n";
        }

    	foreach ($data as $row) {
    		$this->output .= implode(',', $row) . "\r\n";
    	}

        if (!empty($footer)) {
        	$this->output .= implode(',', $footer) . "\r\n";
        }

    	$this->controller->response->body($this->output);
    	$this->controller->response->withType('csv');
    	return $this->controller->response->withDownload($filename.'.csv');
    }
}
