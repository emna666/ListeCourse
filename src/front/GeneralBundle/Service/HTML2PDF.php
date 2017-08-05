<?php

namespace front\GeneralBundle\Service;

class HTML2PDF
{
    private $pdf;

    public function create()
    {
        $this->pdf = new \Spipu\Html2Pdf\Html2Pdf();
    }

    public function generatePdf($template,$name)
    {
        $this->pdf->writeHTML($template);
        return $this->pdf->output($name.".pdf");
    }
}