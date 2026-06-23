<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe IoT</title>

    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
</head>

<body>

<div class="sidebar">
    <h2>⚡ ElectroSafe</h2>
    <a href="#" onclick="showSection('dashboardSection')">🏠 Dashboard</a>
    <a href="#" onclick="showSection('medicionesSection')">📊 Mediciones</a>
    <a href="#" onclick="showSection('graficasSection')">📈 Gráficas</a>
    <a href="#" onclick="showSection('alertasSection')">⚠ Alertas</a>
</div>

<div class="main">

    <!-- DASHBOARD -->
    <div id="dashboardSection" class="section">
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="status">📶 Conectado</div>
        </div>

        <div class="grid">
            <div class="card"><h3>Voltaje</h3><h1 id="voltajeCard">--V</h1></div>
            <div class="card"><h3>Corriente</h3><h1 id="corrienteCard">--A</h1></div>
            <div class="card"><h3>Potencia</h3><h1 id="potenciaCard">--W</h1></div>
            <div class="card"><h3>Temperatura</h3><h1 id="temperaturaCard">--°C</h1></div>
            <div class="card"><h3>Humedad</h3><h1 id="humedadCard">--%</h1></div>
            <div class="card"><h3>MQ-2</h3><h1 id="mq2Card">--</h1></div>
        </div>
    </div>

    <!-- MEDICIONES -->
    <div id="medicionesSection" class="section hidden">
        <div class="topbar">
            <h1>Mediciones</h1>
        </div>

        <div class="grid">

            <div class="card sensor-card">
                <div class="sensor-header">
                    <div class="sensor-icon">⚡</div>
                    <div>
                        <h3>SCT-013</h3>
                        <p>Sensor eléctrico</p>
                    </div>
                </div>

                <div class="sensor-body">
                    <div class="sensor-item"><span>Voltaje</span><strong id="voltajeMed">--V</strong></div>
                    <div class="sensor-item"><span>Corriente</span><strong id="corrienteMed">--A</strong></div>
                    <div class="sensor-item"><span>Potencia</span><strong id="potenciaMed">--W</strong></div>
                </div>

                <div id="estadoElectrico" class="sensor-status normal">● Normal</div>
            </div>

            <div class="card sensor-card">
                <div class="sensor-header">
                    <div class="sensor-icon">🌡</div>
                    <div>
                        <h3>DHT11</h3>
                        <p>Temperatura y humedad</p>
                    </div>
                </div>

                <div class="sensor-body">
                    <div class="sensor-item"><span>Temperatura</span><strong id="temperaturaMed">--°C</strong></div>
                    <div class="sensor-item"><span>Humedad</span><strong id="humedadMed">--%</strong></div>
                    <div class="sensor-item"><span>Bochorno</span><strong id="bochornoMed">--°C</strong></div>
                </div>

                <div id="estadoDHT" class="sensor-status normal">● Normal</div>
            </div>

            <div class="card sensor-card">
                <div class="sensor-header">
                    <div class="sensor-icon">🚨</div>
                    <div>
                        <h3>MQ-2</h3>
                        <p>Detección de humo</p>
                    </div>
                </div>

                <div class="sensor-body">
                    <div class="sensor-item"><span>Valor MQ-2</span><strong id="mq2Med">--</strong></div>
                    <div class="sensor-item"><span>Riesgo</span><strong id="mq2Estado">--</strong></div>
                </div>

                <div id="estadoMQ2" class="sensor-status normal">● Normal</div>
            </div>

        </div>
    </div>

    <!-- GRÁFICAS -->
<div id="graficasSection" class="section hidden">
    <div class="topbar">
        <h1>Gráficas</h1>
    </div>

    <div class="grid">

        <div class="card large">
            <h3>Consumo Eléctrico</h3>
            <div id="consumoChart" style="width:100%;height:350px;"></div>
        </div>

        <div class="card large">
            <h3>Temperatura Histórica</h3>
            <div id="tempChart" style="width:100%;height:350px;"></div>
        </div>

        <div class="card large">
            <h3>Nivel de Humo MQ-2</h3>
            <div id="humoChart" style="width:100%;height:350px;"></div>
        </div>

        <div class="card large">
            <h3>Distribución de Alertas</h3>
            <div id="alertasChart" style="width:100%;height:350px;"></div>
        </div>

        <div class="card large">
            <h3>Índice de Riesgo</h3>
            <div id="riesgoChart" style="width:100%;height:350px;"></div>
        </div>

        <div class="card large">
            <h3>Eventos de Riesgo Combinados</h3>
            <div id="eventosChart" style="width:100%;height:350px;"></div>
        </div>

    </div>
</div>

    <!-- ALERTAS -->
    <div id="alertasSection" class="section hidden">
        <div class="topbar">
            <h1>Alertas y Control</h1>
        </div>

        <div class="grid">

            <div class="card">
                <h3>Alertas del Sistema</h3>
                <div id="listaAlertas">
                    <div class="alert info-alert">Cargando alertas...</div>
                </div>
            </div>

            <div class="card">
                <h3>Control del Relé</h3>

                <div class="rele-container">
                    <div class="rele-status">
                        <div id="releCircle" class="rele-circle"></div>

                        <div>
                            <h2 id="releTexto">--</h2>
                            <p id="releDescripcion">Estado del suministro</p>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="btn-on" onclick="controlarRele(true)">Activar</button>
                        <button class="btn-off" onclick="controlarRele(false)">Desactivar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
const API_BASE = "http://localhost:8080";

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.add('hidden');
    });

    document.getElementById(sectionId).classList.remove('hidden');

    setTimeout(() => {
        potenciaChart.resize();
        temperaturaChart.resize();
        mq2Chart.resize();
        alertasChart.resize();
        riesgoChart.resize();
        eventosChart.resize();
    }, 200);
}

/* =========================
   INICIALIZAR GRÁFICAS
========================= */

const potenciaChart = echarts.init(document.getElementById('consumoChart'));
const temperaturaChart = echarts.init(document.getElementById('tempChart'));
const mq2Chart = echarts.init(document.getElementById('humoChart'));
const alertasChart = echarts.init(document.getElementById('alertasChart'));
const riesgoChart = echarts.init(document.getElementById('riesgoChart'));
const eventosChart = echarts.init(document.getElementById('eventosChart'));

/* =========================
   TARJETAS EN TIEMPO REAL
========================= */

async function cargarRealtime() {
    try {
        const response = await fetch(`${API_BASE}/api/realtime`);
        const data = await response.json();

        const voltaje = parseFloat(data.voltaje);
        const corriente = parseFloat(data.corriente);
        const potencia = parseFloat(data.potencia);
        const temperatura = parseFloat(data.temperatura);
        const humedad = parseFloat(data.humedad);
        const mq2 = parseFloat(data.mq2);
        const bochorno = parseFloat(data.indice_bochorno);

        document.getElementById('voltajeCard').textContent = voltaje.toFixed(1) + 'V';
        document.getElementById('corrienteCard').textContent = corriente.toFixed(2) + 'A';
        document.getElementById('potenciaCard').textContent = potencia.toFixed(1) + 'W';
        document.getElementById('temperaturaCard').textContent = temperatura.toFixed(1) + '°C';
        document.getElementById('humedadCard').textContent = humedad.toFixed(1) + '%';
        document.getElementById('mq2Card').textContent = mq2;

        document.getElementById('voltajeMed').textContent = voltaje.toFixed(1) + 'V';
        document.getElementById('corrienteMed').textContent = corriente.toFixed(2) + 'A';
        document.getElementById('potenciaMed').textContent = potencia.toFixed(1) + 'W';

        document.getElementById('temperaturaMed').textContent = temperatura.toFixed(1) + '°C';
        document.getElementById('humedadMed').textContent = humedad.toFixed(1) + '%';
        document.getElementById('bochornoMed').textContent = bochorno.toFixed(1) + '°C';

        document.getElementById('mq2Med').textContent = mq2;
        document.getElementById('mq2Estado').textContent = data.nivel_riesgo;

        actualizarEstados(data);

    } catch (error) {
        console.error('Error en realtime:', error);
    }
}

function actualizarEstados(data) {
    const estadoElectrico = document.getElementById('estadoElectrico');
    const estadoDHT = document.getElementById('estadoDHT');
    const estadoMQ2 = document.getElementById('estadoMQ2');

    estadoElectrico.className = 'sensor-status normal';
    estadoElectrico.textContent = '● Normal';

    if (parseFloat(data.potencia) >= 500) {
        estadoElectrico.className = 'sensor-status warning';
        estadoElectrico.textContent = '● Alto consumo';
    }

    estadoDHT.className = 'sensor-status normal';
    estadoDHT.textContent = '● Normal';

    if (parseFloat(data.temperatura) >= 35) {
        estadoDHT.className = 'sensor-status warning';
        estadoDHT.textContent = '● Temperatura alta';
    }

    estadoMQ2.className = 'sensor-status normal';
    estadoMQ2.textContent = '● Normal';

    if (parseFloat(data.mq2) >= 700) {
        estadoMQ2.className = 'sensor-status danger';
        estadoMQ2.textContent = '● Crítico';
    }
}

/* =========================
   GRÁFICAS
========================= */

async function cargarGraficas() {
    try {
        const historialRes = await fetch(`${API_BASE}/api/historial`);
        const historial = await historialRes.json();

        const ultimos = historial.slice(-15);

        const horas = ultimos.map(item => item.fecha.substring(11, 16));
        const potencias = ultimos.map(item => parseFloat(item.potencia));
        const temperaturas = ultimos.map(item => parseFloat(item.temperatura));
        const mq2Valores = ultimos.map(item => parseFloat(item.mq2));

        // 1. Potencia histórica
        potenciaChart.setOption({
            title: { text: 'Consumo eléctrico en el tiempo' },
            tooltip: { trigger: 'axis' },
            xAxis: { type: 'category', data: horas },
            yAxis: { type: 'value', name: 'Watts' },
            series: [{
                name: 'Potencia',
                type: 'line',
                smooth: true,
                areaStyle: {},
                data: potencias
            }]
        });

        // 2. Temperatura histórica
        temperaturaChart.setOption({
            title: { text: 'Temperatura registrada' },
            tooltip: { trigger: 'axis' },
            xAxis: { type: 'category', data: horas },
            yAxis: { type: 'value', name: '°C' },
            series: [{
                name: 'Temperatura',
                type: 'line',
                smooth: true,
                data: temperaturas
            }]
        });

        // 3. MQ-2 histórico
        mq2Chart.setOption({
            title: { text: 'Niveles del sensor MQ-2' },
            tooltip: { trigger: 'axis' },
            xAxis: { type: 'category', data: horas },
            yAxis: { type: 'value', name: 'ADC' },
            series: [{
                name: 'MQ-2',
                type: 'bar',
                data: mq2Valores
            }]
        });

        // 4. Distribución de alertas
        const alertasRes = await fetch(`${API_BASE}/api/alertas`);
        const alertas = await alertasRes.json();

        const conteoAlertas = {};

        alertas.forEach(alerta => {
            if (!conteoAlertas[alerta.tipo_alerta]) {
                conteoAlertas[alerta.tipo_alerta] = 0;
            }

            conteoAlertas[alerta.tipo_alerta]++;
        });

        alertasChart.setOption({
            title: { text: 'Distribución de alertas' },
            tooltip: { trigger: 'item' },
            legend: { bottom: 0 },
            series: [{
                name: 'Alertas',
                type: 'pie',
                radius: '60%',
                data: Object.keys(conteoAlertas).map(tipo => ({
                    name: tipo,
                    value: conteoAlertas[tipo]
                }))
            }]
        });

        // 5. Índice de riesgo
        const ultimo = ultimos[ultimos.length - 1];
        const riesgoActual = ultimo ? parseFloat(ultimo.indice_riesgo) : 0;

        riesgoChart.setOption({
            title: { text: 'Nivel de riesgo actual' },
            tooltip: { formatter: '{a}<br/>{b}: {c}' },
            series: [{
                name: 'Riesgo',
                type: 'gauge',
                min: 0,
                max: 150,
                progress: { show: true },
                detail: {
                    formatter: '{value}'
                },
                data: [{
                    value: riesgoActual.toFixed(1),
                    name: 'Índice'
                }]
            }]
        });

        // 6. Relación de eventos peligrosos
        let tempMq2 = 0;
        let corrientePotencia = 0;
        let tempCorriente = 0;
        let todoAlto = 0;

        ultimos.forEach(item => {
            const tempAlta = parseFloat(item.temperatura) >= 35;
            const corrienteAlta = parseFloat(item.corriente) >= 4;
            const potenciaAlta = parseFloat(item.potencia) >= 500;
            const mq2Alto = parseFloat(item.mq2) >= 700;

            if (tempAlta && mq2Alto) {
                tempMq2++;
            }

            if (corrienteAlta && potenciaAlta) {
                corrientePotencia++;
            }

            if (tempAlta && corrienteAlta) {
                tempCorriente++;
            }

            if (tempAlta && corrienteAlta && mq2Alto) {
                todoAlto++;
            }
        });

        eventosChart.setOption({
            title: { text: 'Relación de condiciones de riesgo' },
            tooltip: { trigger: 'axis' },
            xAxis: {
                type: 'category',
                data: [
                    'Temp + MQ2',
                    'Corriente + Potencia',
                    'Temp + Corriente',
                    'Todo alto'
                ],
                axisLabel: { rotate: 20 }
            },
            yAxis: { type: 'value', name: 'Eventos' },
            series: [{
                name: 'Eventos detectados',
                type: 'bar',
                data: [
                    tempMq2,
                    corrientePotencia,
                    tempCorriente,
                    todoAlto
                ],
                label: {
                    show: true,
                    position: 'top'
                }
            }]
        });

    } catch (error) {
        console.error('Error cargando gráficas:', error);
    }
}

/* =========================
   ALERTAS
========================= */

async function cargarAlertas() {
    try {
        const response = await fetch(`${API_BASE}/api/alertas`);
        const data = await response.json();

        const contenedor = document.getElementById('listaAlertas');
        contenedor.innerHTML = '';

        const agrupadas = {};

        data.forEach(alerta => {
            const clave = alerta.tipo_alerta + '-' + alerta.nivel;

            if (!agrupadas[clave]) {
                agrupadas[clave] = {
                    tipo_alerta: alerta.tipo_alerta,
                    nivel: alerta.nivel,
                    descripcion: alerta.descripcion,
                    cantidad: 1
                };
            } else {
                agrupadas[clave].cantidad++;
            }
        });

        Object.values(agrupadas).slice(0, 6).forEach(alerta => {
            let clase = 'info-alert';

            if (alerta.nivel === 'CRITICO') {
                clase = 'danger-alert';
            } else if (alerta.nivel === 'ALTO') {
                clase = 'warning-alert';
            }

            contenedor.innerHTML += `
                <div class="alert ${clase}">
                    ⚠ ${alerta.tipo_alerta} - ${alerta.nivel}
                    <br>
                    <small>${alerta.descripcion}</small>
                    <br>
                    <strong>Eventos registrados: ${alerta.cantidad}</strong>
                </div>
            `;
        });

    } catch (error) {
        console.error('Error cargando alertas:', error);
    }
}

/* =========================
   RELÉ
========================= */

async function cargarRele() {
    try {
        const response = await fetch(`${API_BASE}/api/rele`);
        const data = await response.json();

        const circle = document.getElementById('releCircle');
        const texto = document.getElementById('releTexto');
        const descripcion = document.getElementById('releDescripcion');

        if (data.estado) {
            circle.classList.add('active');
            texto.textContent = 'ENCENDIDO';
            descripcion.textContent = 'Suministro eléctrico activo';
        } else {
            circle.classList.remove('active');
            texto.textContent = 'APAGADO';
            descripcion.textContent = 'Suministro eléctrico desconectado';
        }

    } catch (error) {
        console.error('Error cargando relé:', error);
    }
}

async function controlarRele(estado) {
    try {
        await fetch(`${API_BASE}/api/rele`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ estado: estado })
        });

        cargarRele();

    } catch (error) {
        console.error('Error controlando relé:', error);
    }
}

/* =========================
   CARGA GENERAL
========================= */

function cargarTodo() {
    cargarRealtime();
    cargarGraficas();
    cargarAlertas();
    cargarRele();
}

cargarTodo();

setInterval(cargarTodo, 5000);

window.addEventListener('resize', () => {
    potenciaChart.resize();
    temperaturaChart.resize();
    mq2Chart.resize();
    alertasChart.resize();
    riesgoChart.resize();
    eventosChart.resize();
});
</script>

</body>
</html>