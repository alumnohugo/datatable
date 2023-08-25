<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-lg">
    <a class="navbar-brand" href="/datatable/menu">Menú Principal</a>

    <!-- Enlaces del menú -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/datatable/clientes">Datatable</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/datatable/clientes/estadistica">Estadistica</a>
            </li>
        </ul>
    </div>
    <a href="/datatable/logout" class="btn btn-danger">Cerrar sesión</a>
</nav>

<h1>ESTADISTICAS DE CLIENTES</h1>
<button id="btnActualizar" class="btn btn-info">Actualizar</button>
<div class="row">
    <div class="col-lg-4">
        <canvas id="chartVentas" width="100%"></canvas>
    </div>
</div>
<script src="<?=asset('./build/js/clientes/estadistica.js') ?>"></script>