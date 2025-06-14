<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bozum İşlemi - Kullanıcı Bilgileri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
            margin-top: 50px;
        }
        #main-header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-bottom: #77aaff 3px solid;
        }
        #main-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .card {
            background: #fff;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            display: block;
            width: 100%;
            background: #333;
            color: #fff;
            border: 0;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <header id="main-header">
        <div class="container">
            <h1>Bozum İşlemi - Kullanıcı Bilgileri</h1>
        </div>
    </header>
    <div class="container">
        <div class="card">
            <form action="odeme.php" method="POST">
                <input type="hidden" name="miktar" value="<?php echo $_POST['miktar']; ?>">
                <input type="hidden" name="net_miktar" value="<?php echo $_POST['net_miktar']; ?>">
                <input type="hidden" name="komisyon_orani" value="<?php echo $_POST['komisyon_orani']; ?>">
                
                <label for="ad">Ad:</label>
                <input type="text" id="ad" name="ad" required>
                
                <label for="soyad">Soyad:</label>
                <input type="text" id="soyad" name="soyad" required>
                
                <label for="iban">IBAN:</label>
                <input type="text" id="iban" name="iban" required>
                
                <label for="banka">Banka:</label>
                <input type="text" id="banka" name="banka" required>
                
                <button type="submit">Ödeme Yap</button>
            </form>
        </div>
    </div>
</body>
</html>
