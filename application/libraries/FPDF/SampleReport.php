<?php
/**
 * Description of ProgressReport
 *
 * @author HIMEL
 */
require_once APPPATH.'libraries/FPDF/html2fpdf.php';

class AttendanceReport extends HTML2FPDF{
    protected $angle;
    private $data;
    private $date;

   
    public function setHeaderContent($data)
    {

        $this->data = $data;

         
    }
    

    public function Header() {
//        $this->SetFont("times", "b", "16");
//        $this->Cell(190,10,"BBC Media Action",0,1,"C");
//        
//        $height = 5;
//        $this->Cell(190,$height,"IK Tower (7th Floor), CEN (A) 2, Gulshan Avenue",0,1,"C");
//        $this->Cell(190,$height,"Gulshan-2, Dhaka-1212",0,1,"C");
//        
//        $this->SetFont("times", "Bu", "18");
//        $this->Cell(190,15,"Detailed Employee TimeSheet",0,1,"C");
//        $this->Cell(190,20,"",1,1,"C");
//        $this->SetY(48);
//        $this->print_cell(30,$height,"","11.5","Employee:",0,0,"R");
//        $name = "Oliver Francis Gomes (#1020)";
//        $nameLen = strlen($name);
//        $this->print_cell(($nameLen*5)/2,$height,"B","11.5",$name,0,0,"L");
//        
//        $this->print_cell(30,$height,"","11.5","Pay Periond:",0,0,"R");
//        $this->print_cell(30,$height,"B","11.5","N/A",0,1,"L");
//        $this->print_cell(30,$height,"","11.5","Title:",0,0,"R");
//        $this->print_cell(($nameLen*5)/2,$height,"","11.5","IT Assistant",0,0,"L");
//        $this->print_cell(30,$height,"","11.5","Branch:",0,0,"R");
//        $this->print_cell(30,$height,"","11.5","Dhaka Office",0,1,"L");
//        $this->print_cell(30,$height,"","11.5","Group:",0,0,"R");
//        $this->print_cell(($nameLen*5)/2,$height,"","11.5","Root",0,0,"L");
//        $this->print_cell(30,$height,"","11.5","Department:",0,0,"R");
//        $this->print_cell(30,$height,"","11.5","Operations",0,1,"L");
//        $this->Cell(190,10,"",0,1,"C");
//        
//        $this->SetFillColor(220, 220, 220);
//        $this->print_cell(10,10,"b","11.5","#",1,0,"C",true);      
//        $this->print_cell(18,10,"b","11.5","Date","T,B,R",0,"C",true);
//        $this->print_cell(12,10,"b","11.5","DoW","T,B,R",0,"C",true);
//        $this->print_cell(20,10,"b","11.5","In","T,B,R",0,"C",true);
//        $this->print_cell(20,10,"b","11.5","Out","T,B,R",0,"C",true);
//        $this->print_cell(20,10,"b","11.5","Worked\nTime","T,B,R",0,"C",true);
//        $this->print_cell(20,10,"b","11.5","Regular\nTime","T,B,R",0,"C",true);
//        $this->print_cell(25,10,"b","11.5"," ","T,B,R",0,"C",true);
//        $this->print_cell(25,10,"b","11.5"," ","T,B,R",0,"C",true);
//        $this->print_cell(19,10,"b","11.5"," ","T,B,R",1,"C",true);
        
    }
    
//    function print_cell($w,$h=0,$style='',$size,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
//    {
//        $this->SetFont("times",$style,$size);
//        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
//    }

//    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='') {
//        //Output a cell
//        $k = $this->k;
//        if ($this->y + $h > $this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
//            $x = $this->x;
//            $ws = $this->ws;
//            if ($ws > 0) {
//                $this->ws = 0;
//                $this->_out('0 Tw');
//            }
//            $this->AddPage($this->CurOrientation);
//            $this->x = $x;
//            if ($ws > 0) {
//                $this->ws = $ws;
//                $this->_out(sprintf('%.3f Tw', $ws * $k));
//            }
//        }
//        if ($w == 0)
//            $w = $this->w - $this->rMargin - $this->x;
//        $s = '';
//// begin change Cell function 12.08.2003
//        if ($fill == 1 or $border > 0) {
//            if ($fill == 1)
//                $op = ($border > 0) ? 'B' : 'f';
//            else
//                $op='S';
//            if ($border > 1) {
//                $s = sprintf(' q %.2f w %.2f %.2f %.2f %.2f re %s Q ', $border, $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
//            }
//            else
//                $s=sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
//        }
//        if (is_string($border)) {
//            $x = $this->x;
//            $y = $this->y;
//            if (is_int(strpos($border, 'L')))
//                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
//            else if (is_int(strpos($border, 'l')))
//                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
//
//            if (is_int(strpos($border, 'T')))
//                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
//            else if (is_int(strpos($border, 't')))
//                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
//
//            if (is_int(strpos($border, 'R')))
//                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
//            else if (is_int(strpos($border, 'r')))
//                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
//
//            if (is_int(strpos($border, 'B')))
//                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
//            else if (is_int(strpos($border, 'b')))
//                $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
//        }
//        if (trim($txt) != '') {
//            $cr = substr_count($txt, "\n");
//            if ($cr > 0) { // Multi line
//                $txts = explode("\n", $txt);
//                $lines = count($txts);
//                //$dy=($h-2*$this->cMargin)/$lines;
//                for ($l = 0; $l < $lines; $l++) {
//                    $txt = $txts[$l];
//                    $w_txt = $this->GetStringWidth($txt);
//                    if ($align == 'R')
//                        $dx = $w - $w_txt - $this->cMargin;
//                    elseif ($align == 'C')
//                        $dx = ($w - $w_txt) / 2;
//                    else
//                        $dx=$this->cMargin;
//
//                    $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
//                    if ($this->ColorFlag)
//                        $s.='q ' . $this->TextColor . ' ';
//                    $s.=sprintf('BT %.2f %.2f Td (%s) Tj ET ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + (.7 + $l - $lines / 2) * $this->FontSize)) * $k, $txt);
//                    if ($this->underline)
//                        $s.=' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
//                    if ($this->ColorFlag)
//                        $s.='Q ';
//                    if ($link)
//                        $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
//                }
//            }
//            else { // Single line
//                $w_txt = $this->GetStringWidth($txt);
//                $Tz = 100;
//                if ($w_txt > $w - 2 * $this->cMargin) { // Need compression
//                    $Tz = ($w - 2 * $this->cMargin) / $w_txt * 100;
//                    $w_txt = $w - 2 * $this->cMargin;
//                }
//                if ($align == 'R')
//                    $dx = $w - $w_txt - $this->cMargin;
//                elseif ($align == 'C')
//                    $dx = ($w - $w_txt) / 2;
//                else
//                    $dx=$this->cMargin;
//                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
//                if ($this->ColorFlag)
//                    $s.='q ' . $this->TextColor . ' ';
//                $s.=sprintf('q BT %.2f %.2f Td %.2f Tz (%s) Tj ET Q ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $Tz, $txt);
//                if ($this->underline)
//                    $s.=' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
//                if ($this->ColorFlag)
//                    $s.='Q ';
//                if ($link)
//                    $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
//            }
//        }
//// end change Cell function 12.08.2003
//        if ($s)
//            $this->_out($s);
//        $this->lasth = $h;
//        if ($ln > 0) {
//            //Go to next line
//            $this->y+=$h;
//            if ($ln == 1)
//                $this->x = $this->lMargin;
//        }
//        else
//            $this->x+=$w;
//    }

    public function Footer() {
        
    //Position at 1.5 cm from bottom
//    $this->SetY(-15);
//    //Arial italic 8
//    $this->SetFont('Arial','I',8);
//    //Page number
//    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    
    
}

?>
