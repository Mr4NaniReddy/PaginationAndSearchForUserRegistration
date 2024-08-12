function pagination(totalpages, currentpages){
    var pagelist = "";
    if(totalpages > 1){
        currentpages = parseInt(currentpages);
        pagelist += `<ul class="pagination justify-content-center">`;
        const prevClass =  currentpages==1 ? "disabled" : "";
        pagelist += `<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${currentpages-1}">Previous</a></li>`;
        for(let p=1; p<=totalpages; p++){
            const activeClass = currentpages==p ? "active" : "";
            pagelist += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
        }

        const nextClass =  currentpages==totalpages ? "disabled" : "";
        pagelist += `<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${currentpages+1}">Next</a></li>`;
        pagelist += `</ul>`;
    }
    $("#pagination").html(pagelist);
}



function getuserrow(user, number) {
    return `<tr>
        <td>${number}</td>
        <td>${user.firstname}</td>
        <td>${user.lastname}</td>
        <td>${user.email}</td>
        <td>${user.mobile}</td>
        <td scope="row"><img src="uploads/${user.photo}" alt="User Photo" style="width: 50px; height: 50px;"></td>

        <td>
            <a href="#" class="mr-3 profile" data-target="#userViewModal" data-toggle="modal" title="view" data-id="${user.id}"><i class="fas fa-eye text-success"></i></a>
            <a href="#" class="mr-3 edituser" title="edit" data-id="${user.id}">
                <i class="fas fa-edit text-info"></i>
            </a>
            <a href="#" class="mr-3 deleteuser" title="delete" data-id="${user.id}"><i class="fas fa-trash-alt text-danger"></i></a>
        </td>
    </tr>`;
}


function getUsers(){
    var pageno = parseInt($("#currentpage").val());
    var itemsperPage = 5;
    var startnumber = (pageno-1) * itemsperPage + 1;
    $.ajax({
        url: "/PHPAdvancedWebsite/ajax.php",
        type: "GET",
        dataType: "json",
        data: { page: pageno, action: 'getallusers' },
        beforeSend: function(){
            console.log("Waiting");
        },
        success: function(response){
            console.log(response);
            if (response.users && response.users.length > 0) { 
                var userslist = "";
                var number = startnumber;
                $.each(response.users, function(index, user){
                    userslist += getuserrow(user,number);
                    number++;
                });
                $("#usertable tbody").html(userslist);
                let totaluser = response.count;
                let totalpage = Math.ceil(parseInt(totaluser)/5);
                const currentpage = $("#currentpage").val();
                pagination(totalpage, currentpage);
            } else {
                console.log('No users found.');
                $("#usertable tbody").html("<tr><td colspan='5'>No users found.</td></tr>");
            }
        },
        error: function(xhr, status, error){
            console.log('Oops! something went wrong:', status, error);
        } 
    });
}


function readURL(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(previewId).attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}



$(document).ready(function(){
    getUsers();


    $('#userphoto').change(function(){
        readURL(this, '#imagePreview');
    });

    $('#update_photo').change(function(){
        readURL(this, '#updateimagePreview');
    });

    //adding new user                                                     

    $(document).on("submit", "#addform", function(e){
        e.preventDefault();
        clearErrors();
        var formData = new FormData(this);
        $.ajax({
            url: "/PHPAdvancedWebsite/ajax.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                console.log("Wait... Data is loading");
            },
            success: function(data){
                if(data){
                    $(".displaymessage").html("User Added successfully").fadeIn().delay(2000).fadeOut();
                    console.log("Form submitted successfully.");
                    $('#usermodal').modal('hide');
                    $('#addform')[0].reset();
                    $('#imagePreview').hide();
                    getUsers();
                }
               
            },
            error: function(xhr){
                var errors = JSON.parse(xhr.responseText);
                displayErrors(errors);
            }
        });
    }); 
    $('#usermodal').on('hidden.bs.modal', function () {
        $('#addform')[0].reset();
        $('#imagePreview').hide(); 
        clearErrors();
    });
    

    $(document).on("click", "ul.pagination li a", function(event){
        event.preventDefault();

        const pagenum = $(this).data("page");
        $("#currentpage").val(pagenum);
        getUsers(); 
    });

    $(document).on("submit", "#updateform", function(e){
        e.preventDefault();
        clearErrors();
        var formData = new FormData(this);
        $.ajax({
            url: "/PHPAdvancedWebsite/ajax.php",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                $(".displaymessage").html("User updated successfully").fadeIn().delay(2000).fadeOut();

                $('#userupdatemodal').modal('hide');
                getUsers();
            },
            error: function(xhr){
                var errors = JSON.parse(xhr.responseText);
                displayErrors(errors, 'update');
            }
        });
    });
    

    //onclick event for editing

    $(document).on("click", "a.edituser", function(event) {
        event.preventDefault();
        var userId = $(this).data("id");
        getUserDetails(userId);
    });



    // onclick for deleting

    $(document).on("click", "a.deleteuser", function(e){
        e.preventDefault();
        var uid = $(this).data("id");
        if(confirm("Are you sure you want to delete user?")){
            $.ajax({
                url: "/PHPAdvancedwebsite/ajax.php",
                type: "GET",
                dataType: "json",
                data: {id:uid, action:"deleteuser"},
                beforeSend: function(){
                    console.log("waiting");
                },
                success: function(response){
                    if(response.deleted == 1){
                        $(".displaymessage").html("User deteled successfully").fadeIn().delay(2000).fadeOut();
                        getUsers();
                        console.log("done");
                    }
                },
                error: function(){
                    console.log("Oops something went wrong");
                }
            })
        };

    });

    // profile view
    $(document).on("click", "a.profile", function(){
        var uid = $(this).data("id");
        $.ajax({
            url: '/PHPadvancedwebsite/ajax.php',
            type: 'GET',
            dataType: "json",
            data: {id:uid, action:"edituserdata"},
            success: function(user){
                if(user){
                    const profile= `<div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="uploads/${user.photo}" alt="Image" style="width: 70px; height: 70px;" class="rounded">
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4 class="text-primary">${user.firstname} ${user.lastname}</h4>
                        <p>
                            <i class="fas fa-envelope-open"></i> ${user.email}
                             <br>
                            <i class="fas fa-phone"></i> ${user.mobile}
                        </p>
                    </div>
                    </div>`;
                    $("#profile").html(profile);
                }
            },
            error: function(){
                console.log("something went wrong");
            }
        });
    });

    //search data or seach user
    $(document).on("keyup", ".search_input", function () {
        const searchText = $(this).val();
        var current_id = $(this).attr('id');
        if(searchText.length >=1 ){
            $.ajax({
                url: "/PHPAdvancedwebsite/ajax.php",
                type: "GET",
                dataType: "json",
                data: {searchQuery: searchText, action: "searchuser", current_id: current_id},
                success: function(users){
                    if (Array.isArray(users) && users.length > 0) {
                        var userslist = "";
                        var x = 1;
                        $.each(users, function(index, user) {
                            userslist += getuserrow(user, x);
                            x++;
                        });
                        $("#usertable tbody").html(userslist);
                        $("#pagination").hide();
                    } else {
                        $("#usertable tbody").html("<tr><td colspan='4'>No user found</td></tr>");
                    }
                    
                },
                error: function(){
                    console.log("Something went wrong");
                },
            });
        } else{
            getUsers();
            $("#pagination").show();
        }
    });


    
      
    // Get users function
    getUsers();
}); 

function getUserDetails(userid){
    $.ajax({
        url: '/PHPAdvancedwebsite/ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {id: userid, action:"edituserdata"},
        success: function(user){
            // console.log("User details received:", user);

            $('#updateuserid').val(user.id);
            $('#updatefirstname').val(user.firstname);
            $('#updatelastname').val(user.lastname);
            $('#updateemail').val(user.email);
            $('#updatemobile').val(user.mobile);
            $('#updatepassword').val(user.password);
            if(user.photo){
                $('#updateimagePreview').attr('src', 'uploads/'+ user.photo).show();
            } else {
                $('#updateimagePreview').hide();
            }
            console.log(user.photo);


            
            $('#userupdatemodal').modal('show');
        },
        error: function(xhr, status, error) {
            console.log("XHR:", xhr);
            console.log("Status:", status);
            console.log("Error:", error);
            console.log("Response Text:", xhr.responseText);
        },
    });
}



function displayErrors(errors, prefix = '') {
    for (var key in errors) {
        $('#' + prefix + key + 'Error').text(errors[key]);
    }
}

function clearErrors() {
    $('.error').text('');
}




