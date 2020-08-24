<?php 
header('Content-type: image/jpeg');

include_once ('../../../includes/dbh.php');
ob_start();
session_start();

if (0) {
	header("");
}else{
   
    //Here, There was the code to check whether user has generated the certi before or not. The response is stored in $resultcheck
    if ($resultcheck == 1){
        $row = mysqli_fetch_assoc($result);
        
        if ($row['certi'] == 1){
            header("Location: ../?certificate=onetimeaccess");
        }else{
            //$sql = "UPDATE name SET ...."; Updating that user has generated in database
            mysqli_query($conn,$sql);
            $image=imagecreatefromjpeg("certificate.jpg");
            $color=imagecolorallocate($image,255,255, 255);
            $date=date('d F, Y');
            imagettftext($image, 65, 0, 1650, 1630, $color,'arial', $date);
            
           /* $id = $row['password'];
            imagettftext($image, 30, 0, 75, 2200, $color,'arial', $id); */
            
            $name=$_GET['certi'];
            $len = strlen($name);
            
            if ($len <=13){
                imagettftext($image, 165, 0, 1150, 1230, $color,'arial', $name);
            }else if ($len <=16 && $len > 13){
                imagettftext($image, 145, 0, 960, 1230, $color,'arial', $name);
            }else if ($len <=22 && $len > 16){
                imagettftext($image, 145, 0, 910, 1230, $color,'arial', $name);
            }else{
                imagettftext($image, 110, 0, 850, 1230, $color,'arial', $name);
            }
            
            $file = 'certi/'.time().'_'.$row['orderid'].".jpg";
            $file_pdf = 'certi/'.time().'_'.$row['orderid'].".pdf";
            
            
            imagejpeg($image,$file);
            imagedestroy($image);
            
            require('fpdf.php');
	        $pdf=new FPDF();
	        $pdf->AddPage('a4');
	        $pdf->Image($file,0,0,300,210);
	        $pdf->Output($file_pdf,"F");
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/force-download');
            header("Content-Disposition: attachment; filename=\"" . basename($file_pdf) . "\";");
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_pdf));
            ob_clean();
            flush();
            readfile($file_pdf); //showing the path to the server where the file is to be download
            exit;
            
    
        }
        
        
    }else{
        header("Location: ../?certificate=error");
    }
    
}
?>