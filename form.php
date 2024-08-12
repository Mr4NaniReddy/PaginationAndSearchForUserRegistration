<!-- form modal -->
<div class="modal fade" id="usermodal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding New Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="addform" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <!--first name  -->
                    <div class="form-group">
                        <label>First Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-user-alt text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                        <div class="error text-danger" id="firstnameError"></div>

                    </div>

                    <!--last name-->
                    <div class="form-group">
                        <label>Last Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-user-alt text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="error text-danger" id="lastnameError"></div>

                    </div>
                    
                    <!-- email  -->
                    <div class="form-group">
                        <label>Email:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-envelope-open text-light"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email">

                        </div>
                        <div class="error text-danger" id="emailError"></div>

                    </div>

                    <!-- password -->
                    <div class="form-group">
                        <label>Password:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-solid fa-lock text-light"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="error text-danger" id="passwordError"></div>

                    </div>

                    <!--confirm password -->
                    <div class="form-group confirmpassword">
                        <label>Confirm Password:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-solid fa-lock text-light"></i></span>
                            </div>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                        </div>
                        <div class="error text-danger" id="confirmPasswordError"></div>

                    </div>

                    <!-- mobile  -->
                    <div class="form-group">
                        <label>Mobile:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text custom-bg-color-2"><i class="fas fa-phone text-light"></i></span>
                            </div>
                            <input type="text" class="form-control" id="mobile" name="mobile" maxlength="10">

                        </div>
                        <div class="error text-danger" id="mobileError"></div>

                    </div>

                    <!-- image  -->
                    <div class="form-group">
                        <label>Profile Photo:</label>
                        <div class="input-group">
                            <input type="file" class="form-control-file" id="userphoto" name="photo" accept="image/*">
                        </div>
                        <div class="error text-danger" id="profile_pictureError"></div>
                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;" class="mt-3"/>


                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    <input type="hidden" name="action" value="adduser">
                    <!-- <input type="hidden" name="userid" id="userid" value=""> -->
                </div>
            </form>
        </div>
    </div>
</div>
