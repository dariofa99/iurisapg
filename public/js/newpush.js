var socket = io('https://iuris.udenar.edu.co:3000', {secure: true});
/* 
socket.on('edKXuiy2wUmX9_K64OMcQQlogin', function(data){

    var viewC = new ViewComponents();
    usersLogin[data.id]=data;
    var row = viewC.renderUsersLogin(usersLogin);
    $("#list_users_login").html(row);  
    var lenhgtUsers = usersLogin.filter(Boolean);
    $(".lbl_chatCountUsers").text(lenhgtUsers.length);
    //usersLogin = res;          

});

socket.on('edKXuiy2wUmX9_K64OMcQQlogout', function(data){
    
    console.log(usersLogin.length);
    usersLogin.splice( data.id, 1 );
    console.log(usersLogin);

    $(".user_login-"+data.id).remove();  
    var lenhgtUsers = usersLogin.filter(Boolean);
    $(".lbl_chatCountUsers").text(lenhgtUsers.length);
  
});

*/
socket.on('LIuOgI52dWJxe0ZMstream'+$("#user_session_idnumber").val(), function(data){
    console.log(data.sol_id);
    Swal.fire({
        allowOutsideClick: false,
        title: 'Invitación a videollamada, aceptar?',
        text: '',
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, aceptar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            var win = window.open('https://videochat.udenar.edu.co/'+data.sol_id, '_blank');
                win.focus();
        }
    });
  
}); 

socket.on('LIuOgI52dWJxe0ZMsolicitudes_send', function(data){  
   
    if(data.solicitud_id == $("#solicitud_id").val()){
        $("#content_solicitud_espera").html(data.render);
        console.log("Aqui estoy")
        //x = setInterval(displayTime, 1000);  
        window.location.reload(true);      
    }
   if(data.tur_aten!=null) $("#lbl_turno").text(data.tur_aten);  

});

socket.on('LIuOgI52dWJxe0ZMsolicitudes_coord', function(data){
    //x = setInterval(displayTime, 1000);       
    if(data.solicitud_id == $("#solicitud_id").val()){
        if(data.type_status)  $("#lbl_status_sol").html(data.type_status); 
        //
        if($("#content_edit_solicitud").length > 0 && (data.type_status_id==165 || data.type_status_id==158)) {
           // $("#con_timer").remove();
            window.location.reload(true)
        } 

    }   
    if(data.render){
        $("#content_list_solicitudes").html(data.render); 
    }
    if(data.renderh)$("#content_list_solicitudesh").html(data.renderh);    
});


socket.on('LIuOgI52dWJxe0ZMnotifications_'+$("#user_session_idnumber").val(), function(data){  
    if(data.render){
        $("#table_list_model").html(data.render); 
    }
  
    if(data.notifications) $("#menu-notification").html(data.notifications); //$("").html(data.notifications)
   

}); 


 

 

