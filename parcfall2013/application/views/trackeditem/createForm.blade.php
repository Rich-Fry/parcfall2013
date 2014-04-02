application/ views/ trackeditem/ createForm.blade.php
       @section('styles')
<style type="text/css">
<link rel="stylesheet" href="/styles/css/selectList.css">
<link rel="stylesheet" href="/styles/css/ui.css">
<link rel="stylesheet" href="/styles/css/print.css">
<style>

        body{
                font:"Trebuchet MS",sans-serif;
                margin:0;
                padding:0;
                border:0;
        }
        .container{
                max-width:1000px;
                padding:19px 29px 29px;
                margin:0 auto 10px;
                margin-top:30px;
                background:#cdd1ce;
                background: -moz-linear-gradient(top, #cdd1ce 0%, #dce3c4 41%, #fefefd 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cdd1ce), color-stop(41%,#dce3c4), color-stop(100%,#fefefd)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* IE10+ */
                background: linear-gradient(to bottom, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cdd1ce', endColorstr='#fefefd',GradientType=0 ); /* IE6-9 */
                border-top:25px solid #00A305;
                border-radius:15px;
                -moz-border-radius:20px;/*Old Firefox*/
                box-shadow:7px 7px 5px #2B452D;
                position:relative;
        }
        .controls{
                font-size:14px;
                padding-left:1.5%;
        }
        .control-label{
                display:inline;
                font-size:13px;
                font-weight: bold;
                padding-left:1.5%;
        }
        #formCreate label.error {
                color:red;
                display:none;
        }
 
        input[type="text"], input[type="password"] {
        font-size: 16px;
        width: 250px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
        input[type="text2"] {
        font-size: 16px;
        width: 100px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }

.column1{
        width: 32%;
    float:left;
    border-right:solid 1px;
    padding: 0 4px;
    white-space: nowrap;
}
.column2{
        width: 32%;
    float:left;
    border-right:solid 1px;
    padding: 0 4px;
    white-space: nowrap;
}
.column3{

    float:left;

    padding: 0 4px;
    white-space: nowrap;
}
.modalHeader{
        background-color:#00A305;
        font-size:medium;
        color:white;
}
.ui-datepicker-trigger{
        margin-top:-10px;
}
.control-label{
        font-size:medium;
}
.controls{
        margin-left:2%;
}
.listColumns{
        background-color:#00A305;
        color:white;
        font-size:medium;
}
.searchButton{
        margin-top:-8px;
}
#buttons button{
        margin-left:0;
}
input[type='radio']{
                margin-top:-2px;
        }
#fields li{
        list-style: none;
}
#fields{
        margin:0;
}
input.detailField{
        width:95.5%;
}
.ui-combobox {
    position: relative;
    display: inline-block;
  }
  .ui-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 
    *height: 1.7em;
    *top: 0.1em;
    */
  }
  .ui-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
table{
        border: 1px solid black;
        padding: .2em .7em;
        border-collapse: collapse;
        margin: 10px;
        text-align:left;

}
</style>
@endsection
</style>
@endsection
<ul class="breadcrumb">
          <li><a href="/account/manage">Main</a> <span class="divider"></span></li>
          <li class="active">Support Strategies</li>
          <link rel="stylesheet" href="/styles/css/print.css"
                type="text/css" media="print" />
                <link rel="stylesheet" href="/styles/css/selectList.css">
</ul>
<form >
<div class = "print">

        <form id="supportStrategies" action="/trackeditem/create" method="POST">
        
                <div style="margin-left:0" class="control-group span12">
                <label class="control-label">For:</label>
                 <input type="text" name="for" id="for"/>
                <label class="control-label">Effective Date From:</label>             
                 <input type="text2" name="effectiveDateFrom" id="effectiveDateFrom" class="datepicker"/>           
                <label class="control-label" for="effective to">Effective Date To:</label>       
                 <input type="text2" name="effectiveTo" id="effectiveTo" class="datepicker" /> 
            </div>      
          
            
                <div style="margin-left:0" class="control-group span12">
                <label class="control-label">OUTCOME#:</label>         
                 <input type="text" name="outcomeA" id="outcomeA"/>           
            </div>
            <table>
                <tr>
                <div style="margin-left:0" class="control-group span12">                
               <th><label class="control-label">Support A:<font size="2">(Why necessary, what is it, when given, methods of data collection and evaluation)</font></label>
                 <th><label class="control-label">Person Responsible<br>(Coach)</label> </th>
                <th> <label class="control-label">Relationship</label> </th>
                 <th>  <label class="control-label">Paid Support</label> </th>
                  <th>  <label class="control-label">Natural Support</label> </th>
            </tr>
            <tr>
                    <td><textarea style="width: 250px; height: 250px;" name="supportA" id="supportA" rows="10"cols = "10"></textarea></td>                         
                    <td><textarea style="width: 200px; height: 250px;" name="personResponsible" id="personResponsibleA"rows="10" cols = "10"></textarea> </td>
                   <td> <textarea style="width: 150px; height: 250px;" name="relationshipA" id="relationshipA"rows="10" cols = "10"></textarea></td>
                   <td> <textarea style="width: 150px; height: 250px;"  name="paidSupportA" id="paidSupportA" rows="10" cols = "10"></textarea></td>           
                   <td><textarea style="width: 150px; height: 250px;"  name="naturalSupportA" id="naturalSupportA" rows="10" cols = "10"></textarea></td>
           </div>
            </tr>
             </table> 
                
           
            <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Suggested By:</label>              
                    <input type="text" name="suggestedBy" id="suggestedBy"/>        
            </div>      
            <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Support Strategy:</label>          
                    <input type="text" name="supportStrategy" id="supportStrategy" />          
            </div>      
            <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Action Item:</label>            
                    <input type="text" name="actionItem" id="actionItem"/>              
            </div>      
                <div style="margin-left:0" class="control-group span12">
                <label class="control-label">OUTCOME#:</label>
                    <input type="text" name="outcomeB" id="outcomeB"/>
            </div>

            <table>
                <tr>
                <div style="margin-left:0" class="control-group span12">                
               <th><label class="control-label">Support B:<font size="2">(Why necessary, what is it, when given, methods of data collection and evaluation)</font></label>
                 <th><label class="control-label">Person Responsible<br>(Coach)</label> </th>
                <th> <label class="control-label">Relationship</label> </th>
                 <th>  <label class="control-label">Paid Support</label> </th>
                  <th>  <label class="control-label">Natural Support</label> </th>
            </tr>
            <tr>
                    <td><textarea style="width: 250px; height: 250px;" name="supportA" id="supportA" rows="10"cols = "10"></textarea></td>                         
                    <td><textarea style="width: 200px; height: 250px;" name="personResponsible" id="personResponsibleA"rows="10" cols = "10"></textarea> </td>
                   <td> <textarea style="width: 150px; height: 250px;" name="relationshipA" id="relationshipA"rows="10" cols = "10"></textarea></td>
                   <td> <textarea style="width: 150px; height: 250px;"  name="paidSupportA" id="paidSupportA" rows="10" cols = "10"></textarea></td>           
                   <td><textarea style="width: 150px; height: 250px;"  name="naturalSupportA" id="naturalSupportA" rows="10" cols = "10"></textarea></td>
           </div>
            </tr>
             </table> 

                <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Suggested By:</label>              
                    <input type="text" name="suggestedByB" id="suggestedByB"/>      
            </div>      
            <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Support Strategy:</label>          
                    <input type="text" name="supportStrategyB" id="supportStrategyB" />        
            </div>      
            <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Action Item:</label>            
                    <input type="text" name="actionItemB" id="actionItemB"/>            
            </div>      
                    <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Stand Alone Support(s)/Provider(s):</label>             
                    <input type="text" name="standAloneSupport" id="standAloneSupport"/>                
            </div>
            
            <div style="margin-left:0" class="control-group span12">
             <label class="control-label">Is a comprehensive plan necessary in order to address specific serious:</label>
                </div>
             <div style="margin-left:0" class="control-group span12">
                <label class="control-label">Maladaptive behavior issues?</label>

                    <input type="text" name="hasMaladaptiveBehavior" id="hasMaladaptiveBehavior" />
            </div>
             <div style="margin-left:0" class="control-group span12">   
                <label class="control-label">Medical issues?</label>
                    <input type="text" name="medicalIssue" id="medicalIssue"/>
            </div>      
          </div>
            <br /><br />
    <div class="controls">   
            <button onclick="$('create').submit()"><i class="icon-plus-sign icon4x"></i>Submit</button>
            <button onclick="window.location='/account/manage/';return false"><i class="icon-remove icon4x"></i>Cancel</button>
        <input type="button" value=" Print this page"
                onclick="window.print();return false;" />
        </form> 
</div>


@section('scripts')
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">

        $(".datepicker").datepicker({
        buttonImage: '/img/calendar.gif',
        buttonImageOnly: true,
        showButtonPanel: true,
        showOn: 'both', 
        buttonText: 'Show Calendar',
        minDate: new Date(),
        dateFormat: " yy-m-d",
        onSelect: function(dateText, inst) {
            $(this).attr('value',dateText);
        }
        });
        

function itemSave (criteria) {
        var fields = [];
        var i=0;
        $("#fields").children().each(function () {
                fields[i] = {};
                        fields[i]['response']= $(this).find('input').val(),
                        fields[i]['trackedtemplatefield_id']= $(this).attr('data-templatefield_id')
                if($(this).attr('data-id') !== 'undefined')
                        fields[i]['id'] = $(this).attr('data-id');
                i++;
        })
        if(fields.length > 0)
                $("#fieldJson").val(JSON.stringify(fields));
        
        $("#upload_target").load(function () {
                updateSelectList(0);
                updateSelectList(1);
        });
        $("#itemForm").submit();
}

function errorDialog(msg){
        $('#errorDialog').text(msg);
        $('#errorDialog').dialog({
                modal: true,
                buttons: {
                        'Ok':function(){
                                $(this).dialog('close');
                        }
                }
        });
}
</script>

@endsection
