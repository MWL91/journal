<html>
<head>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;
            margin: 50px 20%;
        }

        textarea {
            border: 1px solid #ccc;
            font-family: Georgia, serif;
            width: 100%;
            font-size: 16px;
        }

        .hcolor {
            color:#FF0000;
        }
        </style>
</head>
<body>
    <h1 class="hcolor">Analiza dziennika:</h1>
    <form method="post" action="/">
        <textarea name="inputFromDairy" rows="10" cols="100"><?php echo $inputFromDairy; ?></textarea>
        <button type="submit">Wyślij</button>
    </form>

    <?php if($responseData): ?>
        <h1>Wynik:</h1>
        <pre><?php echo ($responseData?->choices[0]?->message?->content); ?></pre>
    <?php endif; ?>
</body>
</html>