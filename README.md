# class.csvheader.php

## PHP CSV Reader Class

This is a simple PHP class to load and parse .csv files. 
Files can be separated with any character and enclosed with any character. 
New lines **must** be _\r\n_ as per most OS's requirements. 

This class was coded to make it easy to load and read csv files without worrying about loops and what not.
It returns a readable array. 

## Usage 
```php
require_once('class.csvreader.php');
$csv = new csvreader($csv_file);
```

Methods:
->ReadCSV(_hasHeader_ (optional, Int 0/1, Default 1), _separator_ (optional, string, Default ;), _enclosure_ (option, string, Default ') )
Returns the entire CSV file, in order. 

->ReadCSVFilter(**filterfield** (required, int, num of column to be read), **filter** (required, string, what to match), _separator_, _enclosure_)
Returns the CSV file, but only the lines where column **filterfield** matches **filter**


## Known Bugs 
None. 









