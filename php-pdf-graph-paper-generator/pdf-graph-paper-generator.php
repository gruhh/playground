<?php
/**
 * PDF Graph Paper Generator
 *
 * To use you HAVE TO download FPDF at http://www.fpdf.org/
 * just add the fpdf.php to fpdf folder.
 *
 * To generate a simple graph paper, execute
 * pdf-graph-paper-generator.php
 *
 *
 * You can customize the graph paper, execute
 * pdf-graph-paper-generator.php?paperSize=A4&margin=10&size=5&color=lightGrey
 *
 * string paperSize is the paper size, like A3, A4, A5, Letter, Legal
 * int margin is the margin of the paper, like 1, 5, 10
 * int size is the graph size, like 5, 8, 10
 * string color is the color of the line, and is a value of the $colors array, like lightBlue, lightRed
 */

require('fpdf/fpdf.php');

class GraphPaperPDF extends FPDF
{
    private $lineColor;
    private $graphSize = 1;

    private $colors = [
        "darkGrey" => array(161, 161, 161),
        "darkBlue" => array(199, 217, 255),
        "darkRed" => array(255, 199, 199),
        "lightGrey" => array(222, 222, 222),
        "lightBlue" => array(222, 237, 252),
        "lightRed" => array(250, 235, 242)
    ];

    /**
     * @param $lineColor
     */
    function SetLineColor($lineColor): void
    {
        // Check if the color exists in the array of colors
        if (!array_key_exists($lineColor, $this->colors)) {
            $this->lineColor = "lightGrey";
            return;
        }

        $this->lineColor = $lineColor;
    }

    /**
     * @param int $size
     */
    function SetGraphSize(int $size): void
    {
        $this->graphSize = $size;
    }

    function GenerateGraphPaper()
    {
        // Get the size of the content
        $paperWidth = $this->GetPageWidth() - $this->rMargin - $this->lMargin;
        $paperHeight = $this->GetPageHeight() - $this->tMargin * 2;

        // Calculate the fit
        $columns = floor($paperWidth / $this->graphSize);
        $rows = floor($paperHeight / $this->graphSize);

        // Set the line color
        $this->SetDrawColor(
            $this->colors[$this->lineColor][0],
            $this->colors[$this->lineColor][1],
            $this->colors[$this->lineColor][2]
        );

        // Generate the cells of the graph paper
        for($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                // Add each cell
                $this->Cell($this->graphSize, $this->graphSize, '', 1);
            }
            // Add a new line
            $this->Ln();
        }
    }
}

// Customization variables
$paperSize = !empty($_GET['paperSize']) ? (string) $_GET['paperSize'] : "A4";
$margins = !empty($_GET['margin']) ? (int) $_GET['margin'] : 10;
$graphSize = !empty($_GET['size']) ? (int) $_GET['size'] : 5;
$lineColor = !empty($_GET['color']) ? (string) $_GET['color'] : "lightGrey";

// Execution
$pdf = new GraphPaperPDF('P', 'mm', $paperSize);
$pdf->SetMargins($margins, $margins, $margins);
$pdf->SetAutoPageBreak($margins);
$pdf->SetGraphSize($graphSize);
$pdf->SetLineWidth(.01);
$pdf->SetLineColor($lineColor);
$pdf->AddPage();
$pdf->GenerateGraphPaper();
$pdf->Output();
