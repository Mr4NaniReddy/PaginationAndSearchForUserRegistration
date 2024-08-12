

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPAdvanced</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="css/styles.css"/>

</head>

<body>

    <h1 class="custom-bg-color-1 text-center text-light py-3 mt-1 mb-3" id="clickme">PHP advanced Registration Form</h1>

    <div class="container">
        <div class = "displaymessage1 bg-dark"><h4 class="displaymessage text-light text-center mb-3"></h4></div>
        <!-- form modal -->
        <?php include 'form.php'; ?>
        <?php include 'form2.php'; ?>
        <?php include 'profile.php'; ?>


        <!-- input search and button sectoin. Search by different inputs  -->
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text custom-bg-color-2"><i class="fas fa-search text-light" style="cursor:pointer"></i></span>
                    </div>
                    <input type="text" class="form-control search_input" placeholder="Search by firstname" id="searchinputbyfirstname">
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    
                    <input type="text" class="form-control search_input" placeholder="Search by lastname" id="searchinputbylastname">
                </div>
            </div>
            <div class="col-md-2">
                 <div class="input-group">
                  
                    <input type="text" class="form-control search_input" placeholder="Search by email" id="searchinputbyemail">
                </div>    
            </div>
            <div class="col-md-2">
                 <div class="input-group">
                    
                    <input type="text" class="form-control search_input" placeholder="Search by mobile" id="searchinputbymobile">
                </div>
            </div>
           
            <div class="col-md-2 text-right">
                <button class="btn btn-dark" type="button" id="adduserbtn" data-toggle="modal" data-target="#usermodal">Add New User</button>
            </div>
        </div>
        

        <!-- table  -->
        <?php include 'tableData.php'; ?>

        <!-- pagination  -->

        <nav aria-label="Page navigation example" id="pagination">
           
        </nav>
        <input type="hidden" name="currentpage" id="currentpage" value="1">
    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>