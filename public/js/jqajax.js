$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});

    $('#message').hide();
    $('#updateStudent').hide();
    $('#errorMessage').hide();
    $('#crossBtn_error').click(function(){
        $('#errorMessage').hide();
    });
    $('#crossBtn').click(function(){
        $('#message').hide();
    });
    // student view start

    function allStudentList(){
       
        $.ajax({
            url:"/student/list/",
            type:"GET",
            datatype:"json",
            success:function(response){
                console.log(response);
                var resp = "";
                for(let i = 0;i<response.length;i++){
                    resp  +="<tr>"+
                    "<td>"+ response[i].id +"</td>"+
                    "<td>"+ response[i].student_name +"</td>"+
                    "<td>"+ response[i].student_email +"</td>"+
                    "<td>"+ response[i].student_contact +"</td>"+
                    "<td>"+ "<button id='editBtn' class='btn btn-primary btn-sm' onclick='editData("+response[i].id+")'>Edit</button>"+" "+
                    "<button class='btn btn-danger btn-sm' onclick='deleteData("+response[i].id+")'>Delete</button>"
                    +"</td>"+
                    +"</tr>";
                }
                $('#tbody').html(resp);
                
                
                
            }
        });
       

    }
     allStudentList();

    // student view finish

    //clearing student field
    function clearField(){
        $('#student_name').val("");
        $('#student_email').val("");
        $('#student_contact').val("");
    }

   

    // student insertion start

    $('#addStudent').click(function(e){
        e.preventDefault();
        let student_name = $('#student_name').val();
        let student_email = $('#student_email').val();
        let student_contact = $('#student_contact').val();
        var student_information = {
            student_name:student_name,
            student_email:student_email,
            student_contact:student_contact
        };
        console.log(student_name+" "+student_email+" "+ student_contact);
        $.ajax({
            url:"/student/store/",
            type:"POST",
            data:student_information,
            success:function(response){
                console.log(response);
                clearField();
                allStudentList();
                $('#message').show();
               
               
            },
            error:function(error){
                console.log(error);
                $('#errorMessage').show();
            }
        });
    });
    //student insertion end 





    // editng data start
    function editData(id){
        $.ajax({
            type:"GET",
            dataType:"json",
            url:"/student/edit/"+id,
            success:function(response){
                console.log(response);
                $('#student_id').val(id);
                $('#student_name').val(response.student_name);
                $('#student_email').val(response.student_email);
                $('#student_contact').val(response.student_contact);
                $('#updateStudent').show();
                $('#addStudent').hide();
               // console.log(id +"okdkks");


            },
            error:function(error){
                console.log(error);
            }

        }); 
    }
  //  editData end;

 // delete student start 
    function deleteData(id){
        let student_id = id;
        $.ajax({
            url:'/student/delete/'+student_id,
            type:"POST",
            success:function(response){
                console.log(response);
                allStudentList();
                
                
            },
            error:function(error){
                console.log(error);
            }

        });
       
    }

 //delete student end  

 // update student start
    $('#updateStudent').click(function(e){
        e.preventDefault();
        let student_id = $('#student_id').val();
        let student_name = $('#student_name').val();
        let student_email = $('#student_email').val();
        let student_contact = $('#student_contact').val();
        var student_update = {
            student_name:student_name,
            student_email:student_email,
            student_contact:student_contact,
        };
        $.ajax({
            url:'/student/update/'+student_id,
            type:'POST',
            dataType:'json',
            data:student_update,
            success:function(response){
                console.log(response);
                allStudentList();
            }
        });
    });
    

 // update student end 
