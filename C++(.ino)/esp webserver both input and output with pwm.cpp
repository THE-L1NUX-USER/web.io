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

const char* JSON_get_URL = "https://webio.vo1d.cf/esp-inputs-action.php?action=inputs_state&board=1";
String SQL_update_URL = "https://webio.vo1d.cf/esp-inputs-action.php?action=inputs_update";
const char* serverName = "https://webio.vo1d.cf/esp-outputs-action.php?action=outputs_state&board=1";

const long interval = 2000;
unsigned long previousMillis = 0;

String GPIO_and_type;
String outputsState;

const int trigP = 27;  //D4 Or GPIO-2 of nodemcu
const int echoP = 14;  //D3 Or GPIO-0 of nodemcu

long duration;
int distance;

void setup() {
  pinMode(trigP, OUTPUT);  // Sets the trigPin as an Output
  pinMode(echoP, INPUT);   // Sets the echoPin as an Input
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
  digitalWrite(trigP, LOW);   // Makes trigPin low
  delayMicroseconds(2);       // 2 micro second delay 
  digitalWrite(trigP, HIGH);  // tigPin high
  delayMicroseconds(10);      // trigPin high for 10 micro seconds
  digitalWrite(trigP, LOW);   // trigPin low
  duration = pulseIn(echoP, HIGH);   //Read echo pin, time in microseconds
  distance= duration*0.034/2;        //Calculating actual/real distance
 Serial.println("distance is ");
  Serial.println(distance);
  delay(1000);
  unsigned long currentMillis = millis();
  
  if(currentMillis - previousMillis >= interval) {
    if(WiFi.status()== WL_CONNECTED ){ 
      outputsState = httpGETRequest(serverName);
      Serial.println(outputsState);
      JSONVar myObject = JSON.parse(outputsState);
      delay(500);
      GPIO_and_type = httpGETRequest(JSON_get_URL);
      Serial.println(GPIO_and_type);
      JSONVar GPIO = JSON.parse(GPIO_and_type);
      delay(100);
      if (JSON.typeof(GPIO) == "undefined") {
        Serial.println("Parsing input failed!");
        return;
      }
      delay(100);
      if (JSON.typeof(myObject) == "undefined") {
        Serial.println("Parsing output failed!");
        return;
      }
      
      Serial.print("JSON object output = ");
      Serial.println(myObject);
      delay(100);
      Serial.print("JSON object input = ");
      Serial.println(GPIO);
    
      JSONVar GPIOkeys = GPIO.keys();

      JSONVar keys = myObject.keys();

      int VALUE=0;

      for (int i = 0; i < GPIOkeys.length(); i++) {
        if (echoP==atoi(GPIOkeys[i]))
          {VALUE = distance;

        String random_unneeded_string;

        String SQL_req = SQL_update_URL+"&board=1"+"&gpio="+String(atoi(GPIOkeys[i]))+"&value="+String(VALUE)+"";
        random_unneeded_string = httpGETRequest(SQL_req.c_str());
         Serial.print("GPIO: ");
          Serial.print(atoi(GPIOkeys[i]));
          Serial.print(" gave a value= ");
          Serial.println(VALUE);
          }
        else
       {  Serial.print("pins dont match");
         Serial.print(" ");  
        }
      }


   
      for (int i = 0; i < keys.length(); i++) {
        JSONVar value = myObject[keys[i]];
        if (atoi(value)<=1) {
          Serial.print("GPIO: ");
          Serial.print(keys[i]);
          Serial.print(" - SET to: ");
          Serial.println(value);
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
          Serial.print(atoi(keys[i]));
          Serial.print(" - SET to: ");
          Serial.println((atoi(value))-2);
          #else
          analogWrite(atoi(keys[i]),((atoi(value))-2));
          Serial.print("GPIO PWM of ESP8266: ");
          Serial.print(atoi(keys[i]));
          Serial.print(" - SET to: ");
          Serial.println((atoi(value))-2);
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