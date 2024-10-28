<?php

namespace App\Service;

use TCPDF;

class PdfService
{
    public function generatePdf(string $htmlContent, string $fileName): void
    {
        // Création d'une instance de TCPDF
        $pdf = new TCPDF();

        // Définir les informations de base du document
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Document Title');
        $pdf->SetSubject('Document Subject');

        // Définir la police par défaut
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Définir les marges
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Ajouter une page
        $pdf->AddPage();

        // Écrire du contenu HTML
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Télécharger le PDF
        $pdf->Output($fileName, 'I');
    }
}
