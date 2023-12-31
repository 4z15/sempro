<!DOCTYPE html>
<html>
<head>
    <title>Tampilkan PDF</title>
    <style>
        .pdf-container {
            width: 100%;
            max-width: 210mm; /* Lebar A5 */
            margin: 0 auto; /* Untuk menengahkan iframe di dalam kontainer */
        }
        .pdf-iframe {
            width: 100%;
            height: 0;
            padding-bottom: 148mm; /* Tinggi A5 */
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <iframe class="pdf-iframe" src="{{ $pdfUrl }}" frameborder="0" allowfullscreen></iframe>
    </div>
</body>
</html>
