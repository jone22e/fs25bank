<?php
$ip = $_GET['ip'] ?? null; // Obtém o IP da URL
$dados = [];

// Verifica se o IP foi fornecido e se o arquivo JSON correspondente existe
if ($ip && file_exists($_SERVER['DOCUMENT_ROOT'] ."/servers/$ip.json")) {
    $conteudoJson = file_get_contents($_SERVER['DOCUMENT_ROOT'] ."/servers/$ip.json");
    $dados = json_decode($conteudoJson, true); // Decodifica o JSON em um array associativo
} else {
    $erro = "Arquivo não encontrado ou IP inválido!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Banco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Banco Virtual</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Transações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Configurações</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Bem-vindo(a)!</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="bank.php">
                                <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
                                <div class="mb-3">
                                    <label for="fazenda" class="form-label">Selecione uma Fazenda</label>
                                    <select name="fazenda" id="fazenda" class="form-select" required>
                                        <option value="" disabled selected>Escolha...</option>
                                        <?php foreach ($dados as $fazenda): ?>
                                            <option value="<?= htmlspecialchars($fazenda['nome']) ?>"
                                                <?= isset($_GET['fazenda']) && $_GET['fazenda'] === $fazenda['nome'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($fazenda['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Ver Saldo</button>
                            </form>

                            <?php
                            if (isset($_GET['fazenda'])):
                                $fazendaSelecionada = $_GET['fazenda'];
                                $saldo = null;
                                foreach ($dados as $fazenda) {
                                    if ($fazenda['nome'] === $fazendaSelecionada) {
                                        $saldo = $fazenda['saldo'];
                                        break;
                                    }
                                }
                            ?>
                                <?php if ($saldo !== null): ?>
                                    <div class="alert alert-success mt-3 text-center">
                                        Saldo da Fazenda <strong><?= htmlspecialchars($fazendaSelecionada) ?></strong>: 
                                        <span class="text-success">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning mt-3 text-center">
                                        Fazenda não encontrada!
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-light py-3 text-center mt-5">
        <p>&copy; 2024 Banco Virtual. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
