<?PHP

	// CSV reader class //
	// Version 1 by Juliano F. (tibone) //
	// github.com/jflores82 //
	// Support free software //
	
// Class start //
class csvreader {
		
		// Variable declarations //
		var $csv_file;      // CSV File name (from construct)
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
		public function readCSV($hasHeader = 1,$separator = ",", $enclosure = '"') {
			$this->separator = $separator;
			$this->enclosure = $enclosure;
			$this->counter = 0;
			$this->csv_array = array();
			$this->hasHeader = $hasHeader;
			
			// If it doesn't have a header, we need to read the first line //
			if($this->hasHeader == 0) {
				$this->counter = 1;
			}
			
			// If the csv file exists //
			if (($handle = fopen($this->csv_file, "r")) !== FALSE) {
				
				$this->csv_line = array(); // Single dimension array //
				
				// Iterates through the whole file //
				while (($data = fgetcsv($handle, 9999, $this->separator, $this->enclosure)) !== FALSE) {
					
					if($this->counter >0) {	 // Used to check the header, and then feed into the md array //
						$this->csv_line = $data; 
						array_push($this->csv_array, $this->csv_line);
					}
				$this->counter++; // Increases counter with every line //
				}
				
			}
			return $this->csv_array; // Returns the populated array //
		}
}

?>