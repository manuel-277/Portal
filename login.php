<?php
// Usa o sistema centralizado de configurações
include 'configuracoes.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = t('login_error_fields');
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nome'];
                // Opcional: $_SESSION['user_avatar'] = ...;
                header("Location: index.php");
                exit();
            } else {
                $erro = t('login_error_invalid');
            }
        } catch (Exception $e) {
            error_log("Erro no login: " . $e->getMessage());
            $erro = t('login_error_generic');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Portal de Turismo de Angola</title>
    <meta name="description" content="Acesse sua conta no Portal de Turismo de Angola.">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #004d40;
            --secondary: #159f5f;
            --accent: #f59e0b;
        }
        
        body {
            background: linear-gradient(135deg, #f0fdf4, #e0f2fe);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }
        
        .login-card {
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            border: none;
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
        }
        
        .card-header img {
            height: 60px;
            margin-bottom: 1rem;
            border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .card-header h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0;
        }
        
        .card-body {
            padding: 2.2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 1px solid #cbd5e1;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(21, 159, 95, 0.15);
        }
        
        .btn-login {
            background: var(--secondary);
            border: none;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 10px;
            transition: all 0.25s;
        }
        
        .btn-login:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(21, 159, 95, 0.3);
        }
        
        .text-accent {
            color: var(--accent) !important;
            font-weight: 600;
        }
        
        .alert-custom {
            border-radius: 10px;
            padding: 0.8rem 1.2rem;
            margin-bottom: 1.5rem;
            border: none;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 1.8rem 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card login-card">
                    <div class="card-header">
                        <img src="assets/logo.png" alt="Logotipo do Portal de Turismo de Angola">
                        <h2>Portal de Turismo de Angola</h2>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center mb-4 fw-bold" style="color: var(--primary);">Bem-vindo de volta!</h3>
                        <p class="text-center mb-4">Faça login para acessar sua conta e personalizar sua experiência.</p>
                        
                        <?php if ($erro): ?>
                            <div class="alert alert-danger alert-custom d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= htmlspecialchars($erro) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #f1f5f9; border: 1px solid #cbd5e1;">
                                        <i class="fas fa-envelope" style="color: #64748b;"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           placeholder="exemplo@angola.ao" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="senha" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #f1f5f9; border: 1px solid #cbd5e1;">
                                        <i class="fas fa-lock" style="color: #64748b;"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="senha" 
                                           name="senha" 
                                           placeholder="Mínimo 4 caracteres" 
                                           minlength="4" 
                                           required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100 mb-3">Entrar</button>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-0">Não tem uma conta? <a href="cadastro.php" class="text-accent">Cadastre-se gratuitamente</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>