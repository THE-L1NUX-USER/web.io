#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif
#include <Arduino_JSON.h>

const char* ssid = " ";
const char* password = " ";

const char* serverName = "https://webio.vo1d.cf/esp-outputs-action.php?action=outputs_state&board=1";

const long interval = 5000;
unsigned long previousMillis = 0;
String outputsState;

void setup() {
  
  Serial.begin(115200);
  WiFi.begin(ssid,password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  
}

void loop() {
  

  unsigned long currentMillis = millis();
  
  if(currentMillis - previousMillis >= interval) {
    if(WiFi.status()== WL_CONNECTED ){ 
      outputsState = httpGETRequest(serverName);
      Serial.println(outputsState);
      JSONVar myObject = JSON.parse(outputsState);
      
  
      if (JSON.typeof(myObject) == "undefined") {
        Serial.println("Parsing output failed!");
        return;
      }
      
      Serial.print("JSON object output = ");
      Serial.println(myObject);

      JSONVar keys = myObject.keys();

      for (int i = 0; i < keys.length(); i++) {
        JSONVar value = myObject[keys[i]];
        if (atoi(value)<=1) {
          Serial.print("GPIO: ");
          Serial.print(atoi(keys[i]));
          Serial.print(" - SET to: ");
          Serial.println(atoi(value));
          pinMode(atoi(keys[i]), OUTPUT);
          digitalWrite(atoi(keys[i]), atoi(value));
        }else if(atoi(value)>=2 && atoi(value)<=257){
          #ifdef ESP32
          // attach the channel to the GPIO to be controlled
          // setting PWM properties
          const int freq = 5000;
          const int ledChannel = 0;
          const int resolution = 8;
          ledcSetup(ledChannel, freq, resolution);
          ledcAttachPin(atoi(keys[i]), ledChannel);
          ledcWrite(ledChannel, ((atoi(value))-2));
          Serial.print("GPIO PWM of ESP32: ");
          Serial.print(keys[i]);
          Serial.print(" - SET to: ");
          Serial.println(((atoi(value))-2));
          #else
          analogWrite(atoi(keys[i]),((atoi(value))-2));
          Serial.print("GPIO PWM of ESP8266: ");
          Serial.print(keys[i]);
          Serial.print(" - SET to: ");
          Serial.println(((atoi(value))-2));
          #endif
        }
      }
      previousMillis = currentMillis;
    }
    else {
      Serial.println("WiFi Disconnected");
    }
  }
}

String httpGETRequest(const char* serverName) {
  #ifdef ESP32
  HTTPClient http; 
  http.begin(serverName);
  #else
  WiFiClient client;
  HTTPClient http;
  // Your IP address with path or Domain name with URL path 
  http.begin(client, serverName);
  #endif 
  // Send HTTP POST request
  int httpResponseCode = http.GET();
  
  String payload = "{}"; 
  
  if (httpResponseCode>0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.print("Error code: ");
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}