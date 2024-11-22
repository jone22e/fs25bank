<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login por IP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Banco Virtual</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Entrar no Sistema</h4>
                    </div>
                    <div class="card-body">
                        <form id="ipForm" action="bank.php" method="get">
                            <div class="mb-3">
                                <label for="ipInput" class="form-label">Digite o IP</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="ipInput" 
                                    name="ip" 
                                    placeholder="Exemplo: 192.168.0.1" 
                                    required
                                >
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-3 text-center mt-5">
        <p>&copy; 2024 Banco Virtual. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
