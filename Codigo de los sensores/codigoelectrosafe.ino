#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

// ---------- WIFI ----------
const char* ssid = "Andrei laptop";
const char* password = "1234567890";

// API CodeIgniter
const char* serverURL = "http://192.168.20.39:8080/api/sensores";

// ---------- DHT11 ----------
#define DHTPIN 4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// ---------- SENSORES ----------
const int pinSCT = 34;
const int pinMQ135 = 32;

// ---------- RELÉ ----------
const int pinRele = 23;

// ---------- UMBRALES ----------
float tempLimite = 28.0;
int gasLimite = 335;

// ---------- SCT-013 ----------
const float VREF = 3.3;
const int ADC_MAX = 4095;
const float FACTOR_SCT = 30.0;
const float VOLTAJE_AC = 127.0;

// Sin offset para prueba
const float OFFSET_CORRIENTE = 0.00;

void setup() {
  Serial.begin(115200);
  delay(1000);

  dht.begin();

  pinMode(pinRele, OUTPUT);
  digitalWrite(pinRele, HIGH); // Relé apagado si es activo en LOW

  WiFi.setSleep(false);
  WiFi.begin(ssid, password);

  Serial.print("Conectando a WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println();
  Serial.println("WiFi conectado");
  Serial.print("IP ESP32: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  float corriente = leerCorrienteSCT();
  float temperatura = dht.readTemperature();
  float humedad = dht.readHumidity();
  int mq135 = analogRead(pinMQ135);

  if (isnan(temperatura) || isnan(humedad)) {
    Serial.println("Error leyendo DHT11");
    delay(5000);
    return;
  }

  bool alerta = false;

  if (temperatura >= tempLimite || mq135 >= gasLimite) {
    alerta = true;
  }

  if (alerta) {
    digitalWrite(pinRele, LOW);   // Relé encendido
  } else {
    digitalWrite(pinRele, HIGH);  // Relé apagado
  }

  int estadoRele = alerta ? 1 : 0;

  Serial.println("----- Lecturas -----");

  Serial.print("Corriente: ");
  Serial.print(corriente, 3);
  Serial.println(" A");

  Serial.print("Temperatura: ");
  Serial.print(temperatura, 2);
  Serial.println(" °C");

  Serial.print("Humedad: ");
  Serial.print(humedad, 2);
  Serial.println(" %");

  Serial.print("MQ-135: ");
  Serial.println(mq135);

  Serial.print("Estado rele: ");
  Serial.println(estadoRele == 1 ? "ENCENDIDO" : "APAGADO");

  enviarDatos(
    VOLTAJE_AC,
    corriente,
    temperatura,
    humedad,
    mq135,
    estadoRele
  );

  delay(10000);
}

float leerCorrienteSCT() {
  const int muestras = 2000;

  long offset = 0;
  float suma = 0;

  int valorMin = 4095;
  int valorMax = 0;

  // Calcular punto medio real
  for (int i = 0; i < muestras; i++) {
    int valor = analogRead(pinSCT);

    offset += valor;

    if (valor < valorMin) valorMin = valor;
    if (valor > valorMax) valorMax = valor;

    delayMicroseconds(100);
  }

  float promedio = offset / (float)muestras;

  // Calcular RMS
  for (int i = 0; i < muestras; i++) {
    float lectura = analogRead(pinSCT) - promedio;
    suma += lectura * lectura;

    delayMicroseconds(100);
  }

  float adcRMS = sqrt(suma / muestras);
  float voltajeRMS = (adcRMS * VREF) / ADC_MAX;
  float corrienteRMS = voltajeRMS * FACTOR_SCT;

  corrienteRMS -= OFFSET_CORRIENTE;

  if (corrienteRMS < 0) {
    corrienteRMS = 0;
  }

  Serial.println("----- Debug SCT -----");
  Serial.print("ADC promedio: ");
  Serial.println(promedio);

  Serial.print("ADC min: ");
  Serial.println(valorMin);

  Serial.print("ADC max: ");
  Serial.println(valorMax);

  Serial.print("ADC pico-pico: ");
  Serial.println(valorMax - valorMin);

  Serial.print("ADC RMS: ");
  Serial.println(adcRMS);

  Serial.print("Voltaje RMS SCT: ");
  Serial.println(voltajeRMS, 6);

  return corrienteRMS;
}

void enviarDatos(
  float voltaje,
  float corriente,
  float temperatura,
  float humedad,
  int mq135,
  int estadoRele
) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    http.begin(serverURL);
    http.addHeader("Content-Type", "application/json");

    String json = "{";
    json += "\"voltaje\":" + String(voltaje, 2) + ",";
    json += "\"corriente\":" + String(corriente, 3) + ",";
    json += "\"temperatura\":" + String(temperatura, 2) + ",";
    json += "\"humedad\":" + String(humedad, 2) + ",";
    json += "\"mq2\":" + String(mq135) + ",";
    json += "\"estado_rele\":" + String(estadoRele);
    json += "}";

    Serial.println("JSON enviado:");
    Serial.println(json);

    int codigoHTTP = http.POST(json);

    Serial.print("Codigo HTTP: ");
    Serial.println(codigoHTTP);

    String respuesta = http.getString();
    Serial.println("Respuesta API:");
    Serial.println(respuesta);

    http.end();

  } else {
    Serial.println("WiFi desconectado");
  }
}