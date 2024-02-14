<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Atenciones de Emergencia</title>
    <!-- Puedes agregar estilos adicionales aquí si lo deseas -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        .submit-btn {
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Informe de Atenciones de Emergencia</h2>
        <form action="procesar1.php" method="POST">
            <div class="form-group">
                <label for="desde" class="form-label">Fecha Desde:</label>
                <input type="date" id="desde" name="desde" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hasta" class="form-label">Fecha Hasta:</label>
                <input type="date" id="hasta" name="hasta" class="form-control" required>
            </div>
            <input type="submit" value="Generar Informe" class="submit-btn">
        </form>
    </div>
    <div class="container">
        <h2>Informe de Atenciones de Consulta Externa</h2>
        <form action="procesar2.php" method="POST">
            <div class="form-group">
                <label for="desde" class="form-label">Fecha Desde:</label>
                <input type="date" id="desde" name="desde" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hasta" class="form-label">Fecha Hasta:</label>
                <input type="date" id="hasta" name="hasta" class="form-control" required>
            </div>
            <input type="submit" value="Generar Informe" class="submit-btn">
        </form>
    </div>
</body>

</html>
