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
        <section class="panel">
            
            <div class="panel-body">
                <div class="pl-sm">
                  <h3>Version information and change logs</h3>
                  

<table>
  <tr>
   <th>File</th>
    <th>Context</th>
    <th>Download</th>
     <th>Update date</th>
    <th>View logs</th>
  </tr>
  
    <td>Xor Generator</td>
   <td>Compact the downloaded license from the License panel.</td>
      <td><center><a  href="https://www.softwarerg.com/Xor_License_Generator.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>19-02-2023</center></td>
            <td <label onclick="myFunction()"><center><img src="assets/images/ver.png"width="30"/></center></label></td>
  
  </tr>
     <td>Season 1 Original</td>
   <td>Remember to replace everything that is shipped.</td>
      <td><center><a  href="https://www.softwarerg.com/S1_XOR.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>14-03-2023</center></td>
 
  </tr>
   <td>Season 3 Original</td>
   <td>Remember to replace everything that is shipped.</td>
      <td><center><a  href="https://www.softwarerg.com/S3_XOR.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>14-03-2023</center></td>
  
   </tr>
   <td>Season 4 Original</td>
   <td>Remember to replace everything that is shipped.</td>
      <td><center><a  href="https://www.softwarerg.com/S4_XOR.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>14-03-2023</center></td>
            
             </tr>
   <td>Season 6 or Downgrade</td>
   <td>Remember to replace everything that is shipped.</td>
      <td><center><a  href="https://www.softwarerg.com/S6_XOR.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>14-03-2023</center></td>


 </tr>
   <td>Season 8 Original</td>
   <td>Remember to replace everything that is shipped.</td>
      <td><center><a  href="https://www.softwarerg.com/S8_XOR.rar" target="_blank"><img src="assets/images/down.png"width="30"/></a></center></td>
            <td  style="color:#FF0000";><center>14-03-2023</center></td>
            
</table>



  <div id="myDIV" style="display: none;"><p>
    <h5 style="color:#FF0000">Logs Change 14-03-2023</h5>   
 <table>
  <tr>                       
<td><P><li>Fix crash (Cheat Engine)<b> &nbsp;</b><BR></li>
<li>Fix Auto Ban (We need more test)<b> &nbsp;</b><BR></li>
<li>Fix Valkyria last version <b> &nbsp;</b><BR></li>
<li>Add high level protection (Packer)<b> &nbsp;</b><BR></li>


</P></td>
   </table>
   </p>
   </div> 
   
  

                
                </div>
            </div>
            
            
  
            
           </section> 
        </section>
    </section>

    
    
    
@endsection

@section('script')
    <script type="text/javascript">
    function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display == "none") {
        x.style.display = "block";
    } else {
       x.style.display = "none";
      }
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