<?php
require_once 'dompdf/autoload.inc.php';
require_once 'helper/koneksi-db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$html = '<style>
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #dee2e6;
            }
            
            th {
                border: 1px solid #dee2e6;
                padding: 8px;
                text-align: left;
                background-color: #f8f9fa;
            }
            
            td {
                border: 1px solid #dee2e6;
                padding: 8px;
            }
            
            tbody tr:nth-child(odd) {
                background-color: #f8f9fa; 
            }
            .title {
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .address {
                font-size: 14px;
                color: #777;
            }
            h6 {
                font-size: 15px;
                font-weight: bold;
                text-align: center;
                margin-top: 20px;
            }
            hr {
                border: none;
                border-top: 2px solid #ddd;
                margin: 10px 0;
            }
            .lpr {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
            }
        </style>';
$html .= '<div class="header">
                <div class="title">
                SISTEM INFORMASI
                <p>STOK BARANG Alex Cell</p>
                </div>
                <div class="address">Jl. Adisucipto Penfui, PO Box 139 Kupang - NTT
                Telp./Fax : (0380) 881245 - 881246, Fleksi : 8031590, Website : <a href="https://pnk.ac.id/" target="_blank">www.pnk.ac.id</a>
                </div>
                <hr>
                <br>
                <div class="lpr">
                    LAPORAN DATA STOK BARANG
                </div>
                </div>';

if (mysqli_num_rows($result) > 0) {
    $html .= '<table style="width:100%;">';
    $html .= '<thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>';
    $html .= '<tbody>';
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $row['nama_barang'] . '</td>
                    <td>' . $row['stok'] . '</td>
                    <td>' . $row['deskripsi'] . '</td>
                </tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
} else {
    $html .= '<p class="text-center">Blum ada Stock Perangkat yg terdata.</p>';
}

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('data_stok_perangkat.pdf', ['Attachment' => false]);
