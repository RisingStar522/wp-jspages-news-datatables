<?php
header("Content-Type: application/json"); 
$data = json_decode(file_get_contents("php://input")); 
if(isset($data)){
    if(isset($data->dataaction)){
        if($data->genExchange == "HK"){
        switch ($data->dataaction){
            case "balancesheet":
                balancesheet($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break; 
            case "persharedata":
                persharedata($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break;
            case "cashflowstatement":
                cashflowstatement($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break;
            case "incomestate":
                incomestate($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break;
            case "ratios":
                ratios($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break;
            case "valuationratios":
                valuationratios($data->view, $data->gentitle, $data->gentitle2, "0".$data->genCode);
                break;
            case "valuationquality":
                valuationquality($data->view, $data->gentitle, $data->gentitle2,"0".$data->genCode);
                break;
            case "dividend":
                echo "0";
                break;
        }
        }else{
        switch ($data->dataaction){
            case "balancesheet":
                balancesheet($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break; 
            case "persharedata":
                persharedata($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break;
            case "cashflowstatement":
                cashflowstatement($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break;
            case "incomestate":
                incomestate($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break;
            case "ratios":
                ratios($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break;
            case "valuationratios":
                valuationratios($data->view, $data->gentitle, $data->gentitle2, $data->genCode);
                break;
            case "valuationquality":
                valuationquality($data->view, $data->gentitle, $data->gentitle2,$data->genCode);
                break;
            case "dividend":
                echo "0";
                break;
        }
            
        }
    }else if(isset($data->itemcategory)){
        findNews($data->itemcategory, $data->genCode);
    }
}
function findNews($itemcategory, $genCode){
    $mysqli = new mysqli("localhost","admin_wp","pw6rSfsNuy","admin_wp");

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }else{    	
        $arrayItemcategory=explode('-', $itemcategory);

        $arraylength=count($arrayItemcategory);

        $arrayItemcate="";
        $arrayItemcate_da="";

        for($j=0; $j<$arraylength; $j++){
            $arrayItemcate = str_replace(array('\\', '_', '%', '$', '&'), array('\\\\', '\\_', '\\%', '\\$', '\\&'), $arrayItemcategory[$j]);
            $arrayItemcate = $mysqli->real_escape_string($arrayItemcate);
            $arrayItemcate_da .= " ".$arrayItemcate;
        }
        
        
        $arrayItemcate_da=trim($arrayItemcate_da);

        $arrayItemcate = str_replace(array('\\', '_', '%', '$', '&'), array('\\\\', '\\_', '\\%', '\\$', '\\&'), $itemcategory);
        $arrayItemcate = $mysqli->real_escape_string($arrayItemcate);

        $arrayItemcate = trim($arrayItemcate);        
                
        $result = mysqli_query($mysqli, "SELECT ID, post_title, SUBSTR(post_content, 1, 150) as post_content, post_date, guid FROM wp_posts WHERE post_title like '% ".$arrayItemcategory[0]." %' OR post_title like '%".$arrayItemcate."%' OR post_title like '%".$arrayItemcate_da."%' ORDER BY post_date DESC"); 
        // var_dump($result);
        if (!$result) {
            $message  = 'Invalid query: ' . mysqli_error($result) . "\n";
            $message .= 'Whole query: ' . $result;
            die($message);
        }

        $resultVal[]="";
        $i=0;
        while ($row = mysqli_fetch_assoc($result)) {
            $str0 = mb_convert_encoding( $row["post_title"] , "UTF-8", "auto" );       
            $str1 = mb_convert_encoding( $row["post_content"] , "UTF-8", "auto" );       
            $str2 = $row['post_date'];   
            $str3 = $row['guid'];   
            $str = $row['ID'];   
            if($str1){
                $str1 = $str1;          
                $resultVal[$i]= [$str,$str0,$str1,$str2,$str3];          
                $i += 1;    
            }
        }
        $json = json_encode($resultVal);
        if ($json)
                echo $json;
            else
                echo json_last_error_msg(); 
        
        if($resultVal[0]!=""){
            mysqli_free_result($resultVal);
        }
    }
}

function balancesheet($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions);

    if( $conn ) {
        // echo "Successfuly connected.";
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Cash_Equivalent), SUM(Preferred_Dividends), SUM(Total_Assets), SUM(Total_equity), SUM(Total_Liabilities) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";
                    
        }else{
            $tsql = "SELECT fiscal_period, Cash_Equivalent, Preferred_Dividends, Total_Assets, Total_equity, Total_Liabilities, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql);
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3),round($row[4],3),round($row[5],3)];
                    $k += 1;    
                }else{
                    break;
                }
            }
            echo json_encode($resultVal);
        }     
        else     
        {
            echo "1";    
            // die();
            die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function persharedata($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions);

    if( $conn ) {
        // echo "Successfuly connected.";
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Book_Share), SUM(Dividends_Share), SUM(Earnings_Share), SUM(EPS_Basic), SUM(EPS), SUM(Cash_Share), SUM(Net_Share), SUM(Revenue_Share), SUM(Total_Debt_Share) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year;";      
        }else{
            $tsql = "SELECT fiscal_period, Book_Share, Dividends_Share, Earnings_Share, EPS_Basic, EPS, Cash_Share, Net_Share, Revenue_Share, Total_Debt_Share, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3),round($row[4],3),round($row[5],3),round($row[6],3),round($row[7],3),round($row[8],3),round($row[9],3)];
                    $k += 1;
                }else{
                    break;
                }
            }
            // var_dump($resultVal);
            echo json_encode($resultVal);
        }     
        else     
        {
            echo "1";    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function cashflowstatement($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions);  

    if( $conn ) {
        // echo "Successfuly connected.";
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Cash_Flow_Div), SUM(Stock_issuance), SUM(Stock_repurchase) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";      
        }else{
            $tsql = "SELECT fiscal_period, Cash_Flow_Div, Stock_issuance, Stock_repurchase, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3)];
                    $k += 1;    
                }else{
                    break;
                }
            }
            echo json_encode($resultVal);
        }     
        else     
        {
            echo "1";    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function incomestate($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions);

    if( $conn ) {
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Net_Income), SUM(Pre_Tax_income), SUM(Total_Revenue) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";      
        }else{
            $tsql = "SELECT fiscal_period, Net_Income, Pre_Tax_income, Total_Revenue, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3)];
                    $k += 1;    
                }else{
                    break;
                }             
            }
            echo json_encode($resultVal);

        }     
        else     
        {
            echo "1";    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function ratios($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions); 

    if( $conn ) {
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Asset_turnover), SUM(Debt_to_asset), SUM(Debt_to_equity), SUM(Dividend_Ratio), SUM(Equity_to_Asset), SUM(ROA_percent), SUM(ROE_percent), SUM(ROE_percent_adjusted) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";      
        }else{
            $tsql = "SELECT fiscal_period, Asset_turnover, Debt_to_asset, Debt_to_equity, Dividend_Ratio, Equity_to_Asset, ROA_percent, ROE_percent, ROE_percent_adjusted, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3),round($row[4],3),round($row[5],3),round($row[6],3),round($row[7],3),round($row[8],3)];
                    $k += 1;
                }else{
                    break;
                }
            }
            // var_dump($resultVal);
            echo json_encode($resultVal);
        }     
        else     
        {
            echo "1";    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function valuationratios($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions); 

    if( $conn ) {
     // echo "Successfuly connected.";
     // if($view=="Yearly"){
     //     $tsql = "SELECT Fiscal_year, SUM(Dividend_Yield), SUM(PB_Ratio), SUM(PE_Ratio), SUM(Price_Flow), SUM(Price_OP_Flow), SUM(Price_Tangible_book) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";      
     // }else{
     //     $tsql = "SELECT fiscal_period, Dividend_Yield, PB_Ratio, PE_Ratio, Price_Flow, Price_OP_Flow, Price_Tangible_book SUBSTRING(fiscal_period, 4, 4) as yearId,
     //     CASE
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Dividend_Yield), SUM(PB_Ratio), SUM(PE_Ratio), SUM(Price_Flow), SUM(Price_OP_Flow), SUM(Price_Tangible_book) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";
                    
        }else{
            $tsql = "SELECT fiscal_period, Dividend_Yield, PB_Ratio, PE_Ratio, Price_Flow, Price_OP_Flow, Price_Tangible_book,  SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        // var_dump($stmt);
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3),round($row[4],3),round($row[5],3),round($row[6],3)];
                    $k += 1;
                }else{
                    break;
                }
            }
            // var_dump($resultVal);
            echo json_encode($resultVal);
        }     
        else     
        {
            echo 1;    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}

function valuationquality($view, $title, $title2, $code){
    $serverName = "139.99.20.45,1433\SQLEXPRESS";
	$connectionOptions = array("Database" => "FinicalDB", "UID" => "admin", "PWD" => "sas899999$#@!HjP");
	$conn = sqlsrv_connect($serverName, $connectionOptions); 

    if( $conn ) {
        // echo "Successfuly connected.";
        if($view=="Yearly"){
            $tsql = "SELECT Fiscal_year, SUM(Altman_Z_Score), SUM(Beneish_Score), SUM(Beta), SUM(Earnings_Power_Value), SUM(Enterprise_Value), SUM(Graham_Number), SUM(Intrinsic_Value_projected), SUM(Median_PS_Value), SUM(Median_PS_Value), SUM(Piotroski_F_Score), SUM(Shares_BuyBack_Ratio), SUM(Shiller_Ratio), SUM(Sloan_Ratio) FROM dbo.Market where Symbol_code='".$code."' GROUP BY Fiscal_year ORDER BY Fiscal_year";      
        }else{
            $tsql = "SELECT fiscal_period, Altman_Z_Score, Beneish_Score, Beta, Earnings_Power_Value, Enterprise_Value, Graham_Number, Intrinsic_Value_projected, Median_PS_Value, Median_PS_Value, Piotroski_F_Score, Shares_BuyBack_Ratio, Shiller_Ratio, Sloan_Ratio, SUBSTRING(fiscal_period, 4, 4) as yearId,
            CASE
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jan' THEN 1
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Feb' THEN 2
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Mar' THEN 3
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Apr' THEN 4
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'May' THEN 5
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jun' THEN 6
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Jul' THEN 7
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Aug' THEN 8
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Sep' THEN 9
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Oct' THEN 10
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Nov' THEN 11
                WHEN SUBSTRING(fiscal_period, 1, 3) = 'Dec' THEN 12
                ELSE 0
            END AS monthId FROM dbo.Marketq where Symbol_code='".$code."' ORDER BY yearId desc, monthId desc";  
        }
        $stmt = sqlsrv_query( $conn, $tsql); 
        $resultVal[]=0;
        if ( $stmt )    
        {   
            $k=0;
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))    
            {   
                if($row[0] != 1989 && $row[0] != "Jan1990"){
                    $resultVal[$k]=[$row[0],round($row[1],3),round($row[2],3),round($row[3],3),round($row[4],3),round($row[5],3),round($row[6],3),round($row[7],3),round($row[8],3),round($row[9],3),round($row[10],3),round($row[11],3),round($row[12],3),round($row[13],3)];
                    $k += 1;
                }else{
                    break;
                }
            }
            // var_dump($resultVal);
            echo json_encode($resultVal);
        }     
        else     
        {
            echo "1";    
            // die( print_r( sqlsrv_errors(), true));    
        }
        sqlsrv_free_stmt( $stmt);    
        sqlsrv_close( $conn);
    }else{
        echo "0";
        // die( print_r( sqlsrv_errors(), true));
    }
}
?>