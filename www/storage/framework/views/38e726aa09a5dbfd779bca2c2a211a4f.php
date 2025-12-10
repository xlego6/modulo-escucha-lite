

<?php $__env->startSection('title', 'Mapa de Entrevistas'); ?>
<?php $__env->startSection('content_header', 'Mapa de Entrevistas'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #mapa {
        height: 500px;
        width: 100%;
        border-radius: 4px;
    }
    .info-legend {
        padding: 6px 8px;
        background: white;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
    }
    .info-legend h4 {
        margin: 0 0 5px;
        color: #777;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin: 3px 0;
    }
    .legend-color {
        width: 18px;
        height: 18px;
        margin-right: 8px;
        border-radius: 50%;
    }
    .marker-cluster {
        background-color: rgba(235, 192, 26, 0.6);
    }
    .marker-cluster div {
        background-color: rgba(235, 192, 26, 0.8);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Estadisticas -->
    <div class="col-md-3">
        <div class="info-box bg-primary">
            <span class="info-box-icon"><i class="fas fa-microphone"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Entrevistas</span>
                <span class="info-box-number" id="stat-total">-</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Departamentos</span>
                <span class="info-box-number" id="stat-deptos">-</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-chart-bar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Mayor Concentracion</span>
                <span class="info-box-number" id="stat-max">-</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-globe-americas"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cobertura</span>
                <span class="info-box-number" id="stat-cobertura">-</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map mr-2"></i>Distribucion Geografica</h3>
            </div>
            <div class="card-body p-0">
                <div id="mapa"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ol mr-2"></i>Entrevistas por Departamento</h3>
            </div>
            <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped table-sm" id="tabla-departamentos">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">
                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-info" id="card-detalle" style="display: none;">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Detalle: <span id="detalle-nombre"></span></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="cerrarDetalle()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                <div id="detalle-contenido"></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var mapa;
var marcadores = [];

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar mapa centrado en Colombia
    mapa = L.map('mapa').setView([4.5, -74.0], 5);

    // Capa base de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    // Cargar datos
    cargarDatos();
});

function cargarDatos() {
    fetch('<?php echo e(route("mapa.datos")); ?>')
        .then(response => response.json())
        .then(data => {
            // Actualizar estadisticas
            document.getElementById('stat-total').textContent = data.estadisticas.total_entrevistas.toLocaleString();
            document.getElementById('stat-deptos').textContent = data.estadisticas.total_departamentos;
            document.getElementById('stat-max').textContent = data.estadisticas.max_entrevistas.toLocaleString();
            document.getElementById('stat-cobertura').textContent = Math.round(data.estadisticas.total_departamentos / 33 * 100) + '%';

            // Agregar marcadores
            agregarMarcadores(data.datos, data.estadisticas.max_entrevistas);

            // Llenar tabla
            llenarTabla(data.datos);
        })
        .catch(error => {
            console.error('Error cargando datos:', error);
        });
}

function agregarMarcadores(datos, maxEntrevistas) {
    datos.forEach(function(item) {
        var radio = Math.max(10, Math.min(40, (item.total / maxEntrevistas) * 40));

        var marker = L.circleMarker([item.lat, item.lng], {
            radius: radio,
            fillColor: '#EBC01A',
            color: '#000',
            weight: 1,
            opacity: 1,
            fillOpacity: 0.7
        }).addTo(mapa);

        marker.bindPopup(
            '<strong>' + item.nombre + '</strong><br>' +
            'Entrevistas: <b>' + item.total + '</b><br>' +
            '<a href="javascript:verDetalle(' + item.id + ')">Ver detalle</a>'
        );

        marker.on('click', function() {
            verDetalle(item.id);
        });

        marcadores.push(marker);
    });
}

function llenarTabla(datos) {
    var tbody = document.querySelector('#tabla-departamentos tbody');
    tbody.innerHTML = '';

    // Ordenar por total descendente
    datos.sort((a, b) => b.total - a.total);

    if (datos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">No hay datos</td></tr>';
        return;
    }

    datos.forEach(function(item, index) {
        var tr = document.createElement('tr');
        tr.style.cursor = 'pointer';
        tr.onclick = function() { verDetalle(item.id); centrarMapa(item.lat, item.lng); };
        tr.innerHTML = '<td>' + (index + 1) + '. ' + item.nombre + '</td>' +
                      '<td class="text-right"><span class="badge badge-primary">' + item.total + '</span></td>';
        tbody.appendChild(tr);
    });
}

function centrarMapa(lat, lng) {
    mapa.setView([lat, lng], 7);
}

function verDetalle(id) {
    document.getElementById('card-detalle').style.display = 'block';
    document.getElementById('detalle-contenido').innerHTML = '<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';

    fetch('<?php echo e(url("mapa/departamento")); ?>/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detalle-nombre').textContent = data.departamento;

            var html = '<table class="table table-sm mb-0">';

            if (data.municipios && data.municipios.length > 0) {
                html += '<thead><tr><th colspan="2" class="bg-light">Municipios con mas entrevistas</th></tr></thead>';
                html += '<tbody>';
                data.municipios.forEach(function(mun) {
                    var nombre = mun.rel_lugar_hechos ? mun.rel_lugar_hechos.descripcion : 'Sin municipio';
                    html += '<tr><td>' + nombre + '</td><td class="text-right"><span class="badge badge-info">' + mun.total + '</span></td></tr>';
                });
                html += '</tbody>';
            }

            html += '</table>';

            if (data.entrevistas && data.entrevistas.length > 0) {
                html += '<div class="p-2 bg-light"><strong>Ultimas entrevistas:</strong></div>';
                html += '<ul class="list-group list-group-flush">';
                data.entrevistas.slice(0, 5).forEach(function(ent) {
                    html += '<li class="list-group-item p-2">';
                    html += '<small class="text-muted">' + ent.entrevista_codigo + '</small><br>';
                    html += '<a href="<?php echo e(url("entrevistas")); ?>/' + ent.id_e_ind_fvt + '">' + (ent.titulo || 'Sin titulo') + '</a>';
                    html += '</li>';
                });
                html += '</ul>';
            }

            document.getElementById('detalle-contenido').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('detalle-contenido').innerHTML = '<div class="alert alert-danger m-2">Error cargando detalle</div>';
        });
}

function cerrarDetalle() {
    document.getElementById('card-detalle').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/mapa/index.blade.php ENDPATH**/ ?>