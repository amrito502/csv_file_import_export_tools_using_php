<?php

session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV FILE UPLOAD IN SQL SERVER</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="csv__file_upload">
        <div class="container">
            <h4 class="text-center mt-4 mb-3 bg-success py-4 text-white">CSV FILE IMPORT AND EXPORT USING PHP & SQL SERVER</h4>
            <div class="row main_file_ex_im">
                <div class="col-md-8">
                    <div class="shadow main_import_area">
                        <?php
                        if (isset($_SESSION['status'])) {
                            echo  "<h5>" . $_SESSION['status'] . "</h5>";
                            unset($_SESSION['status']);
                        }
                        ?>
                        <!-- =============import-form================= -->
                        <form action="code.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="csv_file_label" for="csv_file_upload">CHOOSE CSV FILE</label>
                                <input type="file" name="csv_file_upload" id="csv_file_upload" class="csv_input_field form-control my-3">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="csv_btn csv_btn_import btn" name="csv_file_upload_btn">IMPORT</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow main_export_area">
                        <!-- =============export-form================= -->
                        <form action="code.php" method="post">
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="export_file_type" class="select_field form-control" style="cursor: pointer;">
                                        <option value="secect_file"> -- SELECT FILE EXT -- </option>
                                        <option value="xlsx">xlsx</option>
                                        <option value="xls">xls</option>
                                        <option value="csv">csv</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="csv_btn csv_btn_export btn" name="export_excel_btn">EXPORT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- =============fetch-data============== -->

    <div class="Fetch_Data mt-5">
        <div class="container shadow">
            <h3 class="text-center my-3 pt-2">All Student Data</h3>
            <?php
            if (isset($_SESSION['delete_status'])) {
                echo  "<h5>" . $_SESSION['delete_status'] . "</h5>";
                unset($_SESSION['delete_status']);
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="post">
                        <a href="" class="btn btn-danger btn-sm mb-3">Delete All Data</a>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = mysqli_connect("localhost", "root", "", "csv_file_upload_tools");

                            // ==========read file================
                            $select_query = "SELECT * FROM students_table";
                            $result = mysqli_query($conn, $select_query);
                            foreach ($result as $row) {
                                $id = $row['id'];
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="" id="">
                                    </td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['course']; ?></td>
                                    <td>
                                        <a href="delete.php?delete_id=<?php echo $id; ?>" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>