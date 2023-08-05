<?php
//
//  FRANKLIN SAFARI
//  210203
// 
//  lab3.php
// 
//  The purpose of this lab is to give you experience with web technologies,
//  specifically SQL, php (and mysqli), JSON.  You will also be exposed to
//  JQuery and Google Charts API that are used in the reports (*Report.html).
//
//  Good Luck!

$username = "cmpt310";
$password = "#4Rbr6";
$server   = "db";
$schema   = "Lab3";
$port     = 3306;

function orgJSON() {

  $db = openDB();
  
  // ==========================================================================
  // Replace this static data with dynamic data from the DB
  $output = array(
              array("Name/Position", "Supervisor EmployeeID", "EmployeeID"),
              //array( array('v'=>'1', 'f'=>'John Smith <div class="title">Chief Technician</div>'), '', '1'),
              //array( array('v'=>'2', 'f'=>'B'), '1', '2'),
             // array( array('v'=>'3', 'f'=>'C'), '1', '3'),
             // array( array('v'=>'4', 'f'=>'E'), '3', '4'),
             // array( array('v'=>'5', 'f'=>'F'), '3', '5'),
             // array( array('v'=>'6', 'f'=>'D'), '2', '6'),
            );
  // ========================================================================== 
  $result = $db->query ("SELECT * FROM Technician;");
  
  
 // $output[] = [['v' => $row ["EmployeeID"], 'f' => $row ["Name"]], '', '1' ]; 

  if ($result) {
  	while ($row = $result-> fetch_assoc()){
  	$output[] = [ ['v' => $row["EmployeeID"], 'f' => $row['Name']."<div class='title'>".$row['Title']."</div>" ], $row["Technician_EmployeeID"], $row["EmployeeID"] ];
  	}
      }
  closeDB($db);

  echo json_encode($output);

  exit;
}

function technicianJSON() {

  $db = openDB();

  $n =  $db->real_escape_string($_GET["n"]);

  // ==========================================================================
  // Replace this static data with dynamic data from the DB
  
 
  $output = [
              ["Technician",  "Number of Pianos Inspected"],
            //  ["Tech 1",    12345],
             // ["Tech 2",    12345],
             // ["Tech 3",    12345],
             // ["Tech 4",    12345],
             // ["Tech 5",        0]
            ];  
            
 $result = $db ->query("SELECT Technician.Name,COUNT( Inspection.InspectionID) AS InspectionNumber FROM  Technician, Inspection WHERE Technician.EmployeeID = Inspection.Technician_EmployeeID GROUP BY Name ORDER BY InspectionNumber DESC, Name ASC LIMIT $n;
 ");
   if ($result){
   	while ($row = $result->fetch_assoc())
   	$output[] = [ $row["Name"], intval ($row ["InspectionNumber"])];
   	}
   
  // ========================================================================== 
  $result-> free();
  closeDB($db);

  echo json_encode($output);

  exit;

}

function pianoJSON() {

  $db = openDB();

  $start =  $db->real_escape_string($_GET["start"]);
  $end =    $db->real_escape_string($_GET["end"]);
  $n =      $db->real_escape_string($_GET["n"]);

  // ==========================================================================
$result = $db ->query("SELECT Model.Name, Model.ModelID, COUNT(Piano.Model_ModelID) As NumberOfSales FROM Piano, Model WHERE Model.ModelID = Piano.Model_ModelID GROUP BY Model.ModelID ORDER BY NumberOfSales DESC, Name ASC LIMIT $n;");
	$headerRow [] = "Year" ;
	if ($result){
	     while ($row = $result->fetch_assoc()){
	     $IdArray[] = $row["ModelID"];
	     	$headerRow[] = $row["Name"];
	     }}
	$output[] = $headerRow ;
	
	 $startint = intval($start);
	 $endint = intval ($end);
       while($startint <= $endint){ 

       $headRow [] = $startint;
        $output[] = $headRow;
	foreach ($IdArray as $value){
	$startint ++;
	$headRow [] = $startint;
		$result2 = $db->query( "SELECT COUNT(SerialNo) FROM Piano WHERE Model_ModelID = $value AND YEAR (MfgDate) = ". $startint.";");
	if ($result2){
	$startint ++;
	     while ($row = $result2->fetch_assoc()){
	     	$headRow[] = $row["COUNT(SerialNo)"];

	     }}
	}
	$startint ++;
	$output[] = $headRow;
}

	
	
	
	
	
	//$headRow = $startint +1;
	//foreach ($IdArray as $value){
	//	$result2 = $db->query( "SELECT COUNT(SerialNo) FROM Piano WHERE Model_ModelID = $value AND YEAR (MfgDate) = ".$startint.";");
	//if ($result2){
	//     while ($row = $result2->fetch_assoc()){
	 //    	$headRow[] = $row["COUNT(SerialNo)"];
	
	//     }}
//	}
	
	//$startint = startint +1; 
	//$startt = $start + 1;
	//$headdRow[] = $startt; 
	//foreach ($IdArray as $value){
		//$result3 = $db->query( "SELECT COUNT(SerialNo) FROM Piano WHERE Model_ModelID = $value AND YEAR (MfgDate) = ". $startt.";");
	//if ($result3){
	 //    while ($row = $result3->fetch_assoc()){
	   //  	$headdRow[] = $roww["COUNT(SerialNo)"];
	
	  //   }}
//	}//

	//$output[] = $headRow;
//}
	//converting the string year into int so I can get the difference and use that in a loop to print the respective years as requested by the user.

	//$startint = intval($start);
	//$endint = intval($end);
	//$startint = intval($start);
	//$yeardiff = $endint - $startint;
	
	
	
//$result  
   // ["Year",  "Bosern",  "Mofasdfadel B",  "Model C",  "Model D" ],
   // ["2017",        0,      12345,      12345,      12345   ],
    //["2018",    12345,          0,      12345,      12345   ],
  //  ["2019",    12345,      12345,          0,      12345   ],
  //  ["2020",    12345,      12345,      12345,          0   ],
  //  ["2021",        0,          0,          0,          0   ]
  //  ];
  // ==========================================================================
    
  closeDB($db);
    
  echo json_encode($output);

  exit;
}

// DO NOT MODIFY BELOW THIS POINT ---------------------------------------------

function openDB()
{
  try {

    $db = new mysqli( $GLOBALS['server'], 
                      $GLOBALS['username'],
                      $GLOBALS['password'],
                      $GLOBALS['schema'],
                      $GLOBALS['port']);
                      
    if ($db->connect_errno)
      echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    return $db;

  } catch (mysqli_sql_exception $e) {
    echo "Failed to connect to MySQL: ".$e->getMessage()."\n";
  }
  
  return NULL;
}

function closeDB($db)
{
  if ($db !=NULL )
    $db->close();
}
