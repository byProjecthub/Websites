<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TCPDF;

function generateInvoicePDF(array $invoice, array $client): string {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    $pdf->SetCreator('Vueports Solutions');
    $pdf->SetAuthor('Vueports Solutions');
    $pdf->SetTitle('Invoice #' . $invoice['invoice_number']);
    
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(15, 15, 15);
    
    $pdf->AddPage();
    
    // Colors
    $primary = [79, 70, 229];
    $dark = [24, 24, 27];
    $gray = [82, 82, 91];
    
    // Header
    $pdf->SetFont('helvetica', 'B', 22);
    $pdf->SetTextColor($primary[0], $primary[1], $primary[2]);
    $pdf->Cell(0, 12, 'Vueports Solutions', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor($gray[0], $gray[1], $gray[2]);
    $pdf->Cell(0, 5, 'Johannesburg, South Africa', 0, 1, 'L');
    $pdf->Cell(0, 5, 'Reg: 2020/123456/07 | VAT: 4120245632', 0, 1, 'L');
    $pdf->Cell(0, 5, getSetting('contact_email', 'njabulod.hlongwane@gmail.com'), 0, 1, 'L');
    $pdf->Ln(8);
    
    // Invoice title
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetTextColor($dark[0], $dark[1], $dark[2]);
    $pdf->Cell(0, 10, 'TAX INVOICE', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(90, 5, 'Invoice #: ' . $invoice['invoice_number'], 0, 0, 'L');
    $pdf->Cell(0, 5, 'Date: ' . date('j F Y', strtotime($invoice['created_at'])), 0, 1, 'R');
    $pdf->Cell(90, 5, 'Due Date: ' . date('j F Y', strtotime($invoice['due_date'])), 0, 1, 'L');
    $pdf->Ln(4);
    
    // Bill to
    $pdf->SetFillColor(244, 244, 245);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 7, 'BILL TO', 0, 1, 'L', true);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, $client['full_name'], 0, 1, 'L');
    if ($client['company']) $pdf->Cell(0, 5, $client['company'], 0, 1, 'L');
    $pdf->Cell(0, 5, $client['email'], 0, 1, 'L');
    if ($client['phone']) $pdf->Cell(0, 5, $client['phone'], 0, 1, 'L');
    $pdf->Ln(6);
    
    // Items table
    $pdf->SetFillColor($primary[0], $primary[1], $primary[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(110, 8, 'Description', 1, 0, 'C', true);
    $pdf->Cell(25, 8, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Amount', 1, 1, 'C', true);
    
    $pdf->SetTextColor($dark[0], $dark[1], $dark[2]);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(110, 8, $invoice['description'] ?: 'Professional IT Services', 1, 0, 'L');
    $pdf->Cell(25, 8, '1', 1, 0, 'C');
    $pdf->Cell(40, 8, 'R ' . number_format((float)$invoice['amount'], 2), 1, 1, 'R');
    
    // Totals
    $pdf->Ln(4);
    $subtotal = (float)$invoice['amount'] / 1.15;
    $vat = (float)$invoice['amount'] - $subtotal;
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(135, 6, 'Subtotal', 0, 0, 'R');
    $pdf->Cell(0, 6, 'R ' . number_format($subtotal, 2), 0, 1, 'R');
    
    $pdf->Cell(135, 6, 'VAT (15%)', 0, 0, 'R');
    $pdf->Cell(0, 6, 'R ' . number_format($vat, 2), 0, 1, 'R');
    
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetTextColor($primary[0], $primary[1], $primary[2]);
    $pdf->Cell(135, 8, 'TOTAL', 0, 0, 'R');
    $pdf->Cell(0, 8, 'R ' . number_format((float)$invoice['amount'], 2), 0, 1, 'R');
    
    // Payment info
    $pdf->Ln(6);
    $pdf->SetTextColor($gray[0], $gray[1], $gray[2]);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 4, 'Payment Options:', 0, 1, 'L');
    $pdf->Cell(0, 4, '- PayFast (Instant EFT, Card, SnapScan)', 0, 1, 'L');
    $pdf->Cell(0, 4, '- Bank Transfer: FNB 62345678901', 0, 1, 'L');
    $pdf->Cell(0, 4, '- Reference: ' . $invoice['invoice_number'], 0, 1, 'L');
    
    // Save
    $filename = 'invoice_' . $invoice['invoice_number'] . '.pdf';
    $path = __DIR__ . '/../uploads/invoices/' . $filename;
    
    if (!is_dir(dirname($path))) mkdir(dirname($path), 0755, true);
    
    $pdf->Output($path, 'F');
    return $path;
}