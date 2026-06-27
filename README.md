# ⚡ ElectroSafe IoT

## Descripción del Proyecto

Sistema IoT para monitoreo y protección eléctrica basado en ESP32, sensores ambientales y una API REST desarrollada en CodeIgniter.

## Objetivo General

Monitorear variables eléctricas y ambientales en tiempo real, generar alertas y controlar un relé para prevenir condiciones de riesgo.

## Tecnologías Utilizadas

- ESP32
- PHP
- CodeIgniter 4
- MySQL
- HTML
- CSS
- JavaScript
- Vite
- Chart.js
- Arduino IDE

## Sensores y Actuadores

- SCT-013
- MQ-2
- DHT11
- Relé
- LEDs indicadores

## Capturas de Pantalla

Pendiente de agregar capturas una vez finalizado el desarrollo.

## Diagrama de Arquitectura

ESP32 → API REST → MySQL → Dashboard Web

## Instrucciones de Ejecución y configuracion
1. Instalar las dependencias de PHP:

```bash
composer install
```

2. Instalar las dependencias de Node.js:

```bash
npm install
```

3. Configurar el archivo `.env`:

```env
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = electrosafe_iot
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> **Nota:** Si el proyecto se utilizará junto con un ESP32 en la misma red local, será necesario cambiar `localhost` por la dirección IP del equipo donde se ejecuta el servidor (por ejemplo, `http://192.168.20.39:8080/`).

4. Ejecutar las migraciones:

```bash
php spark migrate
```

5. (Opcional) Ejecutar los seeders:

```bash
php spark db:seed MedicionesSeeder
php spark db:seed AlertasSeeder
```

6. Iniciar el servidor:

```bash
php spark serve
```

7. (Opcional, durante desarrollo) Iniciar Vite:

```bash
npm run dev
```

