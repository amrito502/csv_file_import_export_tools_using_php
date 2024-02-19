<?php
session_start();
$conn = mysqli_connect("localhost","root","","csv_file_upload_tools");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

// ==========csv file Export======================

if (isset($_POST['export_excel_btn'])) {
	$file_ext_name = $_POST['export_file_type'];
	$fileName = "student-sheet";
	$student = "SELECT * FROM students_table";
	$query_run = mysqli_query($conn, $student);

	if (mysqli_num_rows($query_run) > 0) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'Full Name');
		$sheet->setCellValue('C1', 'Email');
		$sheet->setCellValue('D1', 'Phone');
		$sheet->setCellValue('E1', 'Course');

		$rowCount = 2;
		foreach($query_run as $data){
			$sheet->setCellValue('A'.$rowCount, $data['id']);
			$sheet->setCellValue('B'.$rowCount, $data['fullname']);
			$sheet->setCellValue('C'.$rowCount, $data['email']);
			$sheet->setCellValue('D'.$rowCount, $data['phone']);
			$sheet->setCellValue('E'.$rowCount, $data['course']);
			$rowCount++;
		}

		if ($file_ext_name == 'xlsx')
		 {
			$writer = new Xlsx($spreadsheet);
			$final_filename = $fileName.'.xlsx';
		}
		elseif ($file_ext_name == 'xls')
		 {
			$writer = new Xls($spreadsheet);
			$final_filename = $fileName.'.xls';
		}
		elseif ($file_ext_name == 'csv')
		 {
			$writer = new Csv($spreadsheet);
			$final_filename = $fileName.'.csv';
		}
		// $writer->save($final_filename);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.urlencode($final_filename).'"');
		$writer->save('php://output');
	}
	else
	{
		$_SESSION['status'] = "No Record Found!";
		header('location: index.php');
		exit();
	}
}

// =====================================
// =============CSV FILE IMPORT=========
// =====================================
if(isset($_POST['csv_file_upload_btn'])){
    $allowed_ext = ['xls','csv','xlsx'];
    $fileName= $_FILES['csv_file_upload']['name'];
    $checking = explode(".", $fileName);
    $file_ext = end($checking);

    if(in_array($file_ext,$allowed_ext))
    {
        $targetPath = $_FILES['csv_file_upload']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach($data as $row){
            $id = $row['0'];
            $full_name = $row['1'];
            $email = $row['2'];
            $phone = $row['3'];
            $course = $row['4'];

            $checkStudent = "SELECT id FROM students_table WHERE id = '$id'";
            $check_student_result = mysqli_query($conn, $checkStudent);
            if(mysqli_num_rows($check_student_result) > 0)
            {
                //When data is already exists than update data
                $update_query = "UPDATE students_table SET fullname = '$full_name', email = '$email', phone = '$phone', course = '$course' WHERE id = '$id'";
                $update_result = mysqli_query($conn, $update_query);
                $msg = 1;
            }
            else
            {
                // New Record Insert
                $insert_query = "INSERT INTO students_table (fullname,email,phone,course) VALUES('$full_name','$email','$phone','$course')";
                $insert_result = mysqli_query($conn, $insert_query);
                $msg = 1;
            }
        
        }

        if(isset($msg)){
            $_SESSION['status'] = "File Imported Successfully!";
            header('location: index.php');
        }else{
            $_SESSION['status'] = "File Importing Failed!";
            header('location: index.php');
        }

    }
    else
    {
        $_SESSION['status'] = "Invalid File";
        header('location: index.php');
        exit(0);
    }
}






?>