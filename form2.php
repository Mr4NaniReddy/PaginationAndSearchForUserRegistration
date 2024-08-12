<!-- form modal -->
<div class="modal fade" id="userupdatemodal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Updating User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="updateform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!--first name  -->
                    <div class="form-group">
                        <label>First Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-user-alt text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="updatefirstname" name="updatefirstname">
                        </div>
                        <div class="error text-danger" id="updatefirstnameError"></div>

                    </div>

                    <!--last name-->
                    <div class="form-group">
                        <label>Last Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-user-alt text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="updatelastname" name="updatelastname">
                        </div>
                        <div class="error text-danger" id="updatelastnameError"></div>

                    </div>
                    
                    <!-- email  -->
                    <div class="form-group">
                        <label>Email:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-envelope-open text-light"></i></span>
                            </div>
                            <input type="email" class="form-control" id="updateemail" name="updateemail">

                        </div>
                        <div class="error text-danger" id="updateemailError"></div>

                    </div>

                    <!-- password -->
                    <div class="form-group">
                        <label>Password:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-solid fa-lock text-light"></i></span>
                            </div>
                            <input type="password" class="form-control" id="updatepassword" name="updatepassword" readonly>
                        </div>
                        <!-- <div class="error text-danger" id="passwordError"></div> -->

                    </div>


                    <!-- mobile  -->
                    <div class="form-group">
                        <label>Mobile:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-dark"><i class="fas fa-phone text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="updatemobile" name="updatemobile">

                        </div>
                        <div class="error text-danger" id="updatemobileError"></div>

                    </div>

                    <!-- image  -->
                    <div class="form-group">
                        <label>Profile Photo:</label>
                        <!-- <div class="input-group"> -->
                            <input type="file" class="form-control-file" id="update_photo" name="update_photo" accept="image/*">
                        <!-- </div> -->
                        <div class="error text-danger" id="profile_pictureError"></div>
                        <img id="updateimagePreview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;" class="mt-3"/>


                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <input type="hidden" name="action" value="updateuser">
                    <input type="hidden" name="updateuserid" id="updateuserid" value="">
                </div>
            </form>
        </div>
    </div>
</div>
