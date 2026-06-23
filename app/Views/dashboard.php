<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ElectroSafe IoT</title>

    <!-- VITE -->
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>⚡ ElectroSafe</h2>

        <a href="#" onclick="showSection('dashboardSection')">
            🏠 Dashboard
        </a>

        <a href="#" onclick="showSection('medicionesSection')">
            📊 Mediciones
        </a>

        <a href="#" onclick="showSection('graficasSection')">
            📈 Gráficas
        </a>

        <a href="#" onclick="showSection('alertasSection')">
            ⚠ Alertas
        </a>

    </div>

    <!-- MAIN -->

    <div class="main">

        <!-- DASHBOARD -->

        <div id="dashboardSection" class="section">

            <div class="topbar">

                <h1>Dashboard</h1>

                <div class="status">
                    📶 Conectado
                </div>

            </div>

            <div class="grid">

                <div class="card">
                    <h3>Voltaje</h3>
                    <h1>127V</h1>
                </div>

                <div class="card">
                    <h3>Corriente</h3>
                    <h1>4.2A</h1>
                </div>

                <div class="card">
                    <h3>Potencia</h3>
                    <h1>530W</h1>
                </div>

                <div class="card">
                    <h3>Temperatura</h3>
                    <h1>35°C</h1>
                </div>

                <div class="card">
                    <h3>Humedad</h3>
                    <h1>65%</h1>
                </div>

                <div class="card">
                    <h3>MQ-2</h3>
                    <h1>720</h1>
                </div>

            </div>

        </div>

        <!-- MEDICIONES -->

        <div id="medicionesSection" class="section hidden">

            <div class="topbar">

                <h1>Mediciones</h1>

            </div>

            <div class="grid">

                <!-- SENSOR ELECTRICO -->

                <div class="card sensor-card">

                    <div class="sensor-header">

                        <div class="sensor-icon">
                            ⚡
                        </div>

                        <div>

                            <h3>PZEM-004T</h3>

                            <p>Sensor eléctrico</p>

                        </div>

                    </div>

                    <div class="sensor-body">

                        <div class="sensor-item">
                            <span>Voltaje</span>
                            <strong>127V</strong>
                        </div>

                        <div class="sensor-item">
                            <span>Corriente</span>
                            <strong>4.2A</strong>
                        </div>

                        <div class="sensor-item">
                            <span>Potencia</span>
                            <strong>530W</strong>
                        </div>

                    </div>

                    <div class="sensor-status normal">
                        ● Normal
                    </div>

                </div>

                <!-- DHT11 -->

                <div class="card sensor-card">

                    <div class="sensor-header">

                        <div class="sensor-icon">
                            🌡
                        </div>

                        <div>

                            <h3>DHT11</h3>

                            <p>Temperatura y humedad</p>

                        </div>

                    </div>

                    <div class="sensor-body">

                        <div class="sensor-item">
                            <span>Temperatura</span>
                            <strong>35°C</strong>
                        </div>

                        <div class="sensor-item">
                            <span>Humedad</span>
                            <strong>65%</strong>
                        </div>

                        <div class="sensor-item">
                            <span>Bochorno</span>
                            <strong>41°C</strong>
                        </div>

                    </div>

                    <div class="sensor-status warning">
                        ● Alto
                    </div>

                </div>

                <!-- MQ2 -->

                <div class="card sensor-card">

                    <div class="sensor-header">

                        <div class="sensor-icon">
                            🚨
                        </div>

                        <div>

                            <h3>MQ-2</h3>

                            <p>Detección de humo</p>

                        </div>

                    </div>

                    <div class="sensor-body">

                        <div class="sensor-item">
                            <span>Valor MQ-2</span>
                            <strong>720</strong>
                        </div>

                        <div class="sensor-item">
                            <span>Estado</span>
                            <strong>Crítico</strong>
                        </div>

                    </div>

                    <div class="sensor-status danger">
                        ● Crítico
                    </div>

                </div>

            </div>

        </div>

        <!-- GRAFICAS -->

        <div id="graficasSection" class="section hidden">

            <div class="topbar">

                <h1>Gráficas</h1>

            </div>

            <div class="grid">

                <!-- CONSUMO -->

                <div class="card large">

                    <h3>Consumo Eléctrico</h3>

                    <div class="chart-container">

                        <canvas id="consumoChart"></canvas>

                    </div>

                </div>

                <!-- MQ2 -->

                <div class="card large">

                    <h3>Nivel de Humo MQ-2</h3>

                    <div class="chart-container">

                        <canvas id="humoChart"></canvas>

                    </div>

                </div>

                <!-- TEMPERATURA -->

                <div class="card large">

                    <h3>Temperatura</h3>

                    <div class="chart-container">

                        <canvas id="tempChart"></canvas>

                    </div>

                </div>

                <!-- HUMEDAD -->

                <div class="card large">

                    <h3>Humedad</h3>

                    <div class="chart-container">

                        <canvas id="humedadChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

        <!-- ALERTAS -->

        <div id="alertasSection" class="section hidden">

            <div class="topbar">

                <h1>Alertas y Control</h1>

            </div>

            <div class="grid">

                <!-- ALERTAS -->

                <div class="card">

                    <h3>Alertas del Sistema</h3>

                    <div class="alert danger-alert">
                        🚨 Humo detectado por MQ-2
                    </div>

                    <div class="alert warning-alert">
                        ⚠ Sobreconsumo eléctrico
                    </div>

                    <div class="alert info-alert">
                        🌡 Temperatura elevada
                    </div>

                </div>

                <!-- RELE -->

                <div class="card">

                    <h3>Control del Relé</h3>

                    <div class="rele-container">

                        <div class="rele-status">

                            <div class="rele-circle active"></div>

                            <div>

                                <h2>ENCENDIDO</h2>

                                <p>Suministro eléctrico activo</p>

                            </div>

                        </div>

                        <div class="buttons">

                            <button class="btn-on">
                                Activar
                            </button>

                            <button class="btn-off">
                                Desactivar
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- JS -->

    <script>

        /* MENU */

        function showSection(sectionId){

            const sections =
            document.querySelectorAll('.section');

            sections.forEach(section => {

                section.classList.add('hidden');

            });

            document
            .getElementById(sectionId)
            .classList.remove('hidden');
        }

        /* CHART CONSUMO */

        const consumoCtx =
        document.getElementById('consumoChart');

        new Chart(consumoCtx, {

            type:'line',

            data:{

                labels:[
                    '8AM',
                    '10AM',
                    '12PM',
                    '2PM',
                    '4PM',
                    '6PM'
                ],

                datasets:[{

                    label:'Watts',

                    data:[320,450,380,520,610,480],

                    borderColor:'#2563eb',

                    backgroundColor:'rgba(37,99,235,0.2)',

                    fill:true,

                    tension:0.4
                }]
            }
        });

        /* MQ2 */

        const humoCtx =
        document.getElementById('humoChart');

        new Chart(humoCtx, {

            type:'bar',

            data:{

                labels:[
                    'Lun',
                    'Mar',
                    'Mie',
                    'Jue',
                    'Vie'
                ],

                datasets:[{

                    label:'MQ-2',

                    data:[300,450,500,720,430],

                    backgroundColor:[
                        '#60a5fa',
                        '#3b82f6',
                        '#2563eb',
                        '#1d4ed8',
                        '#1e40af'
                    ]
                }]
            }
        });

        /* TEMPERATURA */

        const tempCtx =
        document.getElementById('tempChart');

        new Chart(tempCtx, {

            type:'line',

            data:{

                labels:[
                    '8AM',
                    '10AM',
                    '12PM',
                    '2PM',
                    '4PM'
                ],

                datasets:[{

                    label:'Temperatura °C',

                    data:[28,30,33,35,31],

                    borderColor:'#0ea5e9',

                    backgroundColor:'rgba(14,165,233,0.2)',

                    fill:true,

                    tension:0.4
                }]
            }
        });

        /* HUMEDAD */

        const humedadCtx =
        document.getElementById('humedadChart');

        new Chart(humedadCtx, {

            type:'doughnut',

            data:{

                labels:[
                    'Humedad',
                    'Restante'
                ],

                datasets:[{

                    data:[65,35],

                    backgroundColor:[
                        '#38bdf8',
                        '#dbeafe'
                    ]
                }]
            }
        });

    </script>

</body>

</html>