<?php

class Certificate{
    public function CertificateSheet($CourseName =null , $StudentName =null,  $CetificateType =null, $CetificateDate =null )
    {
        $this->CounstrucStyle();
        $CertifacateShown =null;

        $PageSizeFlag = "<page size=\"A4\" layout=\"landscape\">";
        $InstituteFlag = "
        <img src=\"".V_UPLOAD_FOLDER_PATH."logo.jpg\" alt=\"Logo\" style=\"width:13%\">
        <universityNameEnglish>University of Baghdad</universityNameEnglish>
        <instituteNameEnglish>Continuous Education Center</instituteNameEnglish>
        <universityNameArabic>جامعة بغداد</universityNameArabic>
        <instituteNameArabic>مركز التعليم المستمر</instituteNameArabic>
        <CetifcateType>Certificate of Completion</CetifcateType>
        " ;

                
        $NameFlag = "<CourseName>"."$CourseName"."</CourseName>";
        $StudentFlage = "<StudentName>"."$StudentName"."</StudentName>";
        $TypeFlag = "<CetifcateType>"."$CetificateType"."</CetifcateType>";

        $CertifacateShown .= $PageSizeFlag.$InstituteFlag.$NameFlag.$StudentFlage.$TypeFlag;
        return $CertifacateShown;
    }

    private function CounstrucStyle (){
        print(
            # CSS
            "<style> 
            body {
                background: rgb(204,204,204); 
            }
            page {
                background: white;
                display: block;
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            }
            page[size=\"A4\"]{
                width: 21cm;
                height: 29.7cm; 
            }
            page[size=\"A4\"][layout=\"landscape\"] {
                width: 29.7cm;
                height: 21cm;  
            }
            page[size=\"A3\"] {
                width: 29.7cm;
                height: 42cm;
            }
            page[size=\"A3\"][layout=\"landscape\"] {
                width: 42cm;
                height: 29.7cm;  
            }
            page[size=\"A5\"] {
                width: 14.8cm;
                height: 21cm;
            }
            page[size=\"A5\"][layout=\"landscape\"] {
                width: 21cm;
                height: 14.8cm;  
            }

            h1 { 
                display: block;
                font-size: 2em;
                text-align: center;
                position: absolute;
                left: 25%;
                right: 25%;
                margin-left: auto;
                top: 50%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }
            h2 {
                display: block;
                font-size: 1.5em;
                position: absolute;
                left: 25%;
                right: 25%;
                margin-left: auto;
                top: 50%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }
            h3 { 
                display: block;
                font-size: 1.17em;
                position: absolute;
                left: 25%;
                right: 25%;
                margin-left: auto;
                top: 50%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            universityNameEnglish { 
                display: block;
                font-size: 2.2em;
                text-align: center;
                position: absolute;
                right: 60%;
                margin-left: auto;
                top: 12%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            instituteNameEnglish { 
                display: block;
                font-size: 1.5em;
                text-align: center;
                position: absolute;
                right: 61%;
                margin-left: auto;
                top: 18%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            universityNameArabic { 
                display: block;
                font-size: 2.6em;
                text-align: center;
                position: absolute;
                left: 67.4%;
                margin-left: auto;
                top: 12%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            instituteNameArabic { 
                display: block;
                font-size: 2em;
                text-align: center;
                position: absolute;
                left: 65%;
                margin-left: auto;
                top: 18%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }
            
            CetifcateType { 
                display: block;
                font-size: 2.8em;
                text-align: center;
                position: absolute;
                left: 28%;
                right: 25%;
                margin-left: auto;
                top: 33%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            StudentName { 
                display: block;
                font-size: 2.5em;
                text-align: center;
                position: absolute;
                left: 28%;
                right: 25%;
                margin-left: auto;
                top: 45%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            CourseName { 
                display: block;
                font-size: 2.5em;
                text-align: center;
                position: absolute;
                left: 28%;
                right: 25%;
                margin-left: auto;
                top: 60%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            CertificationDate { 
                display: block;
                font-size: 2.5em;
                text-align: center;
                position: absolute;
                left: 28%;
                right: 25%;
                margin-left: auto;
                top: 45%;
                buttom: 0%;
                margin-top: auto;
                margin-buttom: auto;
                font-weight: bold;
            }

            img {
                display: block;
                position: absolute;
                top: 8%;
                left: 28%;
                right: 25%;
                margin-top: auto;
                margin-buttom: auto;
                margin-left: auto;
                margin-right: auto;
            }
            @media print {
                body, page {
                    margin: 0;
                    box-shadow: 0;
                }
            }
            </style>"
        );
    }

}
    
    $CertificatePrint = new Certificate;

    # HTML
    echo $CertificatePrint ->CertificateSheet(
        "Certificate or Course Name",
        "Student Name",
        "Certificate of Completion"
    );

?>