<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>AJAX CRUD Operation</title>
</head>


<body>
    <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD EMPLOYEE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="form">
                        <div class="mb-3">
                            <input type="hidden" name="page" id="page">
                            <label for="name" class="form-label">Name :</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                                placeholder="Enter Name" name="name">
                            <span class="text-danger remove" id="errname"></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                placeholder="Enter Email" name="email">
                            <span class="text-danger remove" id="erremail"></span>

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Gender :</label>
                            <input type="radio" name="gender" id="male" value="Male"> <label for="male">Male</label>
                            <input type="radio" name="gender" id="female" value="Female"> <label
                                for="female">Female</label>
                            <input type="radio" name="gender" id="other" value="Other"> <label for="other">Other</label>
                            <p><span class="text-danger remove" id="errgender"></span></p>


                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Language :</label>
                            <input type="checkbox" class="lang" name="language[]" id="hindi" value="Hindi"> <label
                                for="hindi" id="Hindi_lbl">Hindi</label>
                            <input type="checkbox" id="english" class="lang" name="language[]" value="English"> <label
                                for="english">English</label>
                            <input type="checkbox" id="gujrati" class="lang" name="language[]" value="Gujrati"> <label
                                for="gujrati">Gujrati</label>
                            <p><span class="text-danger remove" id="errlanguage"></span></p>

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label" id="cityLabel">City :</label>
                            <select name="city" id="city" class="form-control">
                                <option value="">Select City</option>
                                <option value="Ahmedabad">Ahmedabad</option>
                                <option value="Mumbai">Mumbai</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Mandar">Mandar</option>
                                <option value="Surat">Surat</option>
                            </select>
                            <p><span class="text-danger remove" id="errcity"></span></p>

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Upload Image :</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <p><span class="text-danger remove" id="errimage"></span></p>
                        </div>


                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"  id="save"
                            onclick="insertEmployee()">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT EMPLOYEE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit-form">
                        <div class="mb-3">
                            <input type="hidden" id="userid">
                            <input type="hidden" id="page">
                            <label for="edit-name" class="form-label">Name :</label>
                            <input type="text" class="form-control" id="edit-name" aria-describedby="emailHelp"
                                placeholder="Enter Name" name="name">
                            <span class="text-danger remove" id="erreditname"></span>

                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="edit-email" aria-describedby="emailHelp"
                                placeholder="Enter Email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Gender :</label>
                            <label>Gender :</label>
                            <input type="radio" name="gender" class="gender" id="edit-male" value="Male"> <label
                                for="edit-male">Male</label>
                            <input type="radio" name="gender" class="gender" id="edit-female" value="Female"> <label
                                for="edit-female">Female</label>
                            <input type="radio" name="gender" class="gender" id="edit-other" value="Other"> <label
                                for="edit-other">Other</label>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Language :</label>
                            <input type="checkbox" class="language" name="language[]" id="edit-hindi" value="Hindi">
                            <label for="edit-hindi" id="Hindi_lbl">Hindi</label>
                            <input type="checkbox" id="edit-english" class="language" name="language[]" value="English">
                            <label for="edit-english">English</label>
                            <input type="checkbox" id="edit-gujrati" class="language" name="language[]" value="Gujrati">
                            <label for="edit-gujrati">Gujrati</label>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">City :</label>
                            <select name="city" id="edit-city" class="form-control" style="width: 30%;">
                                <option value="">Select City</option>
                                <option value="Ahmedabad">Ahmedabad</option>
                                <option value="Mumbai">Mumbai</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Mandar">Mandar</option>
                                <option value="Surat">Surat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Upload Image :</label>
                            <input type="file" class="form-control" id="edit-image" name="image">
                            <p><span class="text-danger remove" id="errimage"></span></p>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="cancel">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="update"
                            onclick="editEmployee()">Save Changes</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center text-primary">AJAX CRUD OPERATION</h1>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary remove-btn" data-bs-toggle="modal"
                data-bs-target="#addEmployee">
                Add Emplopyee
            </button>
        </div>
        <h2 class="text-danger">All Records</h2>

        <div style="display: flex;" class="d-flex justify-content-center">
            <div>
                <input type="text" class="form-control" id="keywords" placeholder="Search here..."
                    onkeyup="searchFilter();">
            </div>

            <div style="margin-left: 10px;">
                <select class="form-control" id="genderfilter" onchange="searchFilter();">
                    <option value="">Filter by Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div style="margin-left: 10px;">
                <select class="form-control" id="cityfilter" onchange="searchFilter();">
                    <option value="">Filter by City</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Mandar">Mandar</option>
                    <option value="Surat">Surat</option>
                </select>
            </div>
            <div style="margin-left: 10px;">
                <select class="form-control" id="languagefilter" onchange="searchFilter();">
                    <option value="">Filter by Language</option>
                    <option value="Hindi">Hindi</option>
                    <option value="English">English</option>
                    <option value="Gujrati">Gujrati</option>
                </select>
            </div>

        </div>

        <div class="d-flex justify-content-center">
            <select name="limit" id="limit" class="p-1 m-4" onchange="searchFilter();">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
        <div class="d-flex justify-content-center" id="msg">

        </div>
        <div id="show_records" class="d-flex justify-content-center">
        </div>
        <div id="pagination" class="d-flex justify-content-center">

        </div>

        <div class="hello"></div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

</body>

</html>