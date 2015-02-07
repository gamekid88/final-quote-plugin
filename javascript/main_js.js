/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $(function () {

    $( "#dialog" ).dialog({
       display: none,
       buttons: {
            Ok: function() {
                $(this).dialog("close");
                }
            }    
        });
    });     
    
    
    
    function show_popup(id)
    {

        $( "#".id ).dialog();

    }