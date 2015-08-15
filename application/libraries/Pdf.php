<?php

require_once APPPATH . '/third_party/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {

    public $image_file;
    public $link;
    public $href;
    public $copyright;
    public $extention;

    public function Header() {
        #custom by sohaib
        parent::Header();
        $this->setRTL(true);
        $this->Image($this->image_file, 200, 5, '30', '15', $this->extention, '', 'R', false, 300, '', false, false, false, false, false, false);
        $this->SetFont('aealarabiya', 'I', 12);
        $this->setRTL(false);
        $html_head = '<a href="http://' . $this->href . '">' . $this->link . '</a>';
        $this->writeHTMLCell($w = 150, $h = '10', $x = '', $y = 20, $html_head, $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true);
    }

    public function Footer() {
        #custom by sohaib
        $this->SetFont('aealarabiya', 'I', 8);
        $cur_y = $this->y;
        $this->SetTextColorArray($this->footer_text_color);
        $line_width = (0.85 / $this->k);
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
        $w_page = ' صفحة';
        if (empty($this->pagegroups)) {
            $pagenumtxt = $w_page . $this->getAliasNumPage() . ' من ' . $this->getAliasNbPages();
       } else {
           $pagenumtxt = $w_page . $this->getPageNumGroupAlias() . ' من ' . $this->getPageGroupAlias();
       }
        $this->SetY($cur_y);
        $this->SetX($this->original_rMargin);
        $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');

        $this->SetFont('aealarabiya', 'I', 10);
        $html = $this->copyright;
        $this->SetY(-15);
        $this->setRTL(true);
        $this->Cell(0, 10, $html, 0, false, 'R', 0, '', 0, false, 'A', 'T');
    }

}

class Pdf {

    function creatNewPdf() {

        $agru = func_get_arg(0);
        $logo = $agru['logo'];
        $link = $agru['link'];
        $target = $agru['target'];
        $logoExtention = $agru['logo_extention'];
        $date = $agru['date'];
        $title = $agru['title'];
        $disc = $agru['description'];
        $image = $agru['image'];
        $content = $agru['content'];
        $copyright = $agru['copyright'];
        $fileName = $agru['file_name'];
        $pdfCreator = $agru['pdf_creator'];
        $pdfAuthor = $agru['pdf_author'];
        $pdfTitle = $agru['pdf_title'];
        $pdfSubject = $agru['pdf_subject'];
        $pdfKeywords = $agru['pdf_keywords'];

// create new PDF document
        $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setTempRTL('R');
        
        $pdf->image_file = $logo;
        $pdf->href = $target;
        $pdf->link = $link;
        $pdf->copyright = $copyright;
        $this->extention = $logoExtention;


# must included in each decument[Must Include]
// appear in document properties
        $pdf->SetCreator($pdfCreator);
        $pdf->SetAuthor($pdfAuthor);
        $pdf->SetTitle($pdfTitle);
        $pdf->SetSubject($pdfSubject);
        $pdf->SetKeywords($pdfKeywords);
       
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, ' ', ' ', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
// header and footer fonts
        
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// end of header
# set default monospaced font[Must Include]
        
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

# set margins[Must Include]
        
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// header & footer margin
       
        $pdf->SetHeaderMargin(50);
        $pdf->SetFooterMargin(20);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        //$pdf->SetFont('almohanad', '', 13);

        $pdf->setRTL(true); // cehck here if ar or en
        $pdf->startPageGroup();
        $pdf->AddPage();
        
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $pdf->setLanguageArray($lg);

        $pdf->SetFont('almohanad', '', 13);
        $pdf->setRTL(true); // cehck here if ar or en


        $html = '

<div >
<br/>
  <span id="date"style="color:#008080"  > '.$date.' </span>        
  <h3 id="title" style="color:#191970"> '.$title.' </h3>        
  <h5 id="description" style="color:#6A5ACD"> '.$disc.' </h5> 
  <img src="'.$image.'" alt="'.$title.'"  /> 
   <div style="align:justify"> '.$content.'  </div>   

</div>

               ';

       // $pdf->writeHTML($html, true, false, false, true, "");
        $pdf->writeHTMLCell($w=170, $h=0, $x=0, $y=0, $html, $border=0, $ln=0, $fill=false, $reseth=true, $align="R");
        $pdf->setRTL(true);

#excute the file
        $pdf->Output(PDF_FILES . $fileName . '.pdf', 'F');
    }

}

?>
