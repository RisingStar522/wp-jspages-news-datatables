<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"   crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css"   crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.3/css/scroller.jqueryui.min.css"   crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/scroller/2.0.3/js/dataTables.scroller.min.js" crossorigin="anonymous"></script>
<!--script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.1/js/dataTables.fixedColumns.min.js"></script-->

<style>
    .categoriesBtn{
        cursor:pointer;
        width: 32px;
        height: 35px;
        text-align: center;
        padding: 8px 11px !important;
    }
    body > div > div.container > nav{
        text-align: center;
    }

    #categoriesItemView > a > div{
        color: black;
    }
    #categoriesItemView > span > div:hover{
        color: blue;
    }

    .col-xs-6{
        justify-content: center;
        align-items: center;
        display: flex;
        border-radius: 3px;
        box-shadow: 0 1px 1px 1px #ddd;
        height: 60px;
        border: solid;
        border-left: none;
        border-top: none;
        border-width: 1px;
        border-color: #ddd;
    }
    .col-xs-6:hover{
        box-shadow: 0 1px 5px 0 rgb(0 0 0 / 10%), 0 1px 5px 0 rgb(0 0 0 / 15%);
        cursor: pointer;
        
    }
    .formwhich{
        width:154px;
        box-shadow: 1px 1px 1px 0px #aaa;
        border-radius: 2px;
        font-family: serif;
        font-size:16px;
        font-weight: 900;
        margin-top: 5px;
    }
    .divide{
        cursor:pointer;
    }
    @media (min-width: 500px){
        .container {
            width: 450px;
        }
	}
    
    @media only screen and (max-width:700px){
        .newsdiv{
            width: 48% !important;
            margin:1%;
        }
    }

    @media only screen and (max-width:500px){
        .newsdiv{
            width: 98% !important;
            margin:1%;
        }
	.genExchangeSelectParentDiv{
	    width: 100% !important;
	}
    }

 	@media (min-width: 0px){
    .container {
          width: 100%;
        }
	}
</style>
<div class="formhtmlbody"></div>
<script>
$(document).ready(function() {
    var gencode="";
    var genexchange="";
    var itemcategory="";
    var itemcategory2="";
    
    loadCategories("A","SG","all","");
    
    if(window.location.search.substr(1)!=""){
    
        var getParam = window.location.search.substr(1);
        getParam=getParam.trim();
        var splitStr = getParam.split("-");

        gencode=splitStr[splitStr.length-2];
        genexchange=splitStr[splitStr.length-1];
        gencode=gencode.trim();
        genexchange=genexchange.trim();

        itemcategory=getParam.slice(0 ,getParam.length - 2 - gencode.length - genexchange.length);

        itemcategory2=itemcategory;
        itemcategory=itemcategory.replace(/-/g," ");

        if((itemcategory !="" && gencode!="" && genexchange!="")){
            categoriesAjax = new XMLHttpRequest(); 
            url = "https://www.shareandstocks.com/wp-content/themes/en/headerviewsql.php";
            categoriesAjax.open("POST", url, true); 
            categoriesAjax.setRequestHeader("Content-Type", "application/json"); 
            categoriesAjax.onreadystatechange = function () { 
                if (categoriesAjax.readyState === 4 && categoriesAjax.status === 200) { 
                    result=this.responseText;
                    if(result != "121" && result != "1"){
                        json=JSON.parse(result);
                        
                        description="";
                        description=json[2];
                        // console.log(json);
                        document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<label style='font-size: 23px; font-weight: 900;' class='genNameLagel'>"+json[1]+"</label><br/>");
                        if(json[2] == null ){
                            document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<div style='width: 100%; text-align: center; font-size: 22px; margin-bottom: 50px; font-family: calibri; font-weight: 800;'>Company details not available</div>");                            
                            
                        }else{                                                        
                            if(json[3] != null){
                                document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<label style='font-size: 21px; font-weight: 100;' class='AddressLabel'>Address : "+json[3]+"</label><br/>");
                            }
                            if(json[9] != null){
                                document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<label style='font-size: 21px; font-weight: 100;' class='PhoneLabel'>Phone : "+json[9]+"</label><br/>");
                            }
                            if(json[10] != null){
                                document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<label style='font-size: 21px; font-weight: 100;' class='WebSiteLabel'>WebSite : "+json[10]+"</label><br/>");
                            }
                            if(json[2] != null){
                                document.querySelector('.headerCompanyinfo').insertAdjacentHTML('beforeend',"<label style='font-weight:100;'>"+json[2]+"</label><br/>");
                            }                            
                        }
                        
                    }else if(result=="1"){
                        alert("Processing issues");
                    }else{
                        alert("Database connection error");
                    }
                } 
            }; 
            var data = JSON.stringify({ "itemcategory": itemcategory, "genCode":gencode, "genExchange":genexchange}); 
            categoriesAjax.send(data); 
        }
    }

    if(window.location.search.substr(1)!=""){
        $(".formhtmlbody").html("");
        $(".formhtmlbody").html(`
            <div style=" width: 100%; font-family:calibri">
                <button type="button" id="windowsBackBtn" class="btn btn-primary" style="float: right; font-size: 20px; padding: 2px; width: 90px;">Back</button>
            </div>
            <div style="width: 84%; margin: auto; margin-top: 31px; font-size: 20px; font-family: calibri;" class="headerCompanyinfo">
            </div>
            <!-- company details not available -->

            <div style="padding-top:30px; padding-bottom:0px;text-align: center;  font-family:calibri">
                <button type="button" class="formwhich btn btn-light" id="balancesheet" style="font-family: calibri; font-weight: 900;">Balance Sheet</button>
                <button type="button" class="formwhich btn btn-light" id="persharedata" style="font-family: calibri; font-weight: 900;">Per Share Data</button>
                <button type="button" class="formwhich btn btn-light" id="cashflowstatement" style="font-family: calibri; font-weight: 900;">Cash Flow Statement</button>
                <button type="button" class="formwhich btn btn-light" id="incomestate" style="font-family: calibri; font-weight: 900;">Income Statement</button>
                <button type="button" class="formwhich btn btn-light" id="ratios" style="font-family: calibri; font-weight: 900;">Ratios</button>
                <button type="button" class="formwhich btn btn-light" id="valuationratios" style="font-family: calibri; font-weight: 900;">Valuation Ratios</button>
                <button type="button" class="formwhich btn btn-light" id="valuationquality" style="font-family: calibri; font-weight: 900;">Valuation Quality</button>
                <!--button type="button" class="formwhich btn btn-light" id="dividend" style="font-family: calibri; font-weight: 900;">News</button-->
            </div>
            <div style=" font-family:calibri; width: 85%;text-align: right;border-bottom: solid;margin: auto;margin-top: 2.5rem;margin-bottom: 1.4rem;border-color: #333; padding: 0.6rem;">
                <span style="font-family: fantasy;" id="divide_year" class="divide"> Yearly </span>
                <span style="font-family: initial;" id="divide_quarterly" class="divide"> Quarterly </span>
            </div>
            <input name="flag" class="flag" id="flag" type="hidden" value="Year">
            <div style="padding-top:20px; font-family:calibri">
                <div><label style="font-family: fantasy; font-size: 20px;" class="tableHeader_label">Balance Sheet</label></div>
                <div class="datatableDiv"></div>
            </div>`);
    }else{
        $(".formhtmlbody").html("");
        $(".formhtmlbody").html(`
        <div class="container">
        <div class="input-group">

        <div class="row" style="margin-top:20px">
            <div class="col-sm-4 col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search By Stock Code" id="searchbystockcode" style="height:34px"/>
                <div class="input-group-btn">
                <button class="btn btn-secondary" id="searchbystockcode_btn" type="submit" style="height:34px">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </div>
            </div>
            </div>
        </div>

        <div class="row" style="margin-top:2px">
            <div class="col-sm-4 col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search By Stock Name" id="searchbystockname" style="height:34px"/>
                <div class="input-group-btn">
                <button class="btn btn-secondary" id="searchbystockname_btn" type="submit" style="height:34px">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </div>
            </div>
            </div>
        </div>
		<div class="row" style="margin-top:2px">
            <div class="col-sm-4 col-md-4">
                <button type="button" id="searchResetBtn" class="btn btn-danger" style=" width: 100%;">Reset</button>
                <input type="hidden" value="0" id="searchFlag">
            </div>
      	</div>
        <br/>
        <div class="genExchangeSelectParentDiv" style="margin-top:30px; display:flex; flex-wrap: wrap; width: 100%;">
        <div class="form-group" style="width:120px; margin-right:20px">
        <select class="form-control" id="genExchangeSelect">
            <option>SG</option>
            <option>SHE</option>
            <option>NASDAQ</option>
            <option>NYSE</option>
            <option>KLSE</option>
            <option>SHG</option>
            <option>HK</option>
        </select>
        <input type="hidden" value="SG" class="exchangeSelectVal">
        </div>
        <ul class="nav nav-pills" id="categorylist">
            <li class="active"><a id="firstcategory"  class="categoriesBtn">A</a></li>
            <li><a class="categoriesBtn">B</a></li>
            <li><a class="categoriesBtn">C</a></li>
            <li><a class="categoriesBtn">D</a></li>    
            <li><a class="categoriesBtn">E</a></li>
            <li><a class="categoriesBtn">F</a></li>
            <li><a class="categoriesBtn">G</a></li>
            <li><a class="categoriesBtn">H</a></li>
            <li><a class="categoriesBtn">I</a></li>
            <li><a class="categoriesBtn">J</a></li>
            <li><a class="categoriesBtn">K</a></li>
            <li><a class="categoriesBtn">L</a></li>
            <li><a class="categoriesBtn">M</a></li>
            <li><a class="categoriesBtn">N</a></li>
            <li><a class="categoriesBtn">O</a></li>
            <li><a class="categoriesBtn">P</a></li>
            <li><a class="categoriesBtn">Q</a></li>
            <li><a class="categoriesBtn">R</a></li>
            <li><a class="categoriesBtn">S</a></li>
            <li><a class="categoriesBtn">T</a></li>
            <li><a class="categoriesBtn">U</a></li>
            <li><a class="categoriesBtn">V</a></li>
            <li><a class="categoriesBtn">W</a></li>
            <li><a class="categoriesBtn">X</a></li>
            <li><a class="categoriesBtn">Y</a></li>
            <li><a class="categoriesBtn">Z</a></li>
            <li><a class="categoriesBtn">0</a></li>
        </ul>
        <input type="hidden" value="A" class="categoriesBtnVal">
        </div>  
        <div class="row" style="text-align: center; margin-top:20px" id="categoriesItemView"></div></div>
    `);
    }
    function loadCategories(category, exchangeVal, flag, searchTxt){
        categoriesAjax = new XMLHttpRequest(); 
        url = "https://www.shareandstocks.com/wp-content/themes/en/categoryconnectSql.php";
        categoriesAjax.open("POST", url, true); 
        categoriesAjax.setRequestHeader("Content-Type", "application/json"); 
        categoriesAjax.onreadystatechange = function () { 
            if (categoriesAjax.readyState === 4 && categoriesAjax.status === 200) { 
                result=this.responseText;
                if(result != "121" && result != "1"){
                    json=JSON.parse(result);
                    arraylength=json.length;
                    itemsString="";
                    $('#categoriesItemView').html("");
                    if(json[0]=="0"){
                        itemsString = `<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">Data is not exist</div>`;
                    }else{ 
                        for(i=0; i<arraylength; i++){
                            itemsString += `
                            <span class="itemoflist" itemid="`+json[i][0]+`" itemcode="`+json[i][1]+`" itemname="`+json[i][2]+`" itemexchange="`+json[i][3]+`"  title="`+json[i][2]+`" >
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 " style="padding:1px; line-height:13.5px;">`+json[i][2]+`</div>
                            </span>`;
                        }
                    }
                    // document.querySelector("#categoriesItemView").insertAdjacentHTML('beforeend',itemsString);
                    $('#categoriesItemView').html(itemsString);
                }else if(result=="1"){
                    alert("Processing issues")
                }else{
                    alert("Database connection error");
                }
            } 
        }; 
        var data = JSON.stringify({ "category": category, "exchangeVal":exchangeVal,"flag":flag,"searchTxt":searchTxt}); 
        categoriesAjax.send(data); 
    }
    
    $('.categoriesBtn').click(function(){
        $(this).parent().parent().children().attr("class","");
        $(this).parent().attr("class","active");
        $(".categoriesBtnVal").val($(this).html());
        loadCategories($(this).html(),$(".exchangeSelectVal").val(),"all","");
    });
    
    

    $(document).on("change", "select", function(e) {
        $(".exchangeSelectVal").val($(this).val())
        loadCategories($(".categoriesBtnVal").val(), $(this).val(),"all","");
    }); 
////////////////////////////////////////////////////////

     buttonAction("balancesheet","Yearly")
    $("#flag").val("balancesheet")
    
    function buttonAction(dataaction, view){
        let xhr = new XMLHttpRequest(); 
        let url = "https://www.shareandstocks.com/wp-content/themes/en/connectsql.php";
        xhr.open("POST", url, true); 

        genCode=gencode;
        genTitle2=itemcategory;
        genTitle1=itemcategory2;

        xhr.setRequestHeader("Content-Type", "application/json"); 
        xhr.onreadystatechange = function () { 
            if (xhr.readyState === 4 && xhr.status === 200) { 
                result = this.responseText; 
                // console.log("Datatable load section response");
                // console.log(result)
                // console.log("//Datatable load section response");

                if(result != "121" && result != "1"){
                    json=JSON.parse(result);
                    resultLength=json.length;
                    if(json[0]!=0 && resultLength!=1){ 
                        switch ($("#flag").val()) {
                            case "balancesheet":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`)
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Cash and cash equivalents</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Preferred Dividends</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Total Assets</td>");
                                $('.datalist_tbody > tr:nth-child(4)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>FTotal Equity</td>");
                                $('.datalist_tbody > tr:nth-child(5)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Total Liabilities</td>");
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][3]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][4]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][5]+"</td>")
                                }
                                $('.tableHeader_label').html("Balance Sheet");                               
                                    if(view=="Yearly"){
                                        for (i=0; i<resultLength-1; i++){
                                            document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        }
                                    }else{
                                        for (i=0; i<10; i++){
                                            document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        }                                   
                                    }
                                break;
                            case "persharedata":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`);
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Book Share</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dividends Share</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Earnings Share</td>");
                                $('.datalist_tbody > tr:nth-child(4)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>EPS Basic</td>");
                                $('.datalist_tbody > tr:nth-child(5)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>EPS</td>");
                                $('.datalist_tbody > tr:nth-child(6)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Cash Share</td>");
                                $('.datalist_tbody > tr:nth-child(7)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Net Share</td>");
                                $('.datalist_tbody > tr:nth-child(8)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Revenue Share</td>");
                                $('.datalist_tbody > tr:nth-child(9)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Total Debt Share</td>");
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][3]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][4]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][5]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][6]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][7]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][8]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][9]+"</td>")
                                }
                                $('.tableHeader_label').html("Per Share Data");                            
                                if(view=="Yearly"){
                                    for (i=0; i<resultLength-1; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[i][9]+"</td>")
                                    }
                                }else{
                                    for (i=0; i<10; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[i][9]+"</td>")
                                    }
                                    
                                }
                                break;
                            case "cashflowstatement": 
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`)
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Cash Flow Div</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Stock issuance</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Stock repurchase</td>");
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][3]+"</td>")
                                }
                                $('.tableHeader_label').html("Cash Flow Statement");    
                                if(view=="Yearly"){
                                    for (i=0; i<resultLength-1; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                    }
                                }else{
                                    for (i=0; i<10; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                    }
                                }                           
                                break;
                            case "incomestate":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`)
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Net Income</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Pre Tax income</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Total Revenue</td>");
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1][3]+"</td>")
                                }
                                $('.tableHeader_label').html("Income Statement");    
                                if(view=="Yearly"){
                                    for (i=0; i<resultLength-1; i++){                                        
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                    }
                                }else{
                                    for (i=0; i<10; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                    }                                    
                                }                           
                                break;
                                break;
                            case "ratios":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`);
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Asset turnover</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Debt to asset</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Debt to equity</td>");
                                $('.datalist_tbody > tr:nth-child(4)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dividend Ratio</td>");
                                $('.datalist_tbody > tr:nth-child(5)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Equity to Asset</td>");
                                $('.datalist_tbody > tr:nth-child(6)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>ROA percent</td>");
                                $('.datalist_tbody > tr:nth-child(7)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>ROE percent</td>");
                                $('.datalist_tbody > tr:nth-child(8)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>ROE percent adjusted</td>");   
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1-i][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][3]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][4]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][5]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][6]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][7]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][8]+"</td>")
                                }
                                $('.tableHeader_label').html("Ratios");                        
                                
                                    if(view=="Yearly"){
                                        for (i=0; i<resultLength-1; i++){
                                            document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        }
                                    }else{
                                        for (i=0; i<10; i++){
                                            document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                            document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        }
                                    }
                                break;
                            case "valuationratios":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`);
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dividend Yield</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>PB Ratio</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>PE Ratio</td>");
                                $('.datalist_tbody > tr:nth-child(4)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Price Flow</td>");
                                $('.datalist_tbody > tr:nth-child(5)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Price OP Flow</td>");
                                $('.datalist_tbody > tr:nth-child(6)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Price Tangible book</td>");   
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1-i][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][3]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][4]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][5]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][6]+"</td>")
                                }
                                $('.tableHeader_label').html("Valuation Ratios");                       
                                if(view=="Yearly"){
                                    for (i=0; i<resultLength-1; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                    }
                                }else{
                                    for (i=0; i<10; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                    }
                                }
                                break;
                            case "valuationquality":
                                $("#datalistTable").dataTable().fnDestroy()
                                $(".datatableDiv").html(`<table id="datalistTable" class="display nowrap" style="width:100%">
                                                            <thead class="datalist_thead">
                                                                <tr></tr>
                                                            </thead>
                                                            <tbody class="datalist_tbody">
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                                <tr></tr>
                                                            </tbody>
                                                        </table>`);
                                $('.datalist_thead > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Fiscal Period</td>");
                                $('.datalist_tbody > tr:nth-child(1)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Altman Z Score</td>");
                                $('.datalist_tbody > tr:nth-child(2)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Beneish Score</td>");
                                $('.datalist_tbody > tr:nth-child(3)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Beta</td>");
                                $('.datalist_tbody > tr:nth-child(4)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Earnings Power Value</td>");
                                $('.datalist_tbody > tr:nth-child(5)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Enterprise Value</td>");
                                $('.datalist_tbody > tr:nth-child(6)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Graham Number</td>");
                                $('.datalist_tbody > tr:nth-child(7)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Intrinsic Value projected</td>");
                                $('.datalist_tbody > tr:nth-child(8)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Median PS Value</td>");
                                $('.datalist_tbody > tr:nth-child(9)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Peter Lynch FV</td>");
                                $('.datalist_tbody > tr:nth-child(10)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Piotroski F Score</td>");
                                $('.datalist_tbody > tr:nth-child(11)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Shares BuyBack Ratio</td>");
                                $('.datalist_tbody > tr:nth-child(12)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Shiller Ratio</td>");                        
                                $('.datalist_tbody > tr:nth-child(13)').html("<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Sloan Ratio</td>");   
                                if(view=="Yearly"){
                                    document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>TTM"+json[resultLength-1-i][0]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][1]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][2]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][3]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][4]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][5]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][6]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][7]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][8]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][9]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(10)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][10]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(11)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][11]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(12)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][12]+"</td>")
                                    document.querySelector('.datalist_tbody > tr:nth-child(13)').insertAdjacentHTML('beforeend',"<td>"+json[resultLength-1-i][13]+"</td>")
                                }
                                $('.tableHeader_label').html("Valuation Quality");                        
                                if(view=="Yearly"){
                                    for (i=0; i<resultLength-1; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>Dec"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[i][9]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(10)').insertAdjacentHTML('beforeend',"<td>"+json[i][10]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(11)').insertAdjacentHTML('beforeend',"<td>"+json[i][11]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(12)').insertAdjacentHTML('beforeend',"<td>"+json[i][12]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(13)').insertAdjacentHTML('beforeend',"<td>"+json[i][13]+"</td>")
                                    }
                                }else{
                                    for (i=0; i<10; i++){
                                        document.querySelector('.datalist_thead > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td style='font-family: calibri;font-weight: 900; font-size: 16px;'>"+json[i][0]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(1)').insertAdjacentHTML('beforeend',"<td>"+json[i][1]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(2)').insertAdjacentHTML('beforeend',"<td>"+json[i][2]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(3)').insertAdjacentHTML('beforeend',"<td>"+json[i][3]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(4)').insertAdjacentHTML('beforeend',"<td>"+json[i][4]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(5)').insertAdjacentHTML('beforeend',"<td>"+json[i][5]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(6)').insertAdjacentHTML('beforeend',"<td>"+json[i][6]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(7)').insertAdjacentHTML('beforeend',"<td>"+json[i][7]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(8)').insertAdjacentHTML('beforeend',"<td>"+json[i][8]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(9)').insertAdjacentHTML('beforeend',"<td>"+json[i][9]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(10)').insertAdjacentHTML('beforeend',"<td>"+json[i][10]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(11)').insertAdjacentHTML('beforeend',"<td>"+json[i][11]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(12)').insertAdjacentHTML('beforeend',"<td>"+json[i][12]+"</td>")
                                        document.querySelector('.datalist_tbody > tr:nth-child(13)').insertAdjacentHTML('beforeend',"<td>"+json[i][13]+"</td>")
                                    }
                                }
                                break;
                            case "dividend":
                                break;
                        }
                    }
                    else{
                        $("#datalistTable").dataTable().fnDestroy()
                        $(".datatableDiv").html("<div style='width: 100%; text-align: center; font-size: 22px; margin-bottom: 50px; font-family: calibri; font-weight: 800;'>The news doesn't exist</div>");
                    }
                    
                    $('#datalistTable').dataTable({
                        scrollX: true,
                        paging: false,
                        info: false,
                        searching: false
                    });
                }else if(result=="0"){
                    alert("Database connection error")
                }else{
                    alert("Processing issues")
                }
            } 
        }; 
        var data = JSON.stringify({ "dataaction": dataaction, "view": view, "gentitle":itemcategory, "gentitle2":itemcategory2,"genCode":genCode, "genExchange":genexchange }); 
        xhr.send(data); 
    }


    $("#balancesheet").attr("class","formwhich btn btn-primary")
  
    $(".divide").click(function(){
        $(".divide").attr("style","font-family:initial");
        $(this).attr("style","font-family:fantasy");
        buttonAction($("#flag").val(), $.trim($(this).html()))
    }); 

    $("#windowsBackBtn").click(function(){
        window.location.href=("https://www.shareandstocks.com/sgx-listed-stocks-details/");
    })

    $(document).on("click", ".itemoflist", function(e) {
        genname=$(this).attr("itemname");
        genExchange=$(this).attr('itemexchange');
        gencode=$(this).attr("itemcode");
        genname=genname.replace(/ /g, "-")
        genparam=genname+"-"+gencode+"-"+genExchange;
        window.open("https://www.shareandstocks.com/sgx-listed-stocks-details/?"+genparam);
        return false;
    });

    $(".formwhich").click(function(){
        $(".formwhich").css("pointer-events", "all");
        $(".formwhich").attr("class","formwhich btn btn-light")
        $(this).attr("class","formwhich btn btn-primary");
        $(this).blur();
        $(this).css("pointer-events", "all");
        $(".divide").attr("style","font-family:initial");
        $("#divide_year").attr("style","font-family:fantasy");
        $("#flag").val($(this).attr("id"));        
        if($(this).html() == "News" ){           
            $("#divide_year").css("visibility","hidden")
            $("#divide_quarterly").css("visibility","hidden")
            newsFunction(itemcategory2, gencode);
            
        }else{            
            $("#divide_year").css("visibility","inherit")
            $("#divide_quarterly").css("visibility","inherit")
            buttonAction($(this).attr("id"),$.trim($(".divide").html()))
        }
    });
    
    function newsFunction(itemcategory, gencode){
        categoriesAjax = new XMLHttpRequest(); 
        url = "https://www.shareandstocks.com/wp-content/themes/en/connectsql.php";
        categoriesAjax.open("POST", url, true); 
        categoriesAjax.setRequestHeader("Content-Type", "application/json"); 
        categoriesAjax.onreadystatechange = function () { 
            if (categoriesAjax.readyState === 4 && categoriesAjax.status === 200) { 
                result=this.responseText;                
                if(result != "121" && result != "1"){
                    json=JSON.parse(result);
                    $('.tableHeader_label').html("News");    
                    if(json[0]==""){
                        $(".datatableDiv").html("");
                        $(".datatableDiv").html("<div style='width: 100%; text-align: center; font-size: 22px; margin-bottom: 50px; font-family: calibri; font-weight: 800;'>The news doesn't exist</div>");
                    }else{
                        $(".datatableDiv").html("<div style='display: flex; width: 100%; flex-flow: wrap;' class='newsviewpanel'></div>");
                        for(i=0; i<json.length; i++){
                            if(json[i][4]!="" && (json[i][1]) != "" && json[i][1] !=false && json[i][1] !="false"){
                            insertdata=`
                            <div class='newsdiv' style='display: grid; padding: 10px; border: solid; border-width: 1px; border-radius: 10px; border-color: #ddd; padding-top: 8px; width: 24%; margin:0.5px'>
                                <div class='newsheader' style='text-align: center; font-size: 17px; font-weight: bold;'><a href="`+json[i][4]+`">`+json[i][1]+`</a></div></br>
                                <div class='newsBody' style='overflow: hidden; text-overflow: clip; height: 150px;'>`+json[i][2]+`</div><br/>
                                <div class='newsFooter' style="text-align: center;"><br/>
                                    <span class='footerdate'>`+json[i][3]+`</span><br/>
                                    <span class='footerlink'><br/><a href="`+json[i][4]+`">Source link</a></span>
                                </div>
                            </div>`;
                            
                                document.querySelector('.newsviewpanel').insertAdjacentHTML('beforeend',insertdata)
                            }
                        }
                    }
                }else if(result=="1"){
                    alert("Processing issues");
                }else{
                    alert("Database connection error");
                }
            } 
        }; 
        var data = JSON.stringify({ "itemcategory": itemcategory, "genCode":gencode, "view":"news"}); 
        categoriesAjax.send(data); 
    }

    $("button").click(function(){
        $(this).blur();
    })

    $("#searchResetBtn").click(function(){
        loadCategories("A","SG","all","");
        $(".categoriesBtn").parent().parent().children().attr("class","");
        $("#firstcategory").parent().attr("class","active");        
        $("#genExchangeSelect").val("SG")
        $("#genExchangeSelect").removeAttr("disabled","true")
        $("#categorylist").css("pointer-events","auto")       
        $("#searchbystockcode").val("");
        $("#searchbystockname").val("");
    });

    $("#searchbystockcode_btn").click(function(){
        stocksearchTxt = $("#searchbystockcode").val();        
        loadCategories("A","SG","code",stocksearchTxt);
        $("#genExchangeSelect").attr("disabled","true")
        $("#categorylist").css("pointer-events","none")
        $(".categoriesBtn").parent().attr("class","")
        
    })

    $("#searchbystockname_btn").click(function(){
        stocksearchTxt = $("#searchbystockname").val();
        loadCategories("A","SG","name",stocksearchTxt);        
        $("#genExchangeSelect").attr("disabled","true")
        $("#categorylist").css("pointer-events","none")
        $(".categoriesBtn").parent().attr("class","")
    })
    
});
</script>
