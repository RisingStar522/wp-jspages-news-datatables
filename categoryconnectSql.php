<?php
header("Content-Type: application/json"); 
$data = json_decode(file_get_contents("php://input")); 

if(isset($data)){
    if(isset($data->category)){
        if(isset($data->exchangeVal)){
            if($data->flag =="all"){
                getCategory($data->category, $data->exchangeVal);
            }else{
                searchCategory($data->category, $data->flag, $data->searchTxt);
            }            
        }         
    }
}
// var_dump($data->category);
function getCategory($category, $exchangeVal){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions); 

    if( $conn ) {
        if($exchangeVal=="SGH"){
            $exchangeVal="SHG";
        }

        $tsql = "SELECT id, genCode, genName, genExchange FROM dbo.Fundamental WHERE genExchange='".$exchangeVal."' ORDER BY genCode;";              
    
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if(substr($row[2],0,1) == $category){
                  
                    if(mb_detect_encoding($row[2])){
                        $str = mb_convert_encoding( $row[2] , "UTF-8", "auto" );                        
                    }else{
                        $str = mb_convert_encoding( $row[2] , "UTF-8", "auto" );   
                    }

                    $resultVal[$k]=[strval($row[0]),$row[1],$str,$row[3]];
                    $k += 1;
                }
            }
            $json = json_encode($resultVal);

            if ($json)
                echo $json;
            else
                echo json_last_error_msg();       
        }     
        else     
        {
            echo "1";       
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
    }
}

function searchCategory($category, $flag, $searchTxt){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions); 

    if( $conn ) {
        if($flag == "code"){
            $tsql = "SELECT id, genCode, genName, genExchange FROM dbo.Fundamental WHERE genCode = '".$searchTxt."' ORDER BY genCode;";              
        }else{
            $tsql = "SELECT id, genCode, genName, genExchange FROM dbo.Fundamental WHERE genName = '".$searchTxt."' ORDER BY genName;";              
        }
        
    
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
               
                  
                    if(mb_detect_encoding($row[2])){
                        $str = mb_convert_encoding( $row[2] , "UTF-8", "auto" );                        
                    }else{
                        $str = mb_convert_encoding( $row[2] , "UTF-8", "auto" );   
                    }

                    $resultVal[$k]=[strval($row[0]),$row[1],$str,$row[3]];
                    $k += 1;
              
            }
            $json = json_encode($resultVal);

            if ($json)
                echo $json;
            else
                echo json_last_error_msg();       
        }     
        else     
        {
            echo "1";       
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
    }
}


?>