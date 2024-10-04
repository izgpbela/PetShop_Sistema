<?php include("./config.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Agendamento Pet Shop">
    <title>Agendamento Pet Shop</title>

    <!-- bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- material icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-light">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom" style="position: sticky !important; top: 0 !important; z-index: 99999 !important;">
        <div class="container-fluid container">
            <a class="navbar-brand" href="#">Pet Shop</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a class="nav-link active text-sm-start text-center" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-md-4 text-white" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- form para agendamento -->
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="card-title">Agendamento de Serviços</h3>
                <p class="card-text">Preencha os dados abaixo para agendar um serviço para o seu pet.</p>

                <!-- Exibir mensagem de sucesso ou erro -->
                <?php if (isset($_GET['status'])) : ?>
                    <?php
                    if ($_GET['status'] == 'sukses')
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Sucesso!</strong> Agendamento realizado com sucesso!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    else
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Oops!</strong> O agendamento falhou!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    ?>
                <?php endif; ?>

                <form class="row g-3" action="tambah.php" method="POST">
                    <div class="col-12">
                        <label for="nome_usuario" class="form-label">Nome do Usuário</label>
                        <input type="text" name="nome_usuario" class="form-control" placeholder="Seu Nome" required>
                    </div>
                    <div class="col-12">
                        <label for="nome_pet" class="form-label">Nome do Pet</label>
                        <input type="text" name="nome_pet" class="form-control" placeholder="Nome do seu Pet" required>
                    </div>
                    <div class="col-md-4">
                        <label for="data_agendamento" class="form-label">Data do Agendamento</label>
                        <input type="date" name="data_agendamento" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="hora_agendamento" class="form-label">Hora do Agendamento</label>
                        <input type="time" name="hora_agendamento" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" value="agendar" name="agendar"><i class="fa fa-plus"></i><span class="ms-2">Agendar</span></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- título da tabela -->
        <h5 class="mb-3">Lista de Agendamentos</h5>

        <div class="table-responsive mb-5 card">
            <?php
            echo "<div class='card-body'>";
            echo "<table class='table table-hover align-middle bg-white'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col' class='text-center'>No</th>";
            echo "<th scope='col'>Nome do Usuário</th>";
            echo "<th scope='col'>Nome do Pet</th>";
            echo "<th scope='col'>Data</th>";
            echo "<th scope='col'>Hora</th>";
            echo "<th scope='col' class='text-center'>Ações</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Lógica de paginação
            $batas = 10;
            $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

            $previous = $halaman - 1;
            $next = $halaman + 1;

            $data = mysqli_query($db, "SELECT * FROM agendamentos");
            $jumlah_data = mysqli_num_rows($data);
            $total_halaman = ceil($jumlah_data / $batas);

            $data_agendamentos = mysqli_query($db, "SELECT * FROM agendamentos LIMIT $halaman_awal, $batas");
            $no = $halaman_awal + 1;

            while ($agendamento = mysqli_fetch_array($data_agendamentos)) {
                echo "<tr>";
                echo "<td class='text-center'>" . $no++ . "</td>";
                echo "<td>" . $agendamento['nome_usuario'] . "</td>";
                echo "<td>" . $agendamento['nome_pet'] . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($agendamento['data_agendamento'])) . "</td>";
                echo "<td>" . date('H:i', strtotime($agendamento['hora_agendamento'])) . "</td>";

                echo "<td class='text-center'>";
                echo "<button type='button' class='btn btn-danger deleteButton pad m-1'><span class='material-icons align-middle'>delete</span></button>";
                echo "</td>";

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            if ($jumlah_data == 0) {
                echo "<p class='text-center'>Não há agendamentos disponíveis.</p>";
            } else {
                echo "<p>Total $jumlah_data agendamentos</p>";
            }

            echo "</div>";
            ?>
        </div>

        <!-- paginação -->
        <nav class="mt-5 mb-5">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php echo ($halaman > 1) ? "href='?halaman=$previous'" : "" ?>><i class="fa fa-chevron-left"></i></a>
                </li>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                <?php
                }
                ?>
                <li class="page-item">
                    <a class="page-link" <?php echo ($halaman < $total_halaman) ? "href='?halaman=$next'" : "" ?>><i class="fa fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-2zE8wKZz0PRUVyDAEXAQ
