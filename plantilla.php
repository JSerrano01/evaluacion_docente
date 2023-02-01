<?php 
    require 'plugins/fpdf/fpdf.php';
    
    class PDF extends FPDF
    {
        protected $widths;
        protected $aligns;
        function Header()
        {
            $this->Ln(20);
        }
        function SetCol($col)
        {
            // Set position at a given column
            $this->col = $col;
            $x = 10+$col*65;
            $this->SetLeftMargin($x);
            $this->SetX($x);
        }
        function AcceptPageBreak()
        {
            // Method accepting or not automatic page break
            if($this->col<2)
            {
                // Go to next column
                $this->SetCol($this->col+1);
                // Set ordinate to top
                $this->SetY($this->y0);
                // Keep on page
                return false;
            }
            else
            {
                // Go back to first column
                $this->SetCol(0);
                // Page break
                return true;
            }
        }
        //tabla con multicell
            function SetWidths($w)
        {
            // Set the array of column widths
            $this->widths = $w;
        }

        function SetAligns($a)
        {
            // Set the array of column alignments
            $this->aligns = $a;
        }

        function Row($data)
        {
            // Calculate the height of the row
            $nb = 0;
            for($i=0;$i<count($data);$i++)
                $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h = 5*$nb;
            // Issue a page break first if needed
            $this->CheckPageBreak($h);
            // Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
                // Save the current position
                $x = $this->GetX();
                $y = $this->GetY();
                // Draw the border
                //$this->Rect($x,$y,$w,$h);
                // Print the text
                $this->MultiCell($w,5,iconv('UTF-8', 'windows-1252', $data[$i]),0,$a);
                // Put the position to the right of the cell
                $this->SetXY($x+$w,$y);
            }
            // Go to the next line
            $this->Ln($h);
        }

        function CheckPageBreak($h)
        {
            // If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        function NbLines($w, $txt)
        {
            // Compute the number of lines a MultiCell of width w will take
            if(!isset($this->CurrentFont))
                $this->Error('No font has been set');
            $cw = $this->CurrentFont['cw'];
            if($w==0)
                $w = $this->w-$this->rMargin-$this->x;
            $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
            $s = str_replace("\r",'',(string)$txt);
            $nb = strlen($s);
            if($nb>0 && $s[$nb-1]=="\n")
                $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while($i<$nb)
            {
                $c = $s[$i];
                if($c=="\n")
                {
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep = $i;
                $l += $cw[$c];
                if($l>$wmax)
                {
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i = $sep+1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }
        
    }

?>