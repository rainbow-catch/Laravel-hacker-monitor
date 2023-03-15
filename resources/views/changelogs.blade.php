@extends('layouts.app')

@section('content')
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #CBFEDE;
}
</style>
    <section role="main" class="content-body">
        <!-- start: page -->
        <section class="panel" >
            
            <div class="panel-body">
                <div class="pl-sm">
                    
                  <h3 >Guides list</h3>
                  


                  
		  <table   width="149%" height="277" class="table table-bordered table-striped">
       <thead>
         <tr>
           <th width="10%">#</th>
           <center><th width="90%">System</th></center>
			  <th>Guide</th>
         </tr>
       </thead>
       <tbody>
		   <tr>
           <td><h4 ><span class="label label-success">[0]</span></h4></td>
           <td>
               
             <code><a  style="color:red">[Generate License XOR]</a><a style="color:darkcyan"> Here you will have the steps to install your anti hack license</a></code>
            
		      <td><span style="cursor:pointer" onclick="toggleTable();" class="label label-success" ><a  style="color:white">VIEW</a></span></td>
           </td>
           
        <tr>
           <td><h4 ><span class="label label-success">[1]</span></h4></td>
           <td>
               
             <code><a  style="color:red">[Generate CheckSum XOR]</a><a style="color:darkcyan"> File integrity verification</a></code>
            
		      <td><span style="cursor:pointer" onclick="checksumm();" class="label label-success" ><a  style="color:white">VIEW</a></span></td>
           </td>
           </td>
	<tr>
           <td><h4 ><span class="label label-success">[2]</span></h4></td>
           <td>
               
             <code><a  style="color:red">[Generate HackList XOR]</a><a style="color:darkcyan"> Add programs other than your users use</a></code>
            
		      <td><span style="cursor:pointer" onclick="hacklistt();" class="label label-success" ><a  style="color:white">VIEW</a></span></td>
           </td>
           </td>
<tr>
           <td><h4 ><span class="label label-success">[3]</span></h4></td>
           <td>
               
             <code><a  style="color:red">[Generate EncryptFiles XOR]</a><a style="color:darkcyan"> Protect your files from any user copying or releasing your texturess</a></code>
            
		       <td><span style="cursor:pointer" onclick="EncryptFiless();" class="label label-success" ><a  style="color:white">VIEW</a></span></td>
           </td>
           </td>

       </tbody>
       
       
       
  </table>      
    <table id="yourTable" style="display: none;>   
   <tr>
         <td><h4 ><span class="label label-success"></span></h4></td>
           <td>
           <P>
            <center><h3 ><a  style="color:orange "><b> Installation steps </b></a></h3></center>
            <BR>
<li>- Go Tools Download<b> [Menu panel]&nbsp;</b><BR></li>
<li>- Download Xor Generator, Season*<b> [Select your version.]</b><BR></li>
<li>- Go License complete the data and press generate<b> &nbsp;</b><BR></li>
<li>- Extract everything that was downloaded to a new folder on your desktop<b> &nbsp;</b><BR></li>
<li>- Open <a style="color:orange"><b> Xor_License.exe </b></a> <b> &nbsp;</b><BR></li>
<li>- Choose <a style="color:orange"><b> [0] Generate License </b></a> and wait 2 seconds</li>
<li>- Copy the <a style="color:orange"><b> Xor_Plus </b></a> folder and <a style="color:orange"><b> Xor.dll </b></a> to your client<b> &nbsp;</b><BR></li>
<li>- Open your Maininfo.ini and put in <a style="color:orange"><b> IpAddress = 0 </b></a><b> &nbsp;</b><BR></li>
<li>- Add the name Xor.dll in <a style="color:orange"><b> Plugin1 = Xor.dll </b></a><b> &nbsp;</b><BR></li>
<li>- Run your GetMainInfo-Premium.exe or Encoder whatever you are using<b> &nbsp;</b><BR></li>
<li>- Copy what was generated and paste in your client.<b> &nbsp;</b><BR></li>
</P>
<center><h3 ><a style="color:orange"><b> Step by step installation video </b></a></h3></center>
<BR>
              <center> <iframe width="620" height="415"
src="https://www.youtube.com/embed/dgNTXNeI1lI">
</iframe></center>
             
           </td> 
    </table>   
    
    
        <table id="checksum" style="display: none;>   
   <tr>
         <td><h4 ><span class="label label-success"></span></h4></td>
           <td>
           <P>
            <center><h3 ><a  style="color:orange "><b> Generate CheckSum </b></a></h3></center>
            <BR>
<li>- Copy all the files you want to check to the <a style="color:orange"><b> Checksum </b></a> folder<b> [Keep location example Data/Local/Text.bmd]&nbsp;</b><BR></li>
<li>- Open <a style="color:orange"><b> Xor_License.exe </b></a> <b> &nbsp;</b><BR></li>
<li>- Choose <a style="color:orange"><b> [1] Generate Checksum </b></a> and wait </li>
<li>- Copy the <a style="color:orange"><b> Xor_Plus </b></a> folder to your client<b> &nbsp;</b><BR></li>

</P>
           </td> 
    </table>   
    
    
    
    
    <table id="hacklist" style="display: none;>   
   <tr>
         <td><h4 ><span class="label label-success"></span></h4></td>
           <td>
           <P>
            <center><h3 ><a  style="color:orange "><b> Generate HackList </b></a></h3></center>
            <BR>
<li>- Copy all the files you want to add in BD hack to the <a style="color:orange"><b> HackList </b></a> folder<b> &nbsp;</b><BR></li>
<li>- Open <a style="color:orange"><b> Xor_License.exe </b></a> <b> &nbsp;</b><BR></li>
<li>- Choose <a style="color:orange"><b> [2] Generate HackList </b></a> and wait </li>
<li>- Copy the <a style="color:orange"><b> Xor_Plus </b></a> folder to your client<b> &nbsp;</b><BR></li>

</P>
           </td> 
    </table>   
    
    
     <table id="EncryptFiles" style="display: none;>   
   <tr>
         <td><h4 ><span class="label label-success"></span></h4></td>
           <td>
           <P>
            <center><h3 ><a  style="color:orange "><b> Generate EncryptFiles </b></a></h3></center>
            <BR>
<li>- Copy all the files you want to  the <a style="color:orange"><b> EncryptFiles </b></a> folder<b> [Keep location example Data/Local/Text.bmd] &nbsp;</b><BR></li>
<li>- Open <a style="color:orange"><b> Xor_License.exe </b></a> <b> &nbsp;</b><BR></li>
<li>- Choose <a style="color:orange"><b> [3] Generate EncryptFiles </b></a> and wait </li>
<li>- Copy the <a style="color:orange"><b> Xor_Plus </b></a> folder to your client<b> &nbsp;</b><BR></li>
<li>- Copy the contents of the <a style="color:orange"><b> EncryptFiles </b></a> folder and paste it into your client<b> &nbsp;</b><BR></li>
</P>
           </td> 
    </table>   
    
    
    
                </div>
            </div>
            
            
            
            
           </section> 
        </section>
    </section>

    
    
    
@endsection

@section('script')
    <script type="text/javascript">
        
        function toggleTable() {
    var myTable = document.getElementById("yourTable");
    myTable.style.display = (myTable.style.display == "none") ? "table" : "none";
}
function checksumm() {
    var myTable = document.getElementById("checksum");
    myTable.style.display = (myTable.style.display == "none") ? "table" : "none";
}
function hacklistt() {
    var myTable = document.getElementById("hacklist");
    myTable.style.display = (myTable.style.display == "none") ? "table" : "none";
}
function EncryptFiless() {
    var myTable = document.getElementById("EncryptFiles");
    myTable.style.display = (myTable.style.display == "none") ? "table" : "none";
}
        (function($) {
            'use strict';

            var action;

            $(".btn-uninstall").click(function() {
                action = 'uninstall';
                $("#action-name").text("uninstall");

                $.magnificPopup.open({
                    items: {
                        src: '#confirm-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $(".btn-reinstall").click(function() {
                action = 'reinstall';
                $("#action-name").text("reinstall");

                $.magnificPopup.open({
                    items: {
                        src: '#confirm-dialog',
                        type: 'inline'
                    },
                    preloader: false,
                    modal: true,
                });
            });

            $("#confirm-dialog .dialog-ok").click(function () {
                window.location.href = "/ftp/"+action;
                $.magnificPopup.close();
            });

            $(".dialog-cancel").click(function () {
                $.magnificPopup.close();
            });
        }).apply(this, [jQuery]);
    </script>
@endsection


