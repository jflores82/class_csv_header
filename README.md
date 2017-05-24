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

## Methods:
### ->ReadCSV:
Returns the entire CSV file, in order. 

#### Arguments:
_hasHeader_: optional, Int 0/1, Default 1
_separator_: optional, string, Default ;
 _enclosure_: optional, string, Default "

 ex.
```php
$read_entire = $csv->ReadCSV(1, ";", "'");
var_dump($read_entire) // Entire CSV file with header and data enclosed by "", while separated by ;
```
Returns:
```
array(
	[0]->[0]->field 1, [1]->field 2, [2]->field 3
	[1]->[0]->field 1, [1]->field 2, [2]->field 3
)
```


### ->ReadCSVFilter
Returns the CSV file, but only the lines where column **filterfield** matches **filter**
Column numbers starts at zero. So, 0 = first column, 1 = second column and so on.

#### Arguments:
**filterfield**: required, int, num of column to be read
**filter**: required, string, what to match
_separator_: optional, string, Default ;
_enclosure_: optional string, Default "

```php
$read_filtered = $csv->ReadCSVFilter(1, "foo");
var_dump($read_filtered) // Array containing only the rows in which the column 1 (second column) has the value "foo"
```

Returns:
```
array(
	[0]->[0]->field 1, [1]->field 2, [2]->field 3
	[1]->[0]->field 1, [1]->field 2, [2]->field 3
)
```

### ->CountCSV
Returns a integer with the number of lines in the csv file. 
Accepts an offset value, in case you want to skip a header.

#### Arguments:
_offset_ : optional, int, Default 0
_separator_: optional, string, Default ;
_enclosure_: optional string, Default "

```php
$numlines = $csv->CountCSV(1, ";", "'");
var_dump($numlines) // int: number of lines after the first;
```

Returns:
```
$numlines: int 1
```


### ->CountCSVFilter
Returns a integer with the number of line in the csv where **filterfield** matches **filter**
Accepts an offset value, in case you want to skip a header.

#### Arguments:
**filterfield**: required, int, num of column to be read
**filter**: required, string, what to match
_offset_: optional, int, Default 0
_separator_: optional, string, Default ;
_enclosure_: optional string, Default "

```php
$numlines = $csv->CountCSV(1, "foobar", 0, ";", "'");
var_dump($numlines) // int: number of lines that the second column (1) has the content "foobar"
```

```
$numlines: int 1
```


## Known Bugs 
None. 