<?PHP

	// CSV reader class //
	// Version 2 by Juliano F. (tibone) 
	// github.com/jflores82 
	// Support free software 
	// 20170524 - added functions to count the number of lines 
	// 20170525 - added functions to retrieve the minmax values of numeric and alphanumeric columns 
	//			- added class to count groups of ocurrences on file 
	
	
// Class start //
class csvreader {
		
		// Variable declarations //
		var $csv_file;     // CSV File name (from construct)
		var $csv_array;    // Multidimensional array to hold csv data
		var $csv_line;     //  Array that feeds csv_array //
		var $counter;      // Simple counter //
		var $filter_field; // Which column will be used to filter (haystack) //
		var $filter;       // Filter needle //
		var $separator;    // CSV separator //
		var $enclosure;    // CSV Enclosure //
		var $hasHeader;    // Flag to check if the csv has a header // 
		
		public function __construct($csv_file) {
			$this->csv_file = $csv_file;   // Loads the csv file name into the variable //
		}
		
		// Reads the csv file and apply a filter to every line, only returning the lines that matches the filter //
		public function readCSVfilter($filter_field, $filter, $separator = ",", $enclosure = '"') {
			// Load the variables //
			$this->filter_field = $filter_field;
			$this->filter = $filter;
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->csv_array = array();
			
			// If the csv file exists //
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				$this->csv_line = array(); // Single dimension array.
				
				// Iterates through every line of the csv //
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) { 
						
						// If the filter validates, we load the line into the multidimensional array //
						if($data[$this->filter_field] == $this->filter) {
							$this->csv_line = $data; 
							array_push($this->csv_array, $this->csv_line);
						}
					}
			}
			return $this->csv_array;  // Returns the populated array //
		}	
		
		
		// Reads the entire csv file and returns an array for it. //
		public function readCSV($offset = 1,$separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array();
			$this->offset = $offset;
			
			// If the csv file exists //
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				
				$this->csv_line = array(); // Single dimension array //
				
				// Iterates through the whole file //
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					if($this->counter >= $this->offset) {
						$this->csv_line = $data; 
						array_push($this->csv_array, $this->csv_line);
					}
				$this->counter++; // Increases counter with every line //
				}
				
			}
			return $this->csv_array; // Returns the populated array //
		}
		
		// Counts the number of lines, using a optional offset //
		public function countCSV($offset = 0, $separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->offset = $offset;
			$this->numlines = 0;
			
			// If the csv file exists //
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				// Iterates through the file
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					if($this->counter >= $this->offset) {
						$this->numlines++;
					}
					$this->counter++;
				}
			}
			return $this->numlines;   // Returns the number of lines //
		}
		
		// Counts the number of lines, that matches a filter string in a defined field.
		public function countCSVFilter($filter_field, $filter, $offset = 0, $separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array(); 
			$this->offset = $offset;
			$this->numlines = 0;
			$this->filter_field = $filter_field;
			$this->filter = $filter;
			
			// If the csv file exists //
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				// Iterates through the file
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					if($this->counter >= $this->offset) {
						if($data[$this->filter_field] == $this->filter) {
							$this->numlines++;
						}
					}
					$this->counter++;
				}
			}
			return $this->numlines;   // Returns the number of lines //
		}
		
		// Check for Minimum and Maximum numeric values on a given column (field) //
		public function minmaxNumCSV($filter_field, $offset = 0, $separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array();
			$this->offset = $offset;
			$this->numlines = 0;
			$this->filter_field = $filter_field;
			$this->maxvalue = -999999;
			$this->minvalue = 999999;
			
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					// Offset, if used //
					if($this->counter >= $this->offset) {
						if(is_numeric($data[$this->filter_field]) == TRUE) {
							// Check for Max Value
							if($data[$this->filter_field] > $this->maxvalue) {
								$this->maxvalue = $data[$this->filter_field];
							}
					
							// Check for Min Value
							if($data[$this->filter_field] < $this->minvalue) {
								$this->minvalue = $data[$this->filter_field];
							}
						}
					}
					$this->counter++;
				}
			}
			return array($this->minvalue,$this->maxvalue);   // Returns the number of lines, array[0]->min and array[1]->max //
		}
		
		// Check for Minimum and Maximum alphanumeric values on a given column (field) //
		public function minmaxAlphaCSV($filter_field, $offset = 0, $separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array();
			$this->offset = $offset;
			$this->numlines = 0;
			$this->filter_field = $filter_field;
			$this->maxvalue = -999999;
			$this->minvalue = 999999;
			
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					// Offset, if used //
					if($this->counter >= $this->offset) {
						// Check for Max Value
						if($data[$this->filter_field] > $this->maxvalue) {
							$this->maxvalue = $data[$this->filter_field];
						}
					
						// Check for Min Value
						if($data[$this->filter_field] < $this->minvalue) {
							$this->minvalue = $data[$this->filter_field];
						}
					}
					$this->counter++;
				}
			}
			return array($this->minvalue,$this->maxvalue);   // Returns the number of lines, array[0]->min and array[1]->max //
		}
		
		// Count values grouped on a given column (field) //
		public function countGroup($filter_field, $ascdesc = 0, $offset = 0, $limit = 999999, $separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array();
			$this->offset = $offset;
			$this->filter_field = $filter_field;
			$this->ascdesc = $ascdesc;
			$this->limit = $limit;
				
			$fh = fopen($this->csv_file, 'rb');
			$countGroup = array();
			while($row = fgetcsv($fh)) {
				if($this->counter >= $this->offset) {
						if (!isset($countGroup[$row[$this->filter_field]])) { 
							$countGroup[$row[$this->filter_field]] = 0;
						}
						$countGroup[$row[$this->filter_field]]++;
					
				}
				$this->counter++;
			}
			
			if($ascdesc == 0) {
				asort($countGroup);
			}
			if($ascdesc == 1) {
				arsort($countGroup); 
			}
		
			array_splice($countGroup, $this->limit); 
			return $countGroup;
		}

}

?>