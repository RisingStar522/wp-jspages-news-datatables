<?php
header("Content-Type: application/json"); 
$data = json_decode(file_get_contents("php://input")); 

if(isset($data)){
    if(isset($data->itemcategory)){
        itemCategory($data->itemcategory, $data->genCode);
    }
}

function itemCategory($genname, $gencode){
    $connectionInfo = array( "Database"=>"FinicalDB", "UID"=>"admin", "PWD"=>"admin");
    $conn = sqlsrv_connect( "DESKTOP-UTFT64H", $connectionInfo);

    if( $conn ) {

        $tsql = "SELECT id, genName, genDescription, genAddress, genAdd_Street, genAdd_City, genAdd_State, genAdd_Country, genAdd_ZIP, genPhone, genWebURL FROM dbo.Fundamental WHERE genName='".$genname."' AND genCode='".$gencode."'";              
         
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
                    
                    $resultVal[$k]=$row;
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